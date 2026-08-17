@extends('layouts.app')

@section('title', 'Quản lý Tài sản')

@section('content')
<div class="sm:flex sm:items-center sm:justify-between mb-8">
    <div class="flex-1 min-w-0">
        <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
            Quản lý Tài sản & Thiết bị
        </h2>
        <p class="mt-1 text-sm text-gray-500">
            Theo dõi danh mục thiết bị, tình trạng hoạt động và vị trí lắp đặt.
        </p>
    </div>
    <div class="mt-4 flex sm:mt-0 sm:ml-4">
        {{-- Nút thêm tài sản (giả định route tồn tại) --}}
        {{-- <a href="{{ route('assets.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 transition">
            Thêm tài sản
        </a> --}}
    </div>
</div>

<div class="flex flex-col">
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg bg-white">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Thông tin tài sản
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Danh mục & Vị trí
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center">
                                Trạng thái
                            </th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Thao tác</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($assets as $asset)
                        <tr class="hover:bg-gray-50 transition duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-indigo-100 rounded flex items-center justify-center text-indigo-700">
                                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path></svg>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-bold text-gray-900">{{ $asset->name }}</div>
                                        <div class="text-xs font-mono text-indigo-600 bg-indigo-50 px-1.5 py-0.5 rounded inline-block mt-1">{{ $asset->asset_code }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 font-medium">{{ $asset->category->name }}</div>
                                <div class="text-xs text-gray-500 flex items-center mt-1">
                                    <svg class="h-3 w-3 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    {{ $asset->room->name }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @php
                                    $statusClasses = [
                                        'active' => 'bg-green-100 text-green-800 border-green-200',
                                        'broken' => 'bg-red-100 text-red-800 border-red-200',
                                        'maintenance' => 'bg-amber-100 text-amber-800 border-amber-200',
                                        'disposed' => 'bg-gray-100 text-gray-800 border-gray-200',
                                    ];
                                    $statusText = [
                                        'active' => 'Hoạt động',
                                        'broken' => 'Hỏng',
                                        'maintenance' => 'Bảo trì',
                                        'disposed' => 'Thanh lý',
                                    ];
                                @endphp
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full border {{ $statusClasses[$asset->status] ?? 'bg-gray-100' }}">
                                    {{ $statusText[$asset->status] ?? ucfirst($asset->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('assets.show', $asset->id) }}" class="text-indigo-600 hover:text-indigo-900 inline-flex items-center bg-indigo-50 px-3 py-1 rounded-md transition">
                                    Chi tiết
                                    <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-sm text-gray-500 italic bg-gray-50">
                                Chưa có tài sản nào được đăng ký trong hệ thống.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
