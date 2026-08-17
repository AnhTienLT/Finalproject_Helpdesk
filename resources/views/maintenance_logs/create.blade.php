@extends('layouts.app')

@section('title', 'Thêm Nhật ký Bảo trì')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="md:flex md:items-center md:justify-between mb-8">
        <div class="flex-1 min-w-0">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                Thêm nhật ký bảo trì mới
            </h2>
        </div>
        <div class="mt-4 flex md:mt-0 md:ml-4">
            <a href="{{ route('maintenance-logs.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                Quay lại
            </a>
        </div>
    </div>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg border border-gray-200">
        <form action="{{ route('maintenance-logs.store') }}" method="POST" class="p-6 space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Chọn tài sản -->
                <div class="col-span-2 md:col-span-1">
                    <label for="asset_id" class="block text-sm font-medium text-gray-700">Tài sản / Thiết bị bảo trì <span class="text-red-500">*</span></label>
                    <select name="asset_id" id="asset_id" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('asset_id') border-red-300 text-red-900 @enderror">
                        <option value="">-- Chọn tài sản --</option>
                        @foreach ($assets as $asset)
                            <option value="{{ $asset->id }}" {{ old('asset_id') == $asset->id ? 'selected' : '' }}>
                                {{ $asset->name }} ({{ $asset->asset_code }})
                            </option>
                        @endforeach
                    </select>
                    @error('asset_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Chọn kỹ thuật viên thực hiện -->
                <div class="col-span-2 md:col-span-1">
                    <label for="performed_by" class="block text-sm font-medium text-gray-700">Kỹ thuật viên thực hiện <span class="text-red-500">*</span></label>
                    <select name="performed_by" id="performed_by" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('performed_by') border-red-300 text-red-900 @enderror">
                        <option value="">-- Chọn kỹ thuật viên --</option>
                        @foreach ($technicians as $tech)
                            <option value="{{ $tech->id }}" {{ old('performed_by') == $tech->id ? 'selected' : '' }}>
                                {{ $tech->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('performed_by')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Ngày bảo trì -->
                <div>
                    <label for="maintenance_date" class="block text-sm font-medium text-gray-700">Ngày bảo trì <span class="text-red-500">*</span></label>
                    <input type="date" name="maintenance_date" id="maintenance_date" value="{{ old('maintenance_date', date('Y-m-d')) }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('maintenance_date') border-red-300 text-red-900 @enderror">
                    @error('maintenance_date')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Chi phí bảo trì -->
                <div>
                    <label for="cost" class="block text-sm font-medium text-gray-700">Chi phí bảo trì (để trống nếu miễn phí)</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <input type="number" name="cost" id="cost" value="{{ old('cost') }}" class="block w-full border border-gray-300 rounded-md py-2 pl-3 pr-12 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('cost') border-red-300 text-red-900 placeholder-red-300 @enderror" placeholder="0">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">VND</span>
                        </div>
                    </div>
                    @error('cost')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Mô tả công việc -->
                <div class="col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700">Nội dung / Mô tả công việc <span class="text-red-500">*</span></label>
                    <textarea name="description" id="description" rows="4" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('description') border-red-300 text-red-900 @enderror" placeholder="Nhập chi tiết về lỗi phát sinh, bộ phận thay thế, kết quả bảo trì...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end pt-4 border-t border-gray-200">
                <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                    Lưu nhật ký
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
