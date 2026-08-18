@extends('layouts.app')

@section('title', 'Nhật ký bảo trì')

@section('content')
<div class="sm:flex sm:items-center sm:justify-between mb-8">
    <div>
        <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl">Nhật ký bảo trì tài sản</h2>
        <p class="mt-1 text-sm text-gray-500">Lịch sử bảo trì, sửa chữa của các tài sản trong hệ thống.</p>
    </div>
    <a href="{{ route('maintenance-logs.create') }}" class="mt-4 sm:mt-0 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">Thêm log</a>
</div>

@if(session('success')) <div class="mb-4 p-3 rounded bg-green-50 text-green-700 text-sm">{{ session('success') }}</div> @endif

<div class="bg-white shadow overflow-hidden sm:rounded-lg border border-gray-200">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ngày</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tài sản</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mô tả</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Người thực hiện</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Chi phí</th>
                <th class="px-6 py-3"></th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($logs as $log)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm text-gray-700">{{ \Illuminate\Support\Carbon::parse($log->maintenance_date)->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $log->asset?->name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ \Illuminate\Support\Str::limit($log->description, 80) }}</td>
                    <td class="px-6 py-4 text-sm text-gray-700">{{ $log->performer?->name }}</td>
                    <td class="px-6 py-4 text-sm text-right">{{ $log->cost !== null ? number_format($log->cost, 0, ',', '.') . ' đ' : '—' }}</td>
                    <td class="px-6 py-4 text-right text-sm space-x-3">
                        <a href="{{ route('maintenance-logs.edit', $log) }}" class="text-indigo-600 hover:text-indigo-900">Sửa</a>
                        <form action="{{ route('maintenance-logs.destroy', $log) }}" method="POST" class="inline" onsubmit="return confirm('Xoá log này?')">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:text-red-900">Xoá</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="px-6 py-10 text-center text-sm text-gray-500 italic bg-gray-50">Chưa có log bảo trì nào.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-6">{{ $logs->links() }}</div>
@endsection
