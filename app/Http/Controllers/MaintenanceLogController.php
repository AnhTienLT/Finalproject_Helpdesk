<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceLog;
use App\Models\Asset;
use App\Models\User;
use Illuminate\Http\Request;

class MaintenanceLogController extends Controller
{
    public function index()
    {
        $logs = MaintenanceLog::with(['asset', 'performer'])->latest()->paginate(10);
        return view('maintenance_logs.index', compact('logs'));
    }

    public function create()
    {
        $assets = Asset::all();
        $technicians = User::whereHas('role', function ($q) {
            $q->where('name', 'Technician');
        })->get();

        return view('maintenance_logs.create', compact('assets', $technicians ? 'technicians' : ''));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'performed_by' => 'required|exists:users,id',
            'description' => 'required',
            'maintenance_date' => 'required|date',
            'cost' => 'nullable|numeric|min:0',
        ], [
            'asset_id.required' => 'Vui lòng chọn tài sản cần bảo trì.',
            'asset_id.exists' => 'Tài sản được chọn không hợp lệ.',
            'performed_by.required' => 'Vui lòng chọn người thực hiện bảo trì.',
            'performed_by.exists' => 'Người thực hiện được chọn không hợp lệ.',
            'description.required' => 'Vui lòng nhập mô tả chi tiết công việc bảo trì.',
            'maintenance_date.required' => 'Vui lòng chọn ngày thực hiện bảo trì.',
            'maintenance_date.date' => 'Ngày thực hiện không đúng định dạng.',
            'cost.numeric' => 'Chi phí bảo trì phải là số.',
            'cost.min' => 'Chi phí bảo trì không được nhỏ hơn 0.',
        ]);

        MaintenanceLog::create($validated);

        return redirect()->route('maintenance-logs.index')->with('success', 'Thêm nhật ký bảo trì thành công!');
    }

    public function edit(MaintenanceLog $maintenanceLog)
    {
        $assets = Asset::all();
        $technicians = User::whereHas('role', function ($q) {
            $q->where('name', 'Technician');
        })->get();

        return view('maintenance_logs.edit', compact('maintenanceLog', 'assets', 'technicians'));
    }

    public function update(Request $request, MaintenanceLog $maintenanceLog)
    {
        $validated = $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'performed_by' => 'required|exists:users,id',
            'description' => 'required',
            'maintenance_date' => 'required|date',
            'cost' => 'nullable|numeric|min:0',
        ], [
            'asset_id.required' => 'Vui lòng chọn tài sản.',
            'asset_id.exists' => 'Tài sản được chọn không hợp lệ.',
            'performed_by.required' => 'Vui lòng chọn người thực hiện.',
            'performed_by.exists' => 'Người thực hiện không hợp lệ.',
            'description.required' => 'Vui lòng nhập mô tả công việc bảo trì.',
            'maintenance_date.required' => 'Vui lòng chọn ngày thực hiện.',
            'maintenance_date.date' => 'Ngày thực hiện không đúng định dạng.',
            'cost.numeric' => 'Chi phí bảo trì phải là số.',
            'cost.min' => 'Chi phí bảo trì không được nhỏ hơn 0.',
        ]);

        $maintenanceLog->update($validated);

        return redirect()->route('maintenance-logs.index')->with('success', 'Cập nhật nhật ký bảo trì thành công!');
    }

    public function destroy(MaintenanceLog $maintenanceLog)
    {
        $maintenanceLog->delete();
        return redirect()->route('maintenance-logs.index')->with('success', 'Xóa nhật ký bảo trì thành công!');
    }
}
