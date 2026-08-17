@extends('layouts.app')

@section('title', 'Chi tiết Ticket #' . $ticket->id)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center bg-white p-6 rounded-lg shadow-md border-l-4 {{ $ticket->status === 'closed' ? 'border-gray-500' : 'border-blue-600' }}">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">{{ $ticket->title }}</h1>
            <div class="mt-2 flex items-center space-x-4 text-sm text-gray-600">
                <span>Mã yêu cầu: <strong>#{{ $ticket->id }}</strong></span>
                <span>•</span>
                <span>Ngày tạo: {{ $ticket->created_at->format('d/m/Y H:i') }}</span>
            </div>
        </div>
        <div class="text-right">
            <span class="px-4 py-2 rounded-full text-sm font-bold text-white" style="background-color: {{ $ticket->priority->color }}">
                {{ $ticket->priority->name }}
            </span>
            <div class="mt-2">
                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-semibold uppercase">
                    {{ str_replace('_', ' ', $ticket->status) }}
                </span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="md:col-span-2 space-y-6">
            <!-- Ticket Description -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-lg font-bold mb-4 border-b pb-2">Mô tả chi tiết</h2>
                <div class="text-gray-700 whitespace-pre-line">
                    {{ $ticket->description }}
                </div>
            </div>

            <!-- Responses (Conversation) -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-lg font-bold mb-6 border-b pb-2">Thảo luận & Phản hồi</h2>

                <div class="space-y-6 mb-8">
                    @forelse($ticket->responses as $response)
                        <div class="flex space-x-4 {{ $response->user_id === Auth::id() ? 'justify-end' : '' }}">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center font-bold text-gray-600">
                                    {{ substr($response->user->name, 0, 1) }}
                                </div>
                            </div>
                            <div class="max-w-[80%] {{ $response->user_id === Auth::id() ? 'bg-blue-50 border-blue-100' : 'bg-gray-50 border-gray-100' }} border p-4 rounded-lg">
                                <div class="flex justify-between items-center mb-1">
                                    <span class="font-bold text-sm">{{ $response->user->name }}</span>
                                    <span class="text-xs text-gray-500 ml-4">{{ $response->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="text-gray-700 text-sm">
                                    {{ $response->message }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500 text-sm">Chưa có phản hồi nào.</p>
                    @endforelse
                </div>

                <!-- Response Form -->
                <form action="{{ route('responses.store', $ticket->id) }}" method="POST" class="mt-6 border-t pt-6">
                    @csrf
                    <div class="mb-4">
                        <textarea name="message" rows="3" class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="Nhập phản hồi của bạn tại đây..." required></textarea>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-6 rounded-lg transition">
                            Gửi phản hồi
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="space-y-6">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-lg font-bold mb-4 border-b pb-2">Thông tin liên quan</h2>
                <div class="space-y-4 text-sm">
                    <div>
                        <p class="text-gray-500">Người yêu cầu</p>
                        <p class="font-semibold">{{ $ticket->user->name }}</p>
                        <p class="text-xs text-gray-400">{{ $ticket->user->department->name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Danh mục</p>
                        <p class="font-semibold">{{ $ticket->category->name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Phòng/Vị trí</p>
                        <p class="font-semibold">{{ $ticket->room ? $ticket->room->name : 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Người xử lý</p>
                        <p class="font-semibold text-blue-600">
                            {{ $ticket->assignedTo ? $ticket->assignedTo->name : 'Đang chờ tiếp nhận...' }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200 text-sm text-yellow-800">
                <p><strong>Lưu ý:</strong> Mọi phản hồi sẽ được gửi thông báo đến các bên liên quan.</p>
            </div>
        </div>
    </div>

    <div class="flex justify-center pb-10">
        <a href="{{ route('tickets.index') }}" class="text-gray-500 hover:text-gray-800 flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Quay lại danh sách
        </a>
    </div>
</div>
@endsection
