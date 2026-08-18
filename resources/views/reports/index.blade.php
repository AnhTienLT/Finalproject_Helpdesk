@extends('layouts.app')

@section('title', 'Báo cáo & Thống kê')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Báo cáo & Thống kê</h2>
            <p class="mt-1 text-sm text-gray-500">Tổng quan tình hình xử lý sự cố hệ thống.</p>
        </div>
        <button class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none transition">
            <svg class="-ml-1 mr-2 h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            Xuất báo cáo PDF
        </button>
    </div>

    <!-- Quick Stats Overview -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
        <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-100 p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3 text-white">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                </div>
                <div class="ml-5">
                    <p class="text-sm font-medium text-gray-500 truncate">Tổng yêu cầu</p>
                    <p class="mt-1 text-2xl font-bold text-gray-900">{{ $totalTickets }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-100 p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-green-500 rounded-md p-3 text-white">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div class="ml-5">
                    <p class="text-sm font-medium text-gray-500 truncate">Tỉ lệ hoàn thành</p>
                    <p class="mt-1 text-2xl font-bold text-gray-900">{{ $resolutionRate }}%</p>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-100 p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3 text-white">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div class="ml-5">
                    <p class="text-sm font-medium text-gray-500 truncate">Yêu cầu đang mở</p>
                    <p class="mt-1 text-2xl font-bold text-gray-900">{{ $statusStats['open'] ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-100 p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-blue-500 rounded-md p-3 text-white">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <div class="ml-5">
                    <p class="text-sm font-medium text-gray-500 truncate">Đang xử lý</p>
                    <p class="mt-1 text-2xl font-bold text-gray-900">{{ $statusStats['in_progress'] ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Ticket by Category -->
        <div class="bg-white shadow-sm rounded-lg border border-gray-200">
            <div class="px-6 py-5 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-bold text-gray-900">Yêu cầu theo danh mục</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @foreach($categoryStats as $cat)
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-sm font-medium text-gray-700">{{ $cat->name }}</span>
                                <span class="text-sm font-bold text-gray-900">{{ $cat->tickets_count }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-indigo-600 h-2 rounded-full" style="width: {{ $totalTickets > 0 ? ($cat->tickets_count / $totalTickets) * 100 : 0 }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Tech Performance -->
        <div class="bg-white shadow-sm rounded-lg border border-gray-200">
            <div class="px-6 py-5 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-bold text-gray-900">Hiệu suất Kỹ thuật viên (Resolved)</h3>
            </div>
            <div class="p-6 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-3 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Kỹ thuật viên</th>
                            <th class="px-3 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Hoàn thành</th>
                            <th class="px-3 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Điểm số</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($techStats as $tech)
                            <tr>
                                <td class="px-3 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $tech->name }}</td>
                                <td class="px-3 py-4 whitespace-nowrap text-sm text-right text-gray-600">{{ $tech->assigned_tickets_count }}</td>
                                <td class="px-3 py-4 whitespace-nowrap text-right">
                                    <div class="flex justify-end text-yellow-400">
                                        @php $stars = min(5, ceil($tech->assigned_tickets_count / 2)); @endphp
                                        @for($i = 0; $i < 5; $i++)
                                            <svg class="h-4 w-4 {{ $i < $stars ? 'fill-current' : 'text-gray-200' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        @endfor
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="px-3 py-4 text-center text-sm text-gray-500">Chưa có dữ liệu.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
