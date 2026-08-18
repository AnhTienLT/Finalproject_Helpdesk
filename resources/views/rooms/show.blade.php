@extends('layouts.app')

@section('title', 'Chi tiết Vị trí: ' . $room->name)

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center bg-white p-6 rounded-lg shadow-sm border-l-4 border-indigo-600">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">{{ $room->name }}</h1>
            <p class="text-gray-500 mt-1 flex items-center">
                <svg class="h-4 w-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                {{ $room->location }}
            </p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('rooms.edit', $room) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition">
                Chỉnh sửa
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Info Card -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4">Thông tin cơ bản</h3>
                <div class="space-y-4">
                    <div>
                        <label class="text-xs font-medium text-gray-500 uppercase">Mô tả</label>
                        <p class="mt-1 text-sm text-gray-700 italic">{{ $room->description ?: 'Không có mô tả chi tiết.' }}</p>
                    </div>
                    <div class="pt-4 border-t border-gray-50">
                        <label class="text-xs font-medium text-gray-500 uppercase">Ngày tạo</label>
                        <p class="mt-1 text-sm text-gray-900 font-medium">{{ $room->created_at->format('d/m/Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Assets Table -->
        <div class="lg:col-span-2">
            <div class="bg-white shadow-sm border border-gray-200 rounded-lg overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-bold text-gray-900">Tài sản tại đây ({{ $room->assets->count() }})</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-white">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mã & Tên</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($room->assets as $asset)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <div class="font-bold text-gray-900">{{ $asset->name }}</div>
                                    <div class="text-xs font-mono text-indigo-600">{{ $asset->asset_code }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $colors = ['active' => 'bg-green-100 text-green-800', 'broken' => 'bg-red-100 text-red-800', 'maintenance' => 'bg-yellow-100 text-yellow-800', 'disposed' => 'bg-gray-100 text-gray-800'];
                                    @endphp
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $colors[$asset->status] ?? 'bg-gray-100' }}">
                                        {{ $asset->status }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2" class="px-6 py-10 text-center text-sm text-gray-500 italic">
                                    Chưa có tài sản nào được gán cho vị trí này.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="flex justify-center">
        <a href="{{ route('rooms.index') }}" class="text-sm font-medium text-gray-500 hover:text-indigo-600 transition flex items-center">
            <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Quay lại danh sách
        </a>
    </div>
</div>
@endsection
