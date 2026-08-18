<?php

namespace App\Http\Controllers;

use App\Models\AssetCategory;
use Illuminate\Http\Request;

class AssetCategoryController extends Controller
{
    public function index()
    {
        $categories = AssetCategory::withCount('assets')->orderBy('name')->paginate(10);
        return view('asset-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('asset-categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:100|unique:asset_categories,name',
            'description' => 'nullable|string|max:255',
        ]);

        AssetCategory::create($validated);

        return redirect()->route('asset-categories.index')->with('success', 'Đã thêm loại tài sản.');
    }

    public function edit(AssetCategory $assetCategory)
    {
        return view('asset-categories.edit', ['category' => $assetCategory]);
    }

    public function update(Request $request, AssetCategory $assetCategory)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:100|unique:asset_categories,name,' . $assetCategory->id,
            'description' => 'nullable|string|max:255',
        ]);

        $assetCategory->update($validated);

        return redirect()->route('asset-categories.index')->with('success', 'Đã cập nhật loại tài sản.');
    }

    public function destroy(AssetCategory $assetCategory)
    {
        if ($assetCategory->assets()->count() > 0) {
            return back()->with('error', 'Không thể xoá loại tài sản đang có tài sản.');
        }
        $assetCategory->delete();
        return redirect()->route('asset-categories.index')->with('success', 'Đã xoá loại tài sản.');
    }
}
