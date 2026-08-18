@extends('layouts.app')

@section('title', 'Sửa Vai trò')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="md:flex md:items-center md:justify-between mb-6">
        <div class="flex-1 min-w-0">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl">Chỉnh sửa vai trò</h2>
            <p class="mt-1 text-sm text-gray-500">Cập nhật thông tin mô tả cho vai trò hệ thống hiện tại.</p>
        </div>
    </div>

    <div class="bg-white shadow-sm border border-gray-200 rounded-lg overflow-hidden">
        <form action="{{ route('roles.update', $role) }}" method="POST" class="divide-y divide-gray-200">
            @csrf
            @method('PUT')
            <div class="p-6 space-y-6">
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Tên vai trò</label>
                    <input type="text" name="name" id="name" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-2.5 border @error('name') border-red-500 @enderror" value="{{ old('name', $role->name) }}" required>
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Mô tả chi tiết</label>
                    <textarea name="description" id="description" rows="4" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-2.5 border @error('description') border-red-500 @enderror" placeholder="Mô tả các quyền hạn hoặc trách nhiệm của vai trò này...">{{ old('description', $role->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="px-6 py-4 bg-gray-50 flex items-center justify-end space-x-3">
                <a href="{{ route('roles.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition">
                    Hủy bỏ
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 transition">
                    Cập nhật
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
