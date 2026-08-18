@extends('layouts.app')

@section('title', 'Chỉnh sửa Vị trí')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white shadow-sm rounded-lg border border-gray-200 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-bold text-gray-900">Chỉnh sửa: {{ $room->name }}</h3>
            <p class="mt-1 text-sm text-gray-500">Cập nhật thông tin phòng máy hoặc khu vực làm việc.</p>
        </div>

        <form action="{{ route('rooms.update', $room) }}" method="POST" class="p-8 space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Tên phòng / Vị trí <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name', $room->name) }}"
                    class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border p-2.5 @error('name') border-red-500 @enderror"
                    required>
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="location" class="block text-sm font-semibold text-gray-700 mb-1">Vị trí cụ thể <span class="text-red-500">*</span></label>
                <input type="text" name="location" id="location" value="{{ old('location', $room->location) }}"
                    class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border p-2.5 @error('location') border-red-500 @enderror"
                    required>
                @error('location')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-semibold text-gray-700 mb-1">Mô tả thêm</label>
                <textarea name="description" id="description" rows="3"
                    class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border p-2.5 @error('description') border-red-500 @enderror"
                    placeholder="Thông tin bổ sung...">{{ old('description', $room->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4 flex items-center justify-end space-x-3 border-t border-gray-100">
                <a href="{{ route('rooms.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 transition">
                    Hủy bỏ
                </a>
                <button type="submit" class="px-6 py-2 text-sm font-bold text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 transition">
                    Cập nhật
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
