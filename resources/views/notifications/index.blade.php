@extends('layouts.app')

@section('title', 'Quản lý Thông báo')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Danh sách Thông báo</h1>
        <a href="{{ route('notifications.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow transition">Gửi thông báo mới</a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border-b p-3 font-semibold text-sm">Người nhận</th>
                    <th class="border-b p-3 font-semibold text-sm">Tiêu đề</th>
                    <th class="border-b p-3 font-semibold text-sm">Trạng thái</th>
                    <th class="border-b p-3 font-semibold text-sm">Ngày gửi</th>
                    <th class="border-b p-3 font-semibold text-sm text-center">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach($notifications as $notification)
                <tr class="hover:bg-gray-50 transition {{ $notification->is_read ? 'opacity-75' : 'font-semibold' }}">
                    <td class="border-b p-3 text-sm">{{ $notification->user->name }}</td>
                    <td class="border-b p-3 text-sm">{{ $notification->title }}</td>
                    <td class="border-b p-3 text-sm">
                        @if($notification->is_read)
                            <span class="text-green-600">Đã đọc</span>
                        @else
                            <span class="text-blue-600">Chưa đọc</span>
                        @endif
                    </td>
                    <td class="border-b p-3 text-sm">{{ $notification->created_at->format('d/m/Y H:i') }}</td>
                    <td class="border-b p-3 text-center">
                        <div class="flex justify-center space-x-2">
                            <a href="{{ route('notifications.show', $notification) }}" class="text-blue-600 hover:text-blue-800 text-sm">Xem</a>
                            <form action="{{ route('notifications.destroy', $notification) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-semibold">Xóa</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $notifications->links() }}
    </div>
</div>
@endsection
