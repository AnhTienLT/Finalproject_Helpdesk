@extends('layouts.app')

@section('title', 'Nhật ký Bảo trì Thiết bị')

@section('content')
<div class="sm:flex sm:items-center sm:justify-between mb-8">
    <div class="flex-1 min-w-0">
        <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
            Nhật ký Bảo trì & Sửa chữa
        </h2>
        <p class="mt-1 text-sm text-gray-500">
            Theo dõi chi tiết lịch sử sửa chữa, bảo trì định kỳ, chi phí phát sinh và kỹ thuật viên phụ trách.
        </p>
    </div>
    <div class="mt-4 flex sm:mt-0 sm:ml-4">
        <a href="{{ route('maintenance-logs.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Thêm nhật ký bảo trì
        </a>
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
                                Tài sản & Thiết bị
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nội dung bảo trì
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kỹ thuật viên
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Ngày thực hiện
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Chi phí (VND)
                            </th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Thao tác</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($logs as $log)
                        <tr class="hover:bg-gray-50 transition duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                @if($log->asset)
                                    <a href="{{ route('assets.show', $log->asset_id) }}" class="text-indigo-600 hover:text-indigo-900">
                                        {{ $log->asset->name }}
                                    </a>
                                    <div class="text-xs font-mono text-gray-500 mt-0.5">{{ $log->asset->asset_code }}</div>
                                @else
                                    <span class="text-gray-400 italic">Tài sản đã bị xóa</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate" title="{{ $log->description }}">
                                {{ $log->description }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 font-medium">
                                {{ $log->performer->name ?? 'Không rõ' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($log->maintenance_date)->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                @if(is_null($log->cost))
                                    <span class="text-gray-400 italic font-normal">Chưa cập nhật</span>
                                @elseif($log->cost == 0)
                                    <span class="text-green-600 font-bold">Miễn phí / Bảo hành</span>
                                @else
                                    {{ number_format($log->cost, 0, ',', '.') }} đ
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end items-center space-x-3">
                                    <a href="{{ route('maintenance-logs.edit', $log) }}" class="text-indigo-600 hover:text-indigo-900 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        Sửa
                                    </a>
                                    <form action="{{ route('maintenance-logs.destroy', $log) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa nhật ký này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            Xóa
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-sm text-gray-500 italic bg-gray-50">
                                Chưa có nhật ký bảo trì nào được ghi nhận.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="mt-6">
    {{ $logs->links() }}
</div>
@endsection
