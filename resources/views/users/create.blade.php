@extends('layouts.app')

@section('title', 'Thêm Người dùng')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-6">Thêm Người dùng mới</h1>

    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Họ tên</label>
                <input type="text" name="name" id="name" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2 border" value="{{ old('name') }}" required>
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" id="email" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2 border" value="{{ old('email') }}" required>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Mật khẩu</label>
                <input type="password" name="password" id="password" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2 border" required>
            </div>

            <div class="mb-4">
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Số điện thoại</label>
                <input type="text" name="phone" id="phone" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2 border" value="{{ old('phone') }}">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="mb-4">
                <label for="role_id" class="block text-sm font-medium text-gray-700 mb-1">Vai trò</label>
                <select name="role_id" id="role_id" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2 border" required>
                    <option value="">-- Chọn vai trò --</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="department_id" class="block text-sm font-medium text-gray-700 mb-1">Phòng ban</label>
                <select name="department_id" id="department_id" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2 border" required>
                    <option value="">-- Chọn phòng ban --</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="flex justify-end space-x-3 mt-6">
            <a href="{{ route('users.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition">Hủy</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition font-semibold">Lưu người dùng</button>
        </div>
    </form>
</div>
@endsection
