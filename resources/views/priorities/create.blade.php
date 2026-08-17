@extends('layouts.app')

@section('title', 'Thêm Độ ưu tiên')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-md">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Thêm Độ ưu tiên mới</h1>
        <a href="{{ route('priorities.index') }}" class="text-gray-600 hover:text-gray-900">&larr; Quay lại</a>
    </div>

    <form action="{{ route('priorities.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-semibold mb-2">Tên hiển thị</label>
            <input type="text" name="name" id="name" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror" value="{{ old('name') }}" required>
            @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="level" class="block text-gray-700 font-semibold mb-2">Cấp độ (Số)</label>
            <input type="number" name="level" id="level" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('level') border-red-500 @enderror" value="{{ old('level') }}" required>
            <p class="text-gray-500 text-xs mt-1">Cấp độ cao hơn thường được ưu tiên hơn.</p>
            @error('level')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="color" class="block text-gray-700 font-semibold mb-2">Màu sắc (HEX)</label>
            <div class="flex space-x-2">
                <input type="color" name="color_picker" id="color_picker" class="h-10 w-20 border rounded cursor-pointer" value="{{ old('color', '#3b82f6') }}" oninput="document.getElementById('color').value = this.value">
                <input type="text" name="color" id="color" class="flex-1 border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('color') border-red-500 @enderror" value="{{ old('color', '#3b82f6') }}" required>
            </div>
            @error('color')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded shadow transition">Lưu lại</button>
        </div>
    </form>
</div>
@endsection
