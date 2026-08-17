@extends('layouts.app')

@section('title', 'Bảng điều khiển')

@section('content')
<div class="space-y-8">
    <!-- Header Section -->
    <div class="md:flex md:items-center md:justify-between">
        <div class="flex-1 min-w-0">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                Chào mừng trở lại, {{ Auth::user()->name }}!
            </h2>
            <p class="mt-1 text-sm text-gray-500">
                Đây là tổng quan về hệ thống Helpdesk của bạn ngày hôm nay.
            </p>
        </div>
        <div class="mt-4 flex md:mt-0 md:ml-4">
            <a href="{{ route('tickets.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                Xem danh sách yêu cầu
            </a>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
        <!-- Users Stat -->
        <div class="bg-white overflow-hidden shadow rounded-lg border border-gray-100 hover:shadow-md transition">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Người dùng</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900">{{ $stats['users_count'] }}</div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-5 py-3">
                <div class="text-sm text-indigo-700 font-medium"><a href="{{ route('users.index') }}" class="hover:text-indigo-900">Xem tất cả →</a></div>
            </div>
        </div>

        <!-- Tickets Stat -->
        <div class="bg-white overflow-hidden shadow rounded-lg border border-gray-100 hover:shadow-md transition">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-orange-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Yêu cầu (Ticket)</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900">{{ $stats['tickets_count'] }}</div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-5 py-3">
                <div class="text-sm text-indigo-700 font-medium"><a href="{{ route('tickets.index') }}" class="hover:text-indigo-900">Xem tất cả →</a></div>
            </div>
        </div>

        <!-- Assets Stat -->
        <div class="bg-white overflow-hidden shadow rounded-lg border border-gray-100 hover:shadow-md transition">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Tài sản</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900">{{ $stats['assets_count'] }}</div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-5 py-3">
                <div class="text-sm text-indigo-700 font-medium"><a href="{{ route('assets.index') }}" class="hover:text-indigo-900">Xem tất cả →</a></div>
            </div>
        </div>

        <!-- Departments Stat -->
        <div class="bg-white overflow-hidden shadow rounded-lg border border-gray-100 hover:shadow-md transition">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Phòng ban</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900">{{ $stats['departments_count'] }}</div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-5 py-3">
                <div class="text-sm text-indigo-700 font-medium"><a href="{{ route('departments.index') }}" class="hover:text-indigo-900">Quản lý →</a></div>
            </div>
        </div>
    </div>

    <!-- Content Bottom -->
    <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
        <!-- Personal Info Card -->
        <div class="bg-white shadow rounded-lg border border-gray-100">
            <div class="px-6 py-5 border-b border-gray-100">
                <h3 class="text-lg font-medium leading-6 text-gray-900 flex items-center">
                    <svg class="mr-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Thông tin tài khoản
                </h3>
            </div>
            <div class="px-6 py-6">
                <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500 uppercase tracking-wide">Họ tên</dt>
                        <dd class="mt-1 text-sm text-gray-900 font-semibold">{{ Auth::user()->name }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500 uppercase tracking-wide">Email</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ Auth::user()->email }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500 uppercase tracking-wide">Vai trò</dt>
                        <dd class="mt-1 flex items-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                {{ Auth::user()->role->name ?? 'Người dùng' }}
                            </span>
                        </dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500 uppercase tracking-wide">Phòng ban</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ Auth::user()->department->name ?? 'Chưa xác định' }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Quick Info / Log -->
        <div class="bg-indigo-700 rounded-lg shadow-xl overflow-hidden text-white relative">
            <div class="absolute top-0 right-0 p-8 opacity-10">
                <svg class="h-32 w-32" fill="currentColor" viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            </div>
            <div class="px-8 py-10 relative z-10">
                <h3 class="text-2xl font-bold mb-4">Trạng thái hệ thống</h3>
                <p class="text-indigo-100 text-lg mb-6 leading-relaxed">
                    Hệ thống Helpdesk đã hoàn tất Demo Module Quản trị. Bạn có thể bắt đầu quản lý người dùng, phân quyền và theo dõi các yêu cầu hỗ trợ một cách tập trung.
                </p>
                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0 w-2.5 h-2.5 rounded-full bg-green-400 animate-pulse"></div>
                        <span class="text-sm font-medium text-indigo-100">Dữ liệu Seeding hoàn tất</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0 w-2.5 h-2.5 rounded-full bg-green-400"></div>
                        <span class="text-sm font-medium text-indigo-100">Bảo mật Middleware Admin hoạt động</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0 w-2.5 h-2.5 rounded-full bg-indigo-300"></div>
                        <span class="text-sm font-medium text-indigo-100">Đang chờ xử lý: Module Tài sản & Bảo trì</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
