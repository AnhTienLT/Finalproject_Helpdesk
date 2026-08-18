@extends('layouts.app')

@section('title', 'Danh sách Ticket')

@section('content')
<div class="sm:flex sm:items-center sm:justify-between mb-8">
    <div class="flex-1 min-w-0">
        <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
            Danh sách yêu cầu hỗ trợ
        </h2>
        <p class="mt-1 text-sm text-gray-500">
            Theo dõi và quản lý các yêu cầu hỗ trợ kỹ thuật từ người dùng.
        </p>
    </div>
    <div class="mt-4 flex sm:mt-0 sm:ml-4">
        <a href="{{ route('tickets.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Gửi yêu cầu mới
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
                                ID & Tiêu đề
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Danh mục & Ưu tiên
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Trạng thái
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Ngày tạo
                            </th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Thao tác</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($tickets as $ticket)
                        <tr class="hover:bg-gray-50 transition duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="text-sm font-mono text-gray-400 mr-3">#{{ $ticket->id }}</div>
                                    <div class="text-sm font-semibold text-gray-900">{{ $ticket->title }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $ticket->category->name }}</div>
                                <div class="mt-1">
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold text-white uppercase" style="background-color: {{ $ticket->priority->color }}">
                                        {{ $ticket->priority->name }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusClasses = [
                                        'open' => 'bg-green-100 text-green-800',
                                        'in_progress' => 'bg-blue-100 text-blue-800',
                                        'resolved' => 'bg-indigo-100 text-indigo-800',
                                        'closed' => 'bg-gray-100 text-gray-800',
                                    ];
                                    $statusLabels = [
                                        'open' => 'Mới',
                                        'in_progress' => 'Đang xử lý',
                                        'resolved' => 'Đã giải quyết',
                                        'closed' => 'Đóng',
                                    ];
                                @endphp
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClasses[$ticket->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ $statusLabels[$ticket->status] ?? ucfirst($ticket->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $ticket->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('tickets.show', $ticket) }}" class="text-indigo-600 hover:text-indigo-900 inline-flex items-center bg-indigo-50 px-3 py-1 rounded-md transition">
                                    Chi tiết
                                    <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-sm text-gray-500 italic bg-gray-50">
                                Chưa có yêu cầu nào được gửi.
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
    {{ $tickets->links() }}
</div>
@endsection
