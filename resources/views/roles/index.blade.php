@extends('layouts.app')

@section('title', 'Quản lý Vai trò')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Danh sách Vai trò</h1>
        <a href="{{ route('roles.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow transition">Thêm mới</a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border-b p-3 font-semibold">ID</th>
                    <th class="border-b p-3 font-semibold">Tên vai trò</th>
                    <th class="border-b p-3 font-semibold">Mô tả</th>
                    <th class="border-b p-3 font-semibold text-center">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach($roles as $role)
                <tr class="hover:bg-gray-50 transition">
                    <td class="border-b p-3">{{ $role->id }}</td>
                    <td class="border-b p-3 font-medium">{{ $role->name }}</td>
                    <td class="border-b p-3 text-gray-600 text-sm">{{ $role->description }}</td>
                    <td class="border-b p-3 text-center">
                        <div class="flex justify-center space-x-2">
                            <a href="{{ route('roles.edit', $role) }}" class="text-yellow-600 hover:text-yellow-800 font-semibold text-sm">Sửa</a>
                            <form action="{{ route('roles.destroy', $role) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 font-semibold text-sm">Xóa</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $roles->links() }}
    </div>
</div>
@endsection
