@extends('layouts.app')

@section('title', 'Sửa Độ ưu tiên')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="md:flex md:items-center md:justify-between mb-6">
        <div class="flex-1 min-w-0">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl">Chỉnh sửa độ ưu tiên</h2>
            <p class="mt-1 text-sm text-gray-500">Cập nhật thông tin và màu sắc nhận diện cho mức độ ưu tiên.</p>
        </div>
    </div>

    <div class="bg-white shadow-sm border border-gray-200 rounded-lg overflow-hidden">
        <form action="{{ route('priorities.update', $priority) }}" method="POST" class="divide-y divide-gray-200">
            @csrf
            @method('PUT')
            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Tên hiển thị</label>
                        <input type="text" name="name" id="name" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-2.5 border @error('name') border-red-500 @enderror" value="{{ old('name', $priority->name) }}" required>
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="level" class="block text-sm font-semibold text-gray-700 mb-2">Cấp độ (Số)</label>
                        <input type="number" name="level" id="level" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-2.5 border @error('level') border-red-500 @enderror" value="{{ old('level', $priority->level) }}" required>
                        @error('level')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="color" class="block text-sm font-semibold text-gray-700 mb-2">Màu sắc nhận diện (Mã HEX)</label>
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <input type="color" id="color_picker" class="h-10 w-20 rounded-lg cursor-pointer border border-gray-200 shadow-sm" value="{{ old('color', $priority->color) }}" oninput="document.getElementById('color').value = this.value.toUpperCase()">
                        </div>
                        <div class="flex-1 max-w-xs">
                            <input type="text" name="color" id="color" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-2.5 border font-mono @error('color') border-red-500 @enderror" value="{{ old('color', $priority->color) }}" required>
                        </div>
                    </div>
                    @error('color')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="px-6 py-4 bg-gray-50 flex items-center justify-end space-x-3">
                <a href="{{ route('priorities.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition">
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
