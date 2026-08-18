<!DOCTYPE html>
<html lang="vi" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Helpdesk - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="h-full">
    <div class="min-h-full">
        <nav class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-50">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                                <div class="bg-indigo-600 p-1.5 rounded-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                </div>
                                <span class="text-xl font-bold text-gray-900 tracking-tight">Helpdesk</span>
                            </a>
                        </div>
                        @auth
                        <div class="hidden sm:-my-px sm:ml-8 sm:flex sm:space-x-8">
                            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition duration-150 ease-in-out">
                                Dashboard
                            </a>
                            <a href="{{ route('tickets.index') }}" class="{{ request()->routeIs('tickets.*') ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition duration-150 ease-in-out">
                                Yêu cầu
                            </a>
                            <a href="{{ route('assets.index') }}" class="{{ request()->routeIs('assets.*') ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition duration-150 ease-in-out">
                                Tài sản
                            </a>
                        </div>
                        @endauth
                    </div>

                    @auth
                    <div class="flex items-center">
                        @if(Auth::user()->hasRole('Admin'))
                        <div class="relative group mr-4">
                            <button class="text-gray-500 hover:text-gray-700 px-3 py-2 rounded-md text-sm font-medium inline-flex items-center group-hover:text-indigo-600 transition">
                                <span>Quản trị</span>
                                <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <div class="absolute right-0 w-48 mt-0 origin-top-right bg-white border border-gray-200 divide-y divide-gray-100 rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition duration-200 z-50">
                                <div class="py-1">
                                    <a href="{{ route('users.index') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700">
                                        <svg class="mr-3 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                        Người dùng
                                    </a>
                                    <a href="{{ route('reports.index') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700">
                                        <svg class="mr-3 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                        Báo cáo & Thống kê
                                    </a>
                                    <a href="{{ route('roles.index') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700">
                                        <svg class="mr-3 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                        Vai trò
                                    </a>
                                </div>
                                <div class="py-1">
                                    <a href="{{ route('departments.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700">Phòng ban</a>
                                    <a href="{{ route('categories.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700">Danh mục</a>
                                    <a href="{{ route('priorities.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700">Độ ưu tiên</a>
                                    <a href="{{ route('rooms.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700">Vị trí</a>
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="ml-4 flex items-center md:ml-6">
                            <div class="flex flex-col text-right mr-3">
                                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">{{ Auth::user()->role->name ?? 'User' }}</span>
                                <span class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</span>
                            </div>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="p-2 text-gray-400 hover:text-red-500 transition duration-150">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                    @else
                    <div class="flex items-center">
                        <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-900 font-semibold px-4 py-2 rounded-lg hover:bg-indigo-50 transition">Đăng nhập</a>
                    </div>
                    @endauth
                </div>
            </div>
        </nav>

        <header class="bg-white shadow-sm lg:static lg:overflow-y-visible py-4 border-b border-gray-100">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <h1 class="text-lg font-semibold text-gray-900">@yield('title')</h1>
            </div>
        </header>

        <main class="py-10">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                @if (session('success'))
                    <div class="mb-6 rounded-md bg-green-50 p-4 border border-green-200">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 rounded-md bg-red-50 p-4 border border-red-200">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>

        <footer class="bg-white border-t border-gray-200 mt-auto py-8">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <p class="text-center text-gray-400 text-sm">
                    &copy; {{ date('Y') }} Helpdesk Management System. Built with Laravel 12 & Tailwind CSS.
                </p>
            </div>
        </footer>
    </div>
</body>
</html>
