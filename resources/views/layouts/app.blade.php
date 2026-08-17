<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Helpdesk System - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900">
    <nav class="bg-blue-700 p-4 text-white shadow-lg">
        <div class="container mx-auto flex justify-between items-center">
            <a href="{{ route('dashboard') }}" class="text-xl font-bold flex items-center">
                <span class="mr-2">🛠️</span> Helpdesk System
            </a>
            @auth
                <div class="flex items-center space-x-6">
                    <div class="hidden md:flex space-x-4">
                        <a href="{{ route('dashboard') }}" class="hover:bg-blue-800 px-3 py-2 rounded transition">Dashboard</a>
                        <a href="{{ route('tickets.index') }}" class="hover:bg-blue-800 px-3 py-2 rounded transition">Yêu cầu</a>
                        <a href="{{ route('assets.index') }}" class="hover:bg-blue-800 px-3 py-2 rounded transition">Tài sản</a>

                        @if(Auth::user()->hasRole('Admin'))
                        <div class="relative group">
                            <button class="hover:bg-blue-800 px-3 py-2 rounded transition flex items-center">
                                Quản trị <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <div class="absolute right-0 w-48 bg-white text-gray-800 mt-0 rounded shadow-xl hidden group-hover:block z-50">
                                <a href="{{ route('users.index') }}" class="block px-4 py-2 hover:bg-gray-100">Người dùng</a>
                                <a href="{{ route('roles.index') }}" class="block px-4 py-2 hover:bg-gray-100">Vai trò</a>
                                <a href="{{ route('departments.index') }}" class="block px-4 py-2 hover:bg-gray-100">Phòng ban</a>
                                <a href="{{ route('categories.index') }}" class="block px-4 py-2 hover:bg-gray-100">Danh mục</a>
                                <a href="{{ route('priorities.index') }}" class="block px-4 py-2 hover:bg-gray-100">Độ ưu tiên</a>
                                <a href="{{ route('rooms.index') }}" class="block px-4 py-2 hover:bg-gray-100">Phòng máy/Vị trí</a>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="flex items-center space-x-4 border-l border-blue-500 pl-6">
                        <div class="text-right">
                            <p class="text-sm leading-none">Xin chào,</p>
                            <p class="font-bold text-sm">{{ Auth::user()->name }}</p>
                        </div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded text-sm transition font-semibold shadow">Đăng xuất</button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="hover:text-blue-200 font-semibold">Đăng nhập</a>
            @endauth
        </div>
    </nav>

    <div class="container mx-auto mt-6 px-4">
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 shadow-sm rounded" role="alert">
                <p class="font-bold">Thành công</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 shadow-sm rounded" role="alert">
                <p class="font-bold">Lỗi</p>
                <p>{{ session('error') }}</p>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6 shadow-sm rounded">
                <ul class="list-disc ml-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <main>
            @yield('content')
        </main>
    </div>

    <footer class="mt-20 py-10 bg-gray-200 text-center text-gray-600 text-sm">
        &copy; {{ date('Y') }} Helpdesk Management System. Laravel 12.
    </footer>
</body>
</html>
