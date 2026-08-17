@extends('layouts.app')

@section('title', 'Chỉnh sửa Tài sản')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="md:flex md:items-center md:justify-between mb-8">
        <div class="flex-1 min-w-0">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                Chỉnh sửa tài sản: {{ $asset->asset_code }}
            </h2>
        </div>
        <div class="mt-4 flex md:mt-0 md:ml-4">
            <a href="{{ route('assets.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                Quay lại
            </a>
        </div>
    </div>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg border border-gray-200">
        <form action="{{ route('assets.update', $asset->id) }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Tên tài sản -->
                <div class="col-span-2 md:col-span-1">
                    <label for="name" class="block text-sm font-medium text-gray-700">Tên tài sản / Thiết bị <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name', $asset->name) }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('name') border-red-300 text-red-900 placeholder-red-300 @enderror">
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Mã tài sản -->
                <div class="col-span-2 md:col-span-1">
                    <label for="asset_code" class="block text-sm font-medium text-gray-700">Mã tài sản (Unique) <span class="text-red-500">*</span></label>
                    <input type="text" name="asset_code" id="asset_code" value="{{ old('asset_code', $asset->asset_code) }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('asset_code') border-red-300 text-red-900 placeholder-red-300 @enderror">
                    @error('asset_code')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Danh mục tài sản -->
                <div>
                    <label for="asset_category_id" class="block text-sm font-medium text-gray-700">Danh mục tài sản <span class="text-red-500">*</span></label>
                    <select name="asset_category_id" id="asset_category_id" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('asset_category_id') border-red-300 text-red-900 @enderror">
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('asset_category_id', $asset->asset_category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    @error('asset_category_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Vị trí / Phòng máy -->
                <div>
                    <label for="room_id" class="block text-sm font-medium text-gray-700">Vị trí lắp đặt <span class="text-red-500">*</span></label>
                    <select name="room_id" id="room_id" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('room_id') border-red-300 text-red-900 @enderror">
                        @foreach ($rooms as $room)
                            <option value="{{ $room->id }}" {{ old('room_id', $asset->room_id) == $room->id ? 'selected' : '' }}>{{ $room->name }} ({{ $room->location }})</option>
                        @endforeach
                    </select>
                    @error('room_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Trạng thái -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Trạng thái <span class="text-red-500">*</span></label>
                    <select name="status" id="status" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('status') border-red-300 text-red-900 @enderror">
                        <option value="active" {{ old('status', $asset->status) == 'active' ? 'selected' : '' }}>Hoạt động tốt (Active)</option>
                        <option value="broken" {{ old('status', $asset->status) == 'broken' ? 'selected' : '' }}>Đang hỏng (Broken)</option>
                        <option value="maintenance" {{ old('status', $asset->status) == 'maintenance' ? 'selected' : '' }}>Đang bảo trì (Maintenance)</option>
                        <option value="disposed" {{ old('status', $asset->status) == 'disposed' ? 'selected' : '' }}>Đã thanh lý (Disposed)</option>
                    </select>
                    @error('status')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Ngày mua -->
                <div>
                    <label for="purchase_date" class="block text-sm font-medium text-gray-700">Ngày mua / Lắp đặt</label>
                    <input type="date" name="purchase_date" id="purchase_date" value="{{ old('purchase_date', $asset->purchase_date ? \Carbon\Carbon::parse($asset->purchase_date)->format('Y-m-d') : '') }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('purchase_date') border-red-300 text-red-900 @enderror">
                    @error('purchase_date')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Mô tả -->
                <div class="col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700">Mô tả / Thông số kỹ thuật</label>
                    <textarea name="description" id="description" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('description') border-red-300 text-red-900 @enderror">{{ old('description', $asset->description) }}</textarea>
                    @error('description')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end pt-4 border-t border-gray-200">
                <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                    Cập nhật tài sản
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
