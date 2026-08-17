@extends('layouts.app')

@section('title', 'Quản lý Thông báo')

@section('content')
<div class="sm:flex sm:items-center sm:justify-between mb-8">
    <div class="flex-1 min-w-0">
        <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
            Trung tâm thông báo
        </h2>
        <p class="mt-1 text-sm text-gray-500">
            Theo dõi và gửi thông báo hệ thống đến người dùng.
        </p>
    </div>
    <div class="mt-4 flex sm:mt-0 sm:ml-4">
        <a href="{{ route('notifications.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
            Gửi thông báo mới
        </a>
    </div>
</div>

<div class="bg-white shadow overflow-hidden sm:rounded-md border border-gray-200">
    <ul class="divide-y divide-gray-200">
        @forelse($notifications as $notification)
        <li>
            <a href="{{ route('notifications.show', $notification) }}" class="block hover:bg-gray-50 transition duration-150 ease-in-out">
                <div class="px-4 py-4 sm:px-6">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-semibold text-indigo-600 truncate flex items-center">
                            @if(!$notification->is_read)
                                <span class="flex-shrink-0 inline-block w-2 h-2 bg-indigo-600 rounded-full mr-2" title="Chưa đọc"></span>
                            @endif
                            {{ $notification->title }}
                        </p>
                        <div class="ml-2 flex-shrink-0 flex">
                            <p class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $notification->is_read ? 'bg-gray-100 text-gray-800' : 'bg-green-100 text-green-800' }}">
                                {{ $notification->is_read ? 'Đã đọc' : 'Mới' }}
                            </p>
                        </div>
                    </div>
                    <div class="mt-2 sm:flex sm:justify-between">
                        <div class="sm:flex">
                            <p class="flex items-center text-sm text-gray-500">
                                <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                Người nhận: {{ $notification->user->name }}
                            </p>
                        </div>
                        <div class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0">
                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <p>
                                Đã gửi vào <time datetime="{{ $notification->created_at }}">{{ $notification->created_at->format('d/m/Y H:i') }}</time>
                            </p>
                        </div>
                    </div>
                </div>
            </a>
        </li>
        @empty
        <li class="px-4 py-8 text-center text-gray-500 italic bg-gray-50">
            Chưa có thông báo nào được gửi.
        </li>
        @endforelse
    </ul>
</div>

<div class="mt-6">
    {{ $notifications->links() }}
</div>
@endsection
