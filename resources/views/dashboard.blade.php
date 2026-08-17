@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="bg-white p-8 rounded-lg shadow-md">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Bảng điều khiển (Demo 1)</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Thống kê hệ thống -->
        <div class="bg-blue-50 p-6 rounded-lg border border-blue-200">
            <h2 class="text-xl font-semibold text-blue-800 mb-4">Thống kê hệ thống</h2>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-600">Người dùng</p>
                    <p class="text-2xl font-bold">{{ $stats['users_count'] }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Phòng ban</p>
                    <p class="text-2xl font-bold">{{ $stats['departments_count'] }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Yêu cầu (Ticket)</p>
                    <p class="text-2xl font-bold">{{ $stats['tickets_count'] }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Tài sản</p>
                    <p class="text-2xl font-bold">{{ $stats['assets_count'] }}</p>
                </div>
            </div>
        </div>

        <!-- Thông tin cá nhân -->
        <div class="bg-green-50 p-6 rounded-lg border border-green-200">
            <h2 class="text-xl font-semibold text-green-800 mb-4">Thông tin cá nhân</h2>
            <p><strong>Họ tên:</strong> {{ Auth::user()->name }}</p>
            <p><strong>Vai trò:</strong> {{ Auth::user()->role->name ?? 'N/A' }}</p>
            <p><strong>Phòng ban:</strong> {{ Auth::user()->department->name ?? 'N/A' }}</p>
        </div>

        <!-- Trạng thái Demo -->
        <div class="bg-purple-50 p-6 rounded-lg border border-purple-200">
            <h2 class="text-xl font-semibold text-purple-800 mb-4">Trạng thái Demo 1</h2>
            <p class="text-sm text-gray-600">Đã hoàn thành cấu hình Database, Model, Relationship, Seeder và Authentication.</p>
            <div class="mt-4 bg-purple-600 text-white text-center py-2 rounded">
                Hệ thống sẵn sàng
            </div>
        </div>
    </div>
</div>
@endsection
