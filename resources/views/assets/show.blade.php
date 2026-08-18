@extends('layouts.app')

@section('title', 'Chi tiết tài sản ' . $asset->asset_code)

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center bg-white p-6 rounded-lg shadow-sm border-l-4 border-indigo-600">
        <div>
            <nav class="flex mb-2" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2 text-sm text-gray-500">
                    <li><a href="{{ route('assets.index') }}" class="hover:text-indigo-600">Tài sản</a></li>
                    <li><svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg></li>
                    <li class="text-gray-900 font-medium">{{ $asset->asset_code }}</li>
                </ol>
            </nav>
            <h1 class="text-3xl font-bold text-gray-900">{{ $asset->name }}</h1>
            <p class="text-gray-500 mt-1">Mã định danh: <span class="font-mono font-bold text-indigo-600">{{ $asset->asset_code }}</span></p>
        </div>
        <div class="text-right">
            @php
                $statusClasses = [
                    'active' => 'bg-green-100 text-green-800 border-green-200',
                    'broken' => 'bg-red-100 text-red-800 border-red-200',
                    'maintenance' => 'bg-amber-100 text-amber-800 border-amber-200',
                    'disposed' => 'bg-gray-100 text-gray-800 border-gray-200',
                ];
                $statusLabels = [
                    'active' => 'Hoạt động',
                    'broken' => 'Đang hỏng',
                    'maintenance' => 'Bảo trì',
                    'disposed' => 'Đã thanh lý',
                ];
            @endphp
            <span class="px-4 py-2 rounded-full text-sm font-bold border {{ $statusClasses[$asset->status] ?? 'bg-gray-100' }}">
                {{ $statusLabels[$asset->status] ?? ucfirst($asset->status) }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Thông tin chung -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                <h2 class="text-lg font-bold text-gray-900 mb-6 border-b pb-2 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Thông số kỹ thuật & Mô tả
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Danh mục tài sản</label>
                        <p class="mt-1 text-sm font-bold text-gray-900">{{ $asset->category->name }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Vị trí lắp đặt</label>
                        <p class="mt-1 text-sm font-bold text-gray-900">{{ $asset->room->name }}</p>
                        <p class="text-xs text-gray-500">{{ $asset->room->location }}</p>
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Ngày đưa vào sử dụng</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $asset->purchase_date ? \Carbon\Carbon::parse($asset->purchase_date)->format('d/m/Y') : 'Không rõ' }}</p>
                    </div>
                </div>
                <div>
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Mô tả chi tiết</label>
                    <div class="mt-2 text-sm text-gray-700 bg-gray-50 p-4 rounded-lg border border-gray-100 italic">
                        {{ $asset->description ?: 'Không có thông tin mô tả bổ sung cho tài sản này.' }}
                    </div>
                </div>
            </div>

            <!-- Nhật ký bảo trì -->
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                <h2 class="text-lg font-bold text-gray-900 mb-6 border-b pb-2 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Lịch sử bảo trì & Sửa chữa
                </h2>
                <div class="flow-root">
                    <ul role="list" class="-mb-8">
                        @forelse($asset->maintenanceLogs as $log)
                            <li>
                                <div class="relative pb-8">
                                    @if (!$loop->last)
                                        <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                    @endif
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center ring-8 ring-white">
                                                <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                            <div>
                                                <p class="text-sm text-gray-500">{{ $log->description }}</p>
                                                <p class="mt-1 text-xs text-gray-400 font-medium">Thực hiện: {{ $log->performer->name }}</p>
                                            </div>
                                            <div class="text-right text-sm whitespace-nowrap text-gray-500 font-bold">
                                                {{ \Carbon\Carbon::parse($log->maintenance_date)->format('d/m/Y') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <div class="text-center py-6 text-gray-400 italic text-sm">
                                Chưa ghi nhận lịch sử bảo trì cho tài sản này.
                            </div>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        <!-- Sidebar Actions -->
        <div class="space-y-6">
            <div class="bg-indigo-700 rounded-lg shadow-lg overflow-hidden text-white">
                <div class="p-6">
                    <h3 class="text-lg font-bold mb-4">Thao tác nhanh</h3>
                    <div class="space-y-3">
                        <button class="w-full bg-white text-indigo-700 font-bold py-2 px-4 rounded hover:bg-indigo-50 transition">
                            Cập nhật trạng thái
                        </button>
                        <button class="w-full bg-indigo-600 text-white border border-indigo-500 font-bold py-2 px-4 rounded hover:bg-indigo-500 transition">
                            Tạo lịch bảo trì
                        </button>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4">Thông tin QR</h3>
                <div class="flex flex-col items-center">
                    <div class="w-32 h-32 bg-gray-100 border-2 border-dashed border-gray-300 rounded flex items-center justify-center text-gray-400 text-xs text-center p-2">
                        Mã QR Code tài sản<br>(Tính năng đang phát triển)
                    </div>
                    <p class="mt-4 text-xs text-gray-500 text-center uppercase">Asset ID: {{ $asset->id }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="flex justify-center pb-10">
        <a href="{{ route('assets.index') }}" class="text-sm font-medium text-gray-500 hover:text-indigo-600 transition flex items-center">
            <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Quay lại danh sách
        </a>
    </div>
</div>
@endsection
