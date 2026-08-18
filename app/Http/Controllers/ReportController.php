<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Category;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        // Thống kê theo trạng thái
        $statusStats = Ticket::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get()
            ->pluck('total', 'status')
            ->toArray();

        // Thống kê theo danh mục
        $categoryStats = Category::withCount('tickets')->get();

        // Ticket theo tháng (6 tháng gần nhất) — chọn hàm SQL theo driver để portable
        $driver = DB::connection()->getDriverName();
        if ($driver === 'sqlite') {
            $yExpr = "CAST(strftime('%Y', created_at) AS INTEGER)";
            $mExpr = "CAST(strftime('%m', created_at) AS INTEGER)";
        } elseif ($driver === 'pgsql') {
            $yExpr = "EXTRACT(YEAR FROM created_at)";
            $mExpr = "EXTRACT(MONTH FROM created_at)";
        } else { // mysql, mariadb
            $yExpr = "YEAR(created_at)";
            $mExpr = "MONTH(created_at)";
        }
        $monthlyStats = Ticket::selectRaw("$yExpr as y, $mExpr as m, COUNT(*) as total")
            ->groupBy('y', 'm')
            ->orderByDesc('y')
            ->orderByDesc('m')
            ->limit(6)
            ->get()
            ->map(function ($row) {
                return (object) [
                    'month' => sprintf('%02d/%d', (int) $row->m, (int) $row->y),
                    'total' => $row->total,
                ];
            });

        // Hiệu suất kỹ thuật viên
        $techStats = User::whereHas('role', function ($query) {
                $query->where('name', 'Technician');
            })
            ->withCount(['assignedTickets' => function ($query) {
                $query->where('status', 'resolved');
            }])
            ->orderByDesc('assigned_tickets_count')
            ->get();

        $totalTickets = Ticket::count();
        $resolvedTickets = Ticket::where('status', 'resolved')->count();
        $resolutionRate = $totalTickets > 0 ? round(($resolvedTickets / $totalTickets) * 100, 1) : 0;

        return view('reports.index', compact(
            'statusStats',
            'categoryStats',
            'monthlyStats',
            'techStats',
            'totalTickets',
            'resolutionRate'
        ));
    }

    /**
     * Báo cáo tài sản theo phòng (B11).
     */
    public function assetsByRoom()
    {
        $rooms = Room::with(['assets.category'])
            ->withCount([
                'assets as total_assets',
                'assets as active_assets' => fn ($q) => $q->where('status', 'active'),
                'assets as broken_assets' => fn ($q) => $q->where('status', 'broken'),
                'assets as maintenance_assets' => fn ($q) => $q->where('status', 'maintenance'),
            ])
            ->orderBy('name')
            ->get();

        return view('reports.assets_by_room', compact('rooms'));
    }
}
