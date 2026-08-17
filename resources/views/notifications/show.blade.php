@extends('layouts.app')

@section('title', 'Chi tiết Thông báo')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md">
    <div class="flex items-center justify-between mb-6 border-b pb-4">
        <h1 class="text-2xl font-bold">Chi tiết Thông báo</h1>
        <a href="{{ route('notifications.index') }}" class="text-blue-600 hover:text-blue-800">&larr; Quay lại danh sách</a>
    </div>

    <div class="mb-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-2">{{ $notification->title }}</h2>
        <div class="flex items-center text-sm text-gray-500 mb-4">
            <span class="mr-4"><strong>Gửi tới:</strong> {{ $notification->user->name }}</span>
            <span><strong>Ngày gửi:</strong> {{ $notification->created_at->format('d/m/Y H:i') }}</span>
        </div>
        <div class="bg-gray-50 p-4 rounded border border-gray-200 text-gray-700 leading-relaxed whitespace-pre-wrap">
            {{ $notification->message }}
        </div>
    </div>

    <div class="flex justify-end">
        <form action="{{ route('notifications.destroy', $notification) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa thông báo này?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded shadow transition">Xóa thông báo</button>
        </form>
    </div>
</div>
@endsection
