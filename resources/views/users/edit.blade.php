@extends('layouts.app')

@section('title', 'Chỉnh sửa nhân viên')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white shadow-sm rounded-lg border border-gray-200 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-bold text-gray-900">Chỉnh sửa thông tin nhân viên</h3>
            <p class="mt-1 text-sm text-gray-500">Cập nhật tài khoản và quyền hạn cho <strong>{{ $user->name }}</strong>.</p>
        </div>

        <form action="{{ route('users.update', $user) }}" method="POST" class="p-8 space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Họ tên nhân viên</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                        class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border p-2.5 @error('name') border-red-500 @enderror"
                        required>
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Địa chỉ Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                        class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border p-2.5 @error('email') border-red-500 @enderror"
                        required>
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Mật khẩu mới (Để trống nếu không đổi)</label>
                    <input type="password" name="password" id="password"
                        class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border p-2.5 @error('password') border-red-500 @enderror"
                        placeholder="••••••••">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="phone" class="block text-sm font-semibold text-gray-700 mb-1">Số điện thoại</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}"
                        class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border p-2.5 @error('phone') border-red-500 @enderror">
                    @error('phone')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="role_id" class="block text-sm font-semibold text-gray-700 mb-1">Vai trò hệ thống</label>
                    <select name="role_id" id="role_id" required
                        class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border p-2.5 bg-white">
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="department_id" class="block text-sm font-semibold text-gray-700 mb-1">Phòng ban</label>
                    <select name="department_id" id="department_id" required
                        class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border p-2.5 bg-white">
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}" {{ old('department_id', $user->department_id) == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="pt-4 flex items-center justify-between border-t border-gray-100">
                <span class="text-xs text-gray-400 italic">Cập nhật lần cuối: {{ $user->updated_at->format('d/m/Y H:i') }}</span>
                <div class="flex space-x-3">
                    <a href="{{ route('users.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 transition">
                        Hủy bỏ
                    </a>
                    <button type="submit" class="px-6 py-2 text-sm font-bold text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 transition">
                        Lưu thay đổi
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
