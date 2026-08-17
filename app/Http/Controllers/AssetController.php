<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetCategory;
use App\Models\Room;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    public function index()
    {
        $assets = Asset::with(['category', 'room'])->latest()->paginate(10);
        return view('assets.index', compact('assets'));
    }

    public function show(Asset $asset)
    {
        $asset->load(['category', 'room', 'maintenanceLogs.performer']);
        return view('assets.show', compact('asset'));
    }

    public function create()
    {
        $categories = AssetCategory::all();
        $rooms = Room::all();
        return view('assets.create', compact('categories', 'rooms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:150',
            'asset_code' => 'required|max:50|unique:assets,asset_code',
            'asset_category_id' => 'required|exists:asset_categories,id',
            'room_id' => 'required|exists:rooms,id',
            'status' => 'required|in:active,broken,maintenance,disposed',
            'purchase_date' => 'nullable|date',
            'description' => 'nullable|max:255',
        ], [
            'name.required' => 'Tên tài sản không được để trống.',
            'name.max' => 'Tên tài sản không được vượt quá 150 ký tự.',
            'asset_code.required' => 'Mã tài sản không được để trống.',
            'asset_code.max' => 'Mã tài sản không được vượt quá 50 ký tự.',
            'asset_code.unique' => 'Mã tài sản này đã tồn tại trong hệ thống.',
            'asset_category_id.required' => 'Danh mục tài sản không được bỏ trống.',
            'asset_category_id.exists' => 'Danh mục tài sản đã chọn không hợp lệ.',
            'room_id.required' => 'Phòng máy / Vị trí không được bỏ trống.',
            'room_id.exists' => 'Phòng máy / Vị trí đã chọn không hợp lệ.',
            'status.required' => 'Trạng thái tài sản không được để trống.',
            'status.in' => 'Trạng thái không hợp lệ.',
            'purchase_date.date' => 'Ngày mua không đúng định dạng ngày tháng.',
            'description.max' => 'Mô tả không được vượt quá 255 ký tự.',
        ]);

        Asset::create($validated);

        return redirect()->route('assets.index')->with('success', 'Thêm tài sản mới thành công!');
    }

    public function edit(Asset $asset)
    {
        $categories = AssetCategory::all();
        $rooms = Room::all();
        return view('assets.edit', compact('asset', 'categories', 'rooms'));
    }

    public function update(Request $request, Asset $asset)
    {
        $validated = $request->validate([
            'name' => 'required|max:150',
            'asset_code' => 'required|max:50|unique:assets,asset_code,' . $asset->id,
            'asset_category_id' => 'required|exists:asset_categories,id',
            'room_id' => 'required|exists:rooms,id',
            'status' => 'required|in:active,broken,maintenance,disposed',
            'purchase_date' => 'nullable|date',
            'description' => 'nullable|max:255',
        ], [
            'name.required' => 'Tên tài sản không được để trống.',
            'name.max' => 'Tên tài sản không được vượt quá 150 ký tự.',
            'asset_code.required' => 'Mã tài sản không được để trống.',
            'asset_code.max' => 'Mã tài sản không được vượt quá 50 ký tự.',
            'asset_code.unique' => 'Mã tài sản này đã tồn tại trong hệ thống.',
            'asset_category_id.required' => 'Danh mục tài sản không được bỏ trống.',
            'asset_category_id.exists' => 'Danh mục tài sản đã chọn không hợp lệ.',
            'room_id.required' => 'Phòng máy / Vị trí không được bỏ trống.',
            'room_id.exists' => 'Phòng máy / Vị trí đã chọn không hợp lệ.',
            'status.required' => 'Trạng thái tài sản không được để trống.',
            'status.in' => 'Trạng thái không hợp lệ.',
            'purchase_date.date' => 'Ngày mua không đúng định dạng ngày tháng.',
            'description.max' => 'Mô tả không được vượt quá 255 ký tự.',
        ]);

        $asset->update($validated);

        return redirect()->route('assets.index')->with('success', 'Cập nhật thông tin tài sản thành công!');
    }

    public function destroy(Asset $asset)
    {
        if ($asset->maintenanceLogs()->exists()) {
            return redirect()->route('assets.index')->with('error', 'Không thể xóa tài sản này vì vẫn còn lịch sử bảo trì liên quan.');
        }

        $asset->delete();

        return redirect()->route('assets.index')->with('success', 'Xóa tài sản thành công!');
    }
}
