@extends('layouts.app')

@section('title', 'Gửi Thông báo')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="md:flex md:items-center md:justify-between mb-6">
        <div class="flex-1 min-w-0">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl">Gửi thông báo mới</h2>
            <p class="mt-1 text-sm text-gray-500">Soạn thảo và gửi thông báo hệ thống đến người dùng cụ thể.</p>
        </div>
    </div>

    <div class="bg-white shadow-sm border border-gray-200 rounded-lg overflow-hidden">
        <form action="{{ route('notifications.store') }}" method="POST" class="divide-y divide-gray-200">
            @csrf
            <div class="p-6 space-y-6">
                <div>
                    <label for="user_id" class="block text-sm font-semibold text-gray-700 mb-2">Người nhận</label>
                    <select name="user_id" id="user_id" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-2.5 border @error('user_id') border-red-500 @enderror" required>
                        <option value="">-- Chọn người dùng --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">Tiêu đề thông báo</label>
                    <input type="text" name="title" id="title" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-2.5 border @error('title') border-red-500 @enderror" value="{{ old('title') }}" placeholder="VD: Bảo trì hệ thống, Cập nhật chính sách..." required>
                    @error('title')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="message" class="block text-sm font-semibold text-gray-700 mb-2">Nội dung chi tiết</label>
                    <textarea name="message" id="message" rows="6" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-2.5 border @error('message') border-red-500 @enderror" placeholder="Nhập nội dung thông báo tại đây..." required>{{ old('message') }}</textarea>
                    @error('message')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="px-6 py-4 bg-gray-50 flex items-center justify-between">
                <p class="text-xs text-gray-500 italic">Thông báo sẽ xuất hiện ngay lập tức trong tài khoản của người nhận.</p>
                <div class="flex space-x-3">
                    <a href="{{ route('notifications.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition">
                        Hủy bỏ
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 transition">
                        <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                        Gửi thông báo
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
