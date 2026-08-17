@extends('layouts.app')

@section('title', 'Gửi Thông báo')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-md">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Gửi Thông báo Mới</h1>
        <a href="{{ route('notifications.index') }}" class="text-gray-600 hover:text-gray-900">&larr; Quay lại</a>
    </div>

    <form action="{{ route('notifications.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="user_id" class="block text-gray-700 font-semibold mb-2">Người nhận</label>
            <select name="user_id" id="user_id" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('user_id') border-red-500 @enderror" required>
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

        <div class="mb-4">
            <label for="title" class="block text-gray-700 font-semibold mb-2">Tiêu đề</label>
            <input type="text" name="title" id="title" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('title') border-red-500 @enderror" value="{{ old('title') }}" required>
            @error('title')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="message" class="block text-gray-700 font-semibold mb-2">Nội dung</label>
            <textarea name="message" id="message" rows="5" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('message') border-red-500 @enderror" required>{{ old('message') }}</textarea>
            @error('message')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded shadow transition">Gửi đi</button>
        </div>
    </form>
</div>
@endsection
