@extends('layouts.app')

@section('title', 'Quản lý Vai trò')

@section('content')
<div class="sm:flex sm:items-center sm:justify-between mb-8">
    <div class="flex-1 min-w-0">
        <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
            Phân quyền hệ thống
        </h2>
        <p class="mt-1 text-sm text-gray-500">
            Định nghĩa các vai trò và quyền hạn truy cập cho các nhóm người dùng khác nhau.
        </p>
    </div>
    <div class="mt-4 flex sm:mt-0 sm:ml-4">
        <a href="{{ route('roles.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Thêm vai trò
        </a>
    </div>
</div>

<div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
    @foreach($roles as $role)
    <div class="bg-white overflow-hidden shadow rounded-lg border border-gray-200 hover:shadow-md transition duration-200 flex flex-col">
        <div class="px-6 py-5 flex-1">
            <div class="flex items-center justify-between mb-4">
                <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                    ID #{{ $role->id }}
                </span>
                <div class="flex space-x-2">
                    <a href="{{ route('roles.edit', $role) }}" class="text-gray-400 hover:text-indigo-600">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </a>
                    <form action="{{ route('roles.destroy', $role) }}" method="POST" onsubmit="return confirm('Xóa vai trò này có thể ảnh hưởng đến người dùng hiện tại. Tiếp tục?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-gray-400 hover:text-red-600">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </form>
                </div>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $role->name }}</h3>
            <p class="text-sm text-gray-500 leading-relaxed">
                {{ $role->description ?? 'Không có mô tả cho vai trò này.' }}
            </p>
        </div>
        <div class="bg-gray-50 px-6 py-3 border-t border-gray-100 flex justify-between items-center">
            <span class="text-xs text-gray-400 uppercase font-semibold tracking-wider italic">Hệ thống</span>
            <a href="{{ route('roles.edit', $role) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">Chỉnh sửa chi tiết →</a>
        </div>
    </div>
    @endforeach
</div>

<div class="mt-8">
    {{ $roles->links() }}
</div>
@endsection
