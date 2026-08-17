@extends('layouts.app')

@section('title', 'Sửa Vai trò')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-6">Chỉnh sửa Vai trò</h1>

    <form action="{{ route('roles.update', $role) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Tên vai trò</label>
            <input type="text" name="name" id="name" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2 border" value="{{ old('name', $role->name) }}" required>
        </div>

        <div class="mb-6">
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Mô tả</label>
            <textarea name="description" id="description" rows="3" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2 border">{{ old('description', $role->description) }}</textarea>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('roles.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition">Hủy</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition font-semibold">Cập nhật</button>
        </div>
    </form>
</div>
@endsection
