<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\MaintenanceLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaintenanceLogController extends Controller
{
    public function index(Request $request)
    {
        $query = MaintenanceLog::with(['asset', 'performer'])->latest();
        if ($request->filled('asset_id')) {
            $query->where('asset_id', $request->input('asset_id'));
        }
        $logs = $query->paginate(15)->withQueryString();
        return view('maintenance-logs.index', compact('logs'));
    }

    public function create(Request $request)
    {
        $assets = Asset::orderBy('name')->get();
        $selectedAssetId = $request->input('asset_id');
        return view('maintenance-logs.create', compact('assets', 'selectedAssetId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'asset_id'         => 'required|exists:assets,id',
            'description'      => 'required|string|max:2000',
            'maintenance_date' => 'required|date|before_or_equal:today',
            'cost'             => 'nullable|numeric|min:0|max:9999999999',
        ]);
        $validated['performed_by'] = Auth::id();

        MaintenanceLog::create($validated);

        return redirect()->route('maintenance-logs.index')->with('success', 'Đã ghi log bảo trì.');
    }

    public function edit(MaintenanceLog $maintenanceLog)
    {
        $assets = Asset::orderBy('name')->get();
        return view('maintenance-logs.edit', ['log' => $maintenanceLog, 'assets' => $assets]);
    }

    public function update(Request $request, MaintenanceLog $maintenanceLog)
    {
        $validated = $request->validate([
            'asset_id'         => 'required|exists:assets,id',
            'description'      => 'required|string|max:2000',
            'maintenance_date' => 'required|date|before_or_equal:today',
            'cost'             => 'nullable|numeric|min:0|max:9999999999',
        ]);
        $maintenanceLog->update($validated);
        return redirect()->route('maintenance-logs.index')->with('success', 'Đã cập nhật log bảo trì.');
    }

    public function destroy(MaintenanceLog $maintenanceLog)
    {
        $maintenanceLog->delete();
        return redirect()->route('maintenance-logs.index')->with('success', 'Đã xoá log bảo trì.');
    }
}
