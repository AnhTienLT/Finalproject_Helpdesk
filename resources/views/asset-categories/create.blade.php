@extends('layouts.app')

@section('title', 'Thêm loại tài sản')

@section('content')
<div class="max-w-2xl mx-auto bg-white shadow-sm rounded-lg border border-gray-200 overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-200 bg-gray-50">
        <h3 class="text-lg font-bold text-gray-900">Thêm loại tài sản mới</h3>
    </div>
    <form action="{{ route('asset-categories.store') }}" method="POST" class="p-8 space-y-6">
        @csrf
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Tên loại <span class="text-red-500">*</span></label>
            <input type="text" name="name" value="{{ old('name') }}" required class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border p-2.5 @error('name') border-red-500 @enderror">
            @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Mô tả</label>
            <textarea name="description" rows="3" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border p-2.5">{{ old('description') }}</textarea>
        </div>
        <div class="flex justify-end space-x-3 pt-4 border-t border-gray-100">
            <a href="{{ route('asset-categories.index') }}" class="px-4 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">Hủy</a>
            <button class="px-6 py-2 text-sm font-bold text-white bg-indigo-600 rounded-md hover:bg-indigo-700">Lưu</button>
        </div>
    </form>
</div>
@endsection
