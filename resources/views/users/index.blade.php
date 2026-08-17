@extends('layouts.app')

@section('title', 'Quản lý Người dùng')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Danh sách Người dùng</h1>
        <a href="{{ route('users.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow transition">Thêm mới</a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border-b p-3 font-semibold">Tên</th>
                    <th class="border-b p-3 font-semibold">Email</th>
                    <th class="border-b p-3 font-semibold">Vai trò</th>
                    <th class="border-b p-3 font-semibold">Phòng ban</th>
                    <th class="border-b p-3 font-semibold text-center">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr class="hover:bg-gray-50 transition">
                    <td class="border-b p-3 font-medium">{{ $user->name }}</td>
                    <td class="border-b p-3">{{ $user->email }}</td>
                    <td class="border-b p-3">
                        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold">
                            {{ $user->role->name ?? 'N/A' }}
                        </span>
                    </td>
                    <td class="border-b p-3 text-gray-600 text-sm">{{ $user->department->name ?? 'N/A' }}</td>
                    <td class="border-b p-3 text-center">
                        <div class="flex justify-center space-x-2">
                            <a href="{{ route('users.edit', $user) }}" class="text-yellow-600 hover:text-yellow-800 font-semibold text-sm">Sửa</a>
                            @if($user->id !== auth()->id())
                            <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 font-semibold text-sm">Xóa</button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $users->links() }}
    </div>
</div>
@endsection
