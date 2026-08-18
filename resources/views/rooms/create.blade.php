@extends('layouts.app')

@section('title', 'Thêm Vị trí mới')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white shadow-sm rounded-lg border border-gray-200 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-bold text-gray-900">Thêm phòng máy / Vị trí mới</h3>
            <p class="mt-1 text-sm text-gray-500">Thiết lập các khu vực làm việc hoặc nơi đặt trang thiết bị kỹ thuật.</p>
        </div>

        <form action="{{ route('rooms.store') }}" method="POST" class="p-8 space-y-6">
            @csrf

            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Tên phòng / Vị trí <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name') }}"
                    class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border p-2.5 @error('name') border-red-500 @enderror"
                    placeholder="VD: Phòng máy chủ, Tầng 3 - Khối văn phòng..." required>
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="location" class="block text-sm font-semibold text-gray-700 mb-1">Vị trí cụ thể <span class="text-red-500">*</span></label>
                <input type="text" name="location" id="location" value="{{ old('location') }}"
                    class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border p-2.5 @error('location') border-red-500 @enderror"
                    placeholder="VD: Tòa nhà A, Khu vực kỹ thuật..." required>
                @error('location')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-semibold text-gray-700 mb-1">Mô tả thêm</label>
                <textarea name="description" id="description" rows="3"
                    class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border p-2.5 @error('description') border-red-500 @enderror"
                    placeholder="Thông tin bổ sung về vị trí này...">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4 flex items-center justify-end space-x-3 border-t border-gray-100">
                <a href="{{ route('rooms.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 transition">
                    Hủy bỏ
                </a>
                <button type="submit" class="px-6 py-2 text-sm font-bold text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 transition">
                    Lưu thông tin
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
