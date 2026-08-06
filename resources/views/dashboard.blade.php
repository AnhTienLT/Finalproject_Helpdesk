@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="bg-white p-8 rounded-lg shadow-md">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Bảng điều khiển (Demo 1)</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Thông tin User -->
        <div class="bg-blue-50 p-6 rounded-lg border border-blue-200">
            <h2 class="text-xl font-semibold text-blue-800 mb-4">Thông tin cá nhân</h2>
            <p><strong>Họ tên:</strong> {{ Auth::user()->name }}</p>
            <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
            <p><strong>Vai trò:</strong> {{ Auth::user()->role->name }}</p>
            <p><strong>Phòng ban:</strong> {{ Auth::user()->department->name }}</p>
        </div>

        <!-- Chức năng Demo -->
        <div class="bg-green-50 p-6 rounded-lg border border-green-200">
            <h2 class="text-xl font-semibold text-green-800 mb-4">Chức năng hệ thống</h2>
            <ul class="list-disc ml-5 space-y-2">
                <li>Gửi yêu cầu hỗ trợ (Ticket)</li>
                <li>Quản lý tài sản (Assets)</li>
                <li>Theo dõi bảo trì</li>
            </ul>
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
