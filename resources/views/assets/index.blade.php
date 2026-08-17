@extends('layouts.app')

@section('title', 'Danh sách tài sản')

@section('content')
<div class="bg-white p-8 rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Quản lý tài sản thiết bị</h1>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">Mã tài sản</th>
                    <th class="py-3 px-6 text-left">Tên tài sản</th>
                    <th class="py-3 px-6 text-left">Danh mục</th>
                    <th class="py-3 px-6 text-left">Vị trí</th>
                    <th class="py-3 px-6 text-center">Trạng thái</th>
                    <th class="py-3 px-6 text-center">Thao tác</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @forelse($assets as $asset)
                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                        <td class="py-3 px-6 text-left font-medium text-blue-600">
                            {{ $asset->asset_code }}
                        </td>
                        <td class="py-3 px-6 text-left">{{ $asset->name }}</td>
                        <td class="py-3 px-6 text-left">{{ $asset->category->name }}</td>
                        <td class="py-3 px-6 text-left">{{ $asset->room->name }}</td>
                        <td class="py-3 px-6 text-center">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                {{ $asset->status === 'active' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $asset->status === 'broken' ? 'bg-red-100 text-red-800' : '' }}
                                {{ $asset->status === 'maintenance' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $asset->status === 'disposed' ? 'bg-gray-100 text-gray-800' : '' }}
                            ">
                                {{ ucfirst($asset->status) }}
                            </span>
                        </td>
                        <td class="py-3 px-6 text-center">
                            <a href="{{ route('assets.show', $asset->id) }}" class="text-blue-600 hover:text-blue-900 font-bold">
                                Chi tiết
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-6 text-center text-gray-500">Chưa có tài sản nào trong hệ thống.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
