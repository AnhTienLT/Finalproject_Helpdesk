<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Category;
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

        // Thống kê ticket theo tháng (6 tháng gần nhất)
        $monthlyStats = Ticket::select(
            DB::raw('strftime("%m/%Y", created_at) as month'),
            DB::raw('count(*) as total')
        )
        ->groupBy('month')
        ->orderBy('created_at', 'desc')
        ->limit(6)
        ->get();

        // Hiệu suất kỹ thuật viên (số ticket đã giải quyết)
        $techStats = User::whereHas('role', function($query) {
                $query->where('name', 'Technician');
            })
            ->withCount(['assignedTickets' => function($query) {
                $query->where('status', 'resolved');
            }])
            ->orderBy('assigned_tickets_count', 'desc')
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
}
