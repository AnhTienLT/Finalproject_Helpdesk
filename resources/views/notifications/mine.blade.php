@extends('layouts.app')

@section('title', 'Thông báo của tôi')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="sm:flex sm:items-center sm:justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl">Thông báo của tôi</h2>
            <p class="mt-1 text-sm text-gray-500">Các cập nhật liên quan tới yêu cầu bạn tạo hoặc phụ trách.</p>
        </div>
        <form action="{{ route('notifications.markAllRead') }}" method="POST" class="mt-4 sm:mt-0">
            @csrf
            <button type="submit" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition">
                Đánh dấu tất cả đã đọc
            </button>
        </form>
    </div>

    @if(session('success')) <div class="mb-4 p-3 rounded bg-green-50 text-green-700 text-sm">{{ session('success') }}</div> @endif

    <div class="bg-white shadow-sm border border-gray-200 rounded-lg divide-y divide-gray-100">
        @forelse($notifications as $n)
            <div class="p-5 flex items-start justify-between {{ $n->is_read ? 'bg-white' : 'bg-indigo-50/40' }}">
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2">
                        @if(!$n->is_read)
                            <span class="inline-block h-2 w-2 rounded-full bg-indigo-500"></span>
                        @endif
                        <p class="text-sm font-semibold text-gray-900">{{ $n->title }}</p>
                        <span class="text-xs text-gray-400">· {{ $n->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="mt-1 text-sm text-gray-600">{{ $n->message }}</p>
                </div>
                <div class="ml-4 flex-shrink-0">
                    @if($n->link)
                        <form action="{{ route('notifications.markRead', $n) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">Mở →</button>
                        </form>
                    @else
                        <form action="{{ route('notifications.markRead', $n) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="text-sm text-gray-500 hover:text-gray-700">Đánh dấu đã đọc</button>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <div class="p-10 text-center text-sm text-gray-500 italic">Bạn chưa có thông báo nào.</div>
        @endforelse
    </div>

    <div class="mt-6">{{ $notifications->links() }}</div>
</div>
@endsection
