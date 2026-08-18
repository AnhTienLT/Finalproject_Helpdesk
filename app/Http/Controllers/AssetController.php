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
        $assets = Asset::with(['category', 'room'])->latest()->paginate(15);
        return view('assets.index', compact('assets'));
    }

    public function create()
    {
        $categories = AssetCategory::orderBy('name')->get();
        $rooms = Room::orderBy('name')->get();
        return view('assets.create', compact('categories', 'rooms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'              => 'required|string|max:150',
            'asset_code'        => 'required|string|max:50|unique:assets,asset_code',
            'asset_category_id' => 'required|exists:asset_categories,id',
            'room_id'           => 'required|exists:rooms,id',
            'status'            => 'required|in:active,broken,maintenance,disposed',
            'purchase_date'     => 'nullable|date|before_or_equal:today',
            'description'       => 'nullable|string|max:255',
        ]);

        Asset::create($validated);

        return redirect()->route('assets.index')->with('success', 'Đã thêm tài sản thành công.');
    }

    public function show(Asset $asset)
    {
        $asset->load(['category', 'room', 'maintenanceLogs.performer']);
        return view('assets.show', compact('asset'));
    }

    public function edit(Asset $asset)
    {
        $categories = AssetCategory::orderBy('name')->get();
        $rooms = Room::orderBy('name')->get();
        return view('assets.edit', compact('asset', 'categories', 'rooms'));
    }

    public function update(Request $request, Asset $asset)
    {
        $validated = $request->validate([
            'name'              => 'required|string|max:150',
            'asset_code'        => 'required|string|max:50|unique:assets,asset_code,' . $asset->id,
            'asset_category_id' => 'required|exists:asset_categories,id',
            'room_id'           => 'required|exists:rooms,id',
            'status'            => 'required|in:active,broken,maintenance,disposed',
            'purchase_date'     => 'nullable|date|before_or_equal:today',
            'description'       => 'nullable|string|max:255',
        ]);

        $asset->update($validated);

        return redirect()->route('assets.index')->with('success', 'Đã cập nhật tài sản.');
    }

    public function destroy(Asset $asset)
    {
        if ($asset->maintenanceLogs()->count() > 0) {
            return back()->with('error', 'Không thể xoá tài sản đang có log bảo trì. Hãy xoá log trước.');
        }
        $asset->delete();
        return redirect()->route('assets.index')->with('success', 'Đã xoá tài sản.');
    }
}
