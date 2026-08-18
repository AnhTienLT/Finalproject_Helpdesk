@extends('layouts.app')

@section('title', 'Gửi yêu cầu hỗ trợ')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white shadow-sm rounded-lg border border-gray-200 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-bold text-gray-900">Gửi yêu cầu hỗ trợ mới</h3>
            <p class="mt-1 text-sm text-gray-500">Vui lòng cung cấp chi tiết vấn đề bạn đang gặp phải để chúng tôi hỗ trợ tốt nhất.</p>
        </div>

        @if($errors->any())
            <div class="p-4 bg-red-50 border-b border-red-100">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Có lỗi xảy ra:</h3>
                        <div class="mt-2 text-sm text-red-700">
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('tickets.store') }}" method="POST" class="p-8 space-y-6">
            @csrf

            <div>
                <label for="title" class="block text-sm font-semibold text-gray-700 mb-1">Tiêu đề yêu cầu</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}"
                    class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border p-2.5"
                    placeholder="VD: Lỗi không in được tài liệu, Hỏng chuột..." required>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="category_id" class="block text-sm font-semibold text-gray-700 mb-1">Danh mục</label>
                    <select name="category_id" id="category_id" required
                        class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border p-2.5 bg-white">
                        <option value="">-- Chọn danh mục --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="priority_id" class="block text-sm font-semibold text-gray-700 mb-1">Mức độ ưu tiên</label>
                    <select name="priority_id" id="priority_id" required
                        class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border p-2.5 bg-white">
                        <option value="">-- Chọn mức độ --</option>
                        @foreach($priorities as $priority)
                            <option value="{{ $priority->id }}" {{ old('priority_id') == $priority->id ? 'selected' : '' }}>{{ $priority->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label for="room_id" class="block text-sm font-semibold text-gray-700 mb-1">Vị trí / Phòng</label>
                <select name="room_id" id="room_id"
                    class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border p-2.5 bg-white">
                    <option value="">-- Không xác định (Chọn nếu có) --</option>
                    @foreach($rooms as $room)
                        <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>{{ $room->name }} ({{ $room->location }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="description" class="block text-sm font-semibold text-gray-700 mb-1">Mô tả chi tiết lỗi</label>
                <textarea name="description" id="description" rows="5" required
                    class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border p-2.5"
                    placeholder="Vui lòng mô tả chi tiết tình trạng lỗi, các bước dẫn đến lỗi...">{{ old('description') }}</textarea>
            </div>

            <div class="pt-4 flex items-center justify-end space-x-3 border-t border-gray-100">
                <a href="{{ route('tickets.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                    Hủy bỏ
                </a>
                <button type="submit" class="px-6 py-2 text-sm font-bold text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                    Gửi yêu cầu
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
