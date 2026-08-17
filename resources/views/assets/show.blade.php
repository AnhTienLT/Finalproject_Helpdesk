@extends('layouts.app')

@section('title', 'Chi tiết tài sản ' . $asset->asset_code)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex justify-between items-center bg-white p-6 rounded-lg shadow-md border-l-4 border-green-600">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">{{ $asset->name }}</h1>
            <p class="text-gray-500 mt-1">Mã tài sản: <span class="font-mono font-bold text-gray-700">{{ $asset->asset_code }}</span></p>
        </div>
            @php
                $statusClasses = [
                    'active' => 'bg-green-600',
                    'broken' => 'bg-red-600',
                    'maintenance' => 'bg-amber-600',
                    'disposed' => 'bg-gray-600',
                ];
                $statusText = [
                    'active' => 'Hoạt động',
                    'broken' => 'Hỏng',
                    'maintenance' => 'Bảo trì',
                    'disposed' => 'Thanh lý',
                ];
            @endphp
            <span class="px-4 py-2 rounded-full text-sm font-bold text-white {{ $statusClasses[$asset->status] ?? 'bg-gray-600' }}">
                {{ $statusText[$asset->status] ?? ucfirst($asset->status) }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Thông tin chung -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-lg font-bold mb-4 border-b pb-2">Thông tin chi tiết</h2>
            <div class="space-y-4">
                <div class="flex justify-between">
                    <span class="text-gray-500">Danh mục:</span>
                    <span class="font-semibold">{{ $asset->category->name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Vị trí:</span>
                    <span class="font-semibold">{{ $asset->room->name }} ({{ $asset->room->location }})</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Ngày mua:</span>
                    <span class="font-semibold">{{ $asset->purchase_date ? \Carbon\Carbon::parse($asset->purchase_date)->format('d/m/Y') : 'Không rõ' }}</span>
                </div>
                <div>
                    <p class="text-gray-500 mb-1">Mô tả:</p>
                    <p class="text-gray-700 italic">{{ $asset->description ?: 'Không có mô tả.' }}</p>
                </div>
            </div>
        </div>

        <!-- Nhật ký bảo trì -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-lg font-bold mb-4 border-b pb-2 text-blue-600">Lịch sử bảo trì</h2>
            <div class="space-y-4 max-h-80 overflow-y-auto">
                @forelse($asset->maintenanceLogs as $log)
                    <div class="border-l-2 border-blue-500 pl-4 py-2">
                        <p class="text-sm font-bold">{{ \Carbon\Carbon::parse($log->maintenance_date)->format('d/m/Y') }}</p>
                        <p class="text-gray-700 text-sm">{{ $log->description }}</p>
                        <p class="text-xs text-gray-400 mt-1">Thực hiện bởi: {{ $log->performer->name }}</p>
                    </div>
                @empty
                    <p class="text-center text-gray-500 py-4 italic">Chưa có lịch sử bảo trì.</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="flex justify-center pb-10">
        <a href="{{ route('assets.index') }}" class="text-gray-500 hover:text-gray-800 flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Quay lại danh sách tài sản
        </a>
    </div>
</div>
@endsection
