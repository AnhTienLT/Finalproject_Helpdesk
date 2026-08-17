@extends('layouts.app')

@section('title', 'Chỉnh sửa yêu cầu hỗ trợ')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-md border border-gray-200">
    <div class="flex justify-between items-center mb-6 border-b pb-4">
        <h1 class="text-2xl font-bold text-gray-800">Chỉnh sửa yêu cầu #{{ $ticket->id }}</h1>
        <a href="{{ route('tickets.show', $ticket->id) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">Quay lại chi tiết</a>
    </div>

    <form action="{{ route('tickets.update', $ticket->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Tiêu đề -->
        <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" for="title">Tiêu đề <span class="text-red-500">*</span></label>
            <input class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('title') border-red-300 @enderror" id="title" type="text" name="title" value="{{ old('title', $ticket->title) }}" required>
            @error('title')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Danh mục -->
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="category_id">Danh mục <span class="text-red-500">*</span></label>
                <select class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('category_id') border-red-300 @enderror" id="category_id" name="category_id" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $ticket->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Độ ưu tiên -->
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="priority_id">Mức độ ưu tiên <span class="text-red-500">*</span></label>
                <select class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('priority_id') border-red-300 @enderror" id="priority_id" name="priority_id" required>
                    @foreach($priorities as $priority)
                        <option value="{{ $priority->id }}" {{ old('priority_id', $ticket->priority_id) == $priority->id ? 'selected' : '' }}>{{ $priority->name }}</option>
                    @endforeach
                </select>
                @error('priority_id')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Vị trí / Phòng -->
        <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" for="room_id">Vị trí / Phòng</label>
            <select class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('room_id') border-red-300 @enderror" id="room_id" name="room_id">
                <option value="">-- Chọn phòng (nếu có) --</option>
                @foreach($rooms as $room)
                    <option value="{{ $room->id }}" {{ old('room_id', $ticket->room_id) == $room->id ? 'selected' : '' }}>{{ $room->name }} ({{ $room->location }})</option>
                @endforeach
            </select>
            @error('room_id')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Mô tả -->
        <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" for="description">Mô tả chi tiết lỗi <span class="text-red-500">*</span></label>
            <textarea class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('description') border-red-300 @enderror" id="description" name="description" rows="5" required>{{ old('description', $ticket->description) }}</textarea>
            @error('description')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-between pt-4 border-t">
            <a href="{{ route('tickets.show', $ticket->id) }}" class="text-gray-500 hover:text-gray-800 text-sm font-medium">Hủy bỏ</a>
            <button class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded focus:outline-none focus:ring-2 transition text-sm" type="submit">
                Cập nhật yêu cầu
            </button>
        </div>
    </form>
</div>
@endsection
