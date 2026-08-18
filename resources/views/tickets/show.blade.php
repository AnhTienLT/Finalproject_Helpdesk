@extends('layouts.app')

@section('title', 'Chi tiết Ticket #' . $ticket->id)

@section('content')
<div class="max-w-5xl mx-auto">
    <!-- Header Section -->
    <div class="mb-8 md:flex md:items-center md:justify-between">
        <div class="flex-1 min-w-0">
            <nav class="flex mb-2" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2 text-sm text-gray-500">
                    <li><a href="{{ route('tickets.index') }}" class="hover:text-indigo-600">Yêu cầu</a></li>
                    <li><svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg></li>
                    <li class="text-gray-900 font-medium">Chi tiết #{{ $ticket->id }}</li>
                </ol>
            </nav>
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                {{ $ticket->title }}
            </h2>
        </div>
        <div class="mt-4 flex md:mt-0 md:ml-4 space-x-3">
            @if((Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Technician')) && !$ticket->assigned_to && $ticket->status !== 'closed')
                <form action="{{ route('tickets.assign', $ticket->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none transition">
                        <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Tiếp nhận yêu cầu
                    </button>
                </form>
            @endif

            @if((Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Technician')) && $ticket->status !== 'closed')
                <div class="relative inline-block text-left" x-data="{ open: false }">
                    <button @click="open = !open" type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none transition">
                        Thay đổi trạng thái
                        <svg class="ml-2 -mr-1 h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </button>

                    <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-10">
                        <div class="py-1">
                            <form action="{{ route('tickets.updateStatus', $ticket->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button name="status" value="open" type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ $ticket->status === 'open' ? 'bg-gray-50 font-bold' : '' }}">Mới / Mở</button>
                                <button name="status" value="in_progress" type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ $ticket->status === 'in_progress' ? 'bg-gray-50 font-bold' : '' }}">Đang xử lý</button>
                                <button name="status" value="resolved" type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ $ticket->status === 'resolved' ? 'bg-gray-50 font-bold' : '' }}">Đã giải quyết</button>
                                <button name="status" value="closed" type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ $ticket->status === 'closed' ? 'bg-gray-50 font-bold' : '' }}">Đóng yêu cầu</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Details Card -->
            <div class="bg-white shadow-sm border border-gray-200 rounded-lg overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-900">Mô tả chi tiết</h3>
                    <span class="px-3 py-1 rounded-full text-[10px] font-bold text-white uppercase" style="background-color: {{ $ticket->priority->color }}">
                        {{ $ticket->priority->name }}
                    </span>
                </div>
                <div class="p-6">
                    <div class="prose max-w-none text-gray-700 whitespace-pre-line">
                        {{ $ticket->description }}
                    </div>
                </div>
            </div>

            <!-- Conversation -->
            <div class="bg-white shadow-sm border border-gray-200 rounded-lg overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-bold text-gray-900">Thảo luận & Phản hồi</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-8">
                        @forelse($ticket->responses as $response)
                            <div class="flex {{ $response->user_id === Auth::id() ? 'justify-end' : '' }}">
                                <div class="flex max-w-[85%] {{ $response->user_id === Auth::id() ? 'flex-row-reverse' : '' }}">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center font-bold text-indigo-700 border-2 border-white shadow-sm">
                                            {{ substr($response->user->name, 0, 1) }}
                                        </div>
                                    </div>
                                    <div class="mx-3 {{ $response->user_id === Auth::id() ? 'text-right' : '' }}">
                                        <div class="flex items-center space-x-2 {{ $response->user_id === Auth::id() ? 'flex-row-reverse space-x-reverse' : '' }}">
                                            <span class="text-sm font-bold text-gray-900">{{ $response->user->name }}</span>
                                            <span class="text-[10px] text-gray-400 uppercase tracking-tighter">{{ $response->created_at->diffForHumans() }}</span>
                                        </div>
                                        <div class="mt-1 p-4 rounded-2xl text-sm shadow-sm border {{ $response->user_id === Auth::id() ? 'bg-indigo-600 text-white border-indigo-500 rounded-tr-none' : 'bg-gray-50 text-gray-700 border-gray-100 rounded-tl-none' }}">
                                            {{ $response->message }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                <p class="mt-2 text-sm text-gray-500">Chưa có phản hồi nào. Hãy bắt đầu cuộc hội thoại.</p>
                            </div>
                        @endforelse
                    </div>

                    <form action="{{ route('responses.store', $ticket->id) }}" method="POST" class="mt-10 border-t border-gray-100 pt-8">
                        @csrf
                        <div>
                            <label for="message" class="sr-only">Phản hồi</label>
                            <textarea id="message" name="message" rows="3" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border p-3" placeholder="Nhập phản hồi hoặc ghi chú của bạn..." required></textarea>
                        </div>
                        <div class="mt-3 flex items-center justify-between">
                            <span class="text-xs text-gray-400">Ghi chú: Người dùng liên quan sẽ nhận được thông báo.</span>
                            <button type="submit" class="inline-flex items-center px-6 py-2 border border-transparent text-sm font-bold rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 transition">
                                Gửi phản hồi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Status & Metadata Card -->
            <div class="bg-white shadow-sm border border-gray-200 rounded-lg overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Thông tin trạng thái</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <label class="text-xs font-medium text-gray-500 uppercase">Trạng thái hiện tại</label>
                        <div class="mt-1">
                            @php
                                $statusClasses = [
                                    'open' => 'bg-green-100 text-green-800',
                                    'in_progress' => 'bg-blue-100 text-blue-800',
                                    'resolved' => 'bg-indigo-100 text-indigo-800',
                                    'closed' => 'bg-gray-100 text-gray-800',
                                ];
                                $statusLabels = [
                                    'open' => 'Mới / Mở',
                                    'in_progress' => 'Đang xử lý',
                                    'resolved' => 'Đã giải quyết',
                                    'closed' => 'Đã đóng',
                                ];
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-bold {{ $statusClasses[$ticket->status] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ $statusLabels[$ticket->status] ?? ucfirst($ticket->status) }}
                            </span>
                        </div>
                    </div>
                    <div class="pt-4 border-t border-gray-50">
                        <label class="text-xs font-medium text-gray-500 uppercase">Người yêu cầu</label>
                        <div class="mt-2 flex items-center">
                            <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center text-xs font-bold text-gray-600">
                                {{ substr($ticket->user->name, 0, 1) }}
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-semibold text-gray-900">{{ $ticket->user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $ticket->user->department->name }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="pt-4 border-t border-gray-50">
                        <label class="text-xs font-medium text-gray-500 uppercase">Nhân viên xử lý</label>
                        <div class="mt-2 flex items-center">
                            @if($ticket->assignedTo)
                                <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-xs font-bold text-indigo-700">
                                    {{ substr($ticket->assignedTo->name, 0, 1) }}
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-semibold text-gray-900">{{ $ticket->assignedTo->name }}</p>
                                    <p class="text-xs text-indigo-600">Phụ trách kỹ thuật</p>
                                </div>
                            @else
                                <div class="h-8 w-8 rounded-full bg-gray-100 border-2 border-dashed border-gray-300 flex items-center justify-center">
                                    <svg class="h-4 w-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-400 italic">Chưa tiếp nhận</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Context Info Card -->
            <div class="bg-white shadow-sm border border-gray-200 rounded-lg overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Phân loại & Vị trí</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase">Danh mục sự cố</p>
                        <p class="mt-1 text-sm font-semibold text-gray-900">{{ $ticket->category->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase">Phòng / Vị trí</p>
                        <p class="mt-1 text-sm font-semibold text-gray-900">{{ $ticket->room ? $ticket->room->name : 'N/A' }}</p>
                        @if($ticket->room)
                            <p class="text-xs text-gray-500">{{ $ticket->room->location }}</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="flex justify-center">
                <a href="{{ route('tickets.index') }}" class="text-sm font-medium text-gray-500 hover:text-indigo-600 transition flex items-center">
                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Quay lại danh sách
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
