@extends('layouts.app')

@section('title', 'Loại tài sản')

@section('content')
<div class="sm:flex sm:items-center sm:justify-between mb-8">
    <div>
        <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl">Loại tài sản</h2>
        <p class="mt-1 text-sm text-gray-500">Phân loại tài sản (PC, Máy in, Thiết bị mạng…).</p>
    </div>
    <a href="{{ route('asset-categories.create') }}" class="mt-4 sm:mt-0 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 transition">Thêm loại mới</a>
</div>

@if(session('success')) <div class="mb-4 p-3 rounded bg-green-50 text-green-700 text-sm">{{ session('success') }}</div> @endif
@if(session('error')) <div class="mb-4 p-3 rounded bg-red-50 text-red-700 text-sm">{{ session('error') }}</div> @endif

<div class="bg-white shadow overflow-hidden sm:rounded-lg border border-gray-200">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tên</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mô tả</th>
                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Số tài sản</th>
                <th class="px-6 py-3"></th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($categories as $c)
                <tr>
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $c->name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $c->description }}</td>
                    <td class="px-6 py-4 text-center"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">{{ $c->assets_count }}</span></td>
                    <td class="px-6 py-4 text-right text-sm font-medium space-x-3">
                        <a href="{{ route('asset-categories.edit', $c) }}" class="text-indigo-600 hover:text-indigo-900">Sửa</a>
                        <form action="{{ route('asset-categories.destroy', $c) }}" method="POST" class="inline" onsubmit="return confirm('Xóa loại tài sản này?')">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:text-red-900">Xóa</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="px-6 py-10 text-center text-sm text-gray-500 italic bg-gray-50">Chưa có loại tài sản nào.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-6">{{ $categories->links() }}</div>
@endsection
