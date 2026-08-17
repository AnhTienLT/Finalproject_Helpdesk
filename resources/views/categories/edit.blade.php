@extends('layouts.app')

@section('title', 'Sửa Danh mục')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-6">Chỉnh sửa Danh mục</h1>

    <form action="{{ route('categories.update', $category) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Tên danh mục</label>
            <input type="text" name="name" id="name" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2 border" value="{{ old('name', $category->name) }}" required>
        </div>

        <div class="mb-6">
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Mô tả</label>
            <textarea name="description" id="description" rows="3" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2 border">{{ old('description', $category->description) }}</textarea>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('categories.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition">Hủy</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition font-semibold">Cập nhật</button>
        </div>
    </form>
</div>
@endsection
