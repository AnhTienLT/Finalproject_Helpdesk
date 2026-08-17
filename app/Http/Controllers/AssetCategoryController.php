<?php

namespace App\Http\Controllers;

use App\Models\AssetCategory;
use Illuminate\Http\Request;

class AssetCategoryController extends Controller
{
    public function index()
    {
        $categories = AssetCategory::latest()->paginate(10);
        return view('asset_categories.index', compact('categories'));
    }

    public function create()
    {
        return view('asset_categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:150|unique:asset_categories,name',
            'description' => 'nullable|max:255',
        ], [
            'name.required' => 'Tên danh mục không được để trống.',
            'name.max' => 'Tên danh mục không được vượt quá 150 ký tự.',
            'name.unique' => 'Tên danh mục này đã tồn tại trong hệ thống.',
            'description.max' => 'Mô tả không được vượt quá 255 ký tự.',
        ]);

        AssetCategory::create($validated);

        return redirect()->route('asset-categories.index')->with('success', 'Thêm danh mục tài sản thành công!');
    }

    public function edit(AssetCategory $assetCategory)
    {
        return view('asset_categories.edit', compact('assetCategory'));
    }

    public function update(Request $request, AssetCategory $assetCategory)
    {
        $validated = $request->validate([
            'name' => 'required|max:150|unique:asset_categories,name,' . $assetCategory->id,
            'description' => 'nullable|max:255',
        ], [
            'name.required' => 'Tên danh mục không được để trống.',
            'name.max' => 'Tên danh mục không được vượt quá 150 ký tự.',
            'name.unique' => 'Tên danh mục này đã tồn tại trong hệ thống.',
            'description.max' => 'Mô tả không được vượt quá 255 ký tự.',
        ]);

        $assetCategory->update($validated);

        return redirect()->route('asset-categories.index')->with('success', 'Cập nhật danh mục tài sản thành công!');
    }

    public function destroy(AssetCategory $assetCategory)
    {
        if ($assetCategory->assets()->exists()) {
            return redirect()->route('asset-categories.index')->with('error', 'Không thể xóa danh mục này vì vẫn còn tài sản thuộc danh mục.');
        }

        $assetCategory->delete();

        return redirect()->route('asset-categories.index')->with('success', 'Xóa danh mục tài sản thành công!');
    }
}
