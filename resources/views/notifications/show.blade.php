@extends('layouts.app')

@section('title', 'Chi tiết Thông báo')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="md:flex md:items-center md:justify-between mb-6">
        <div class="flex-1 min-w-0">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl">Chi tiết thông báo</h2>
            <p class="mt-1 text-sm text-gray-500">Xem nội dung chi tiết của thông báo hệ thống.</p>
        </div>
        <div class="mt-4 flex md:mt-0 md:ml-4">
            <a href="{{ route('notifications.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition">
                &larr; Quay lại danh sách
            </a>
        </div>
    </div>

    <div class="bg-white shadow-sm border border-gray-200 rounded-lg overflow-hidden">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-900">{{ $notification->title }}</h3>
                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $notification->is_read ? 'bg-gray-100 text-gray-800' : 'bg-green-100 text-green-800' }}">
                    {{ $notification->is_read ? 'Đã đọc' : 'Mới' }}
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6 text-sm">
                <div class="flex items-center text-gray-500">
                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    <strong>Người nhận:</strong> <span class="ml-1 text-gray-900 font-medium">{{ $notification->user->name }}</span>
                </div>
                <div class="flex items-center text-gray-500">
                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <strong>Ngày gửi:</strong> <span class="ml-1 text-gray-900">{{ $notification->created_at->format('d/m/Y H:i') }}</span>
                </div>
            </div>

            <div class="bg-gray-50 p-6 rounded-lg border border-gray-100 text-gray-700 leading-relaxed whitespace-pre-wrap">
                {{ $notification->message }}
            </div>
        </div>

        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end">
            <form action="{{ route('notifications.destroy', $notification) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa thông báo này?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 transition">
                    <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    Xóa thông báo
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
