@extends('layouts.app')

@section('title', 'Danh sách Ticket')

@section('content')
<div class="sm:flex sm:items-center sm:justify-between mb-8">
    <div class="flex-1 min-w-0">
        <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
            Yêu cầu hỗ trợ & Báo cáo sự cố
        </h2>
        <p class="mt-1 text-sm text-gray-500">
            Xem và theo dõi tiến độ xử lý các phiếu yêu cầu kỹ thuật và cơ sở vật chất từ người dùng.
        </p>
    </div>
    <div class="mt-4 flex sm:mt-0 sm:ml-4">
        <a href="{{ route('tickets.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Tạo yêu cầu mới
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
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tiêu đề yêu cầu</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Danh mục & Phòng</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Ưu tiên</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Trạng thái</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Người xử lý</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Ngày tạo</th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Thao tác</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($tickets as $ticket)
                        <tr class="hover:bg-gray-50 transition duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-500">
                                #{{ $ticket->id }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-bold text-gray-900">
                                    <a href="{{ route('tickets.show', $ticket->id) }}" class="hover:text-indigo-600">
                                        {{ $ticket->title }}
                                    </a>
                                </div>
                                <div class="text-xs text-gray-500 mt-1 truncate max-w-xs">{{ Str::limit($ticket->description, 50) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 font-medium">{{ $ticket->category->name }}</div>
                                <div class="text-xs text-gray-500 flex items-center mt-1">
                                    <svg class="h-3 w-3 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    {{ $ticket->room->name ?? 'Chưa xác định' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full text-white" style="background-color: {{ $ticket->priority->color }}">
                                    {{ $ticket->priority->name }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                @php
                                    $statusClasses = [
                                        'open' => 'bg-blue-100 text-blue-800 border-blue-200',
                                        'in_progress' => 'bg-amber-100 text-amber-800 border-amber-200',
                                        'resolved' => 'bg-green-100 text-green-800 border-green-200',
                                        'closed' => 'bg-gray-100 text-gray-800 border-gray-200',
                                    ];
                                    $statusText = [
                                        'open' => 'Mở',
                                        'in_progress' => 'Đang xử lý',
                                        'resolved' => 'Đã giải quyết',
                                        'closed' => 'Đã đóng',
                                    ];
                                @endphp
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full border {{ $statusClasses[$ticket->status] ?? 'bg-gray-100' }}">
                                    {{ $statusText[$ticket->status] ?? ucfirst($ticket->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-600 font-medium">
                                {{ $ticket->assignedTo->name ?? 'Chưa phân công' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                {{ $ticket->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end items-center space-x-3">
                                    <a href="{{ route('tickets.show', $ticket->id) }}" class="text-indigo-600 hover:text-indigo-900 flex items-center bg-indigo-50 px-2 py-1 rounded transition">
                                        Chi tiết
                                    </a>
                                    
                                    @if(Auth::user()->role->name === 'Admin' || ($ticket->user_id === Auth::id() && $ticket->status === 'open'))
                                        <a href="{{ route('tickets.edit', $ticket->id) }}" class="text-amber-600 hover:text-amber-900 flex items-center bg-amber-50 px-2 py-1 rounded transition">
                                            Sửa
                                        </a>
                                        <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa yêu cầu này?')" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 flex items-center bg-red-50 px-2 py-1 rounded transition">
                                                Xóa
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-6 py-10 text-center text-sm text-gray-500 italic bg-gray-50">
                                Chưa có yêu cầu hỗ trợ nào được gửi.
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
