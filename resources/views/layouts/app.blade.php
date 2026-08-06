<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Helpdesk System - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-blue-600 p-4 text-white shadow-lg">
        <div class="container mx-auto flex justify-between items-center">
            <a href="{{ route('dashboard') }}" class="text-xl font-bold">Helpdesk Demo 1</a>
            @auth
                <div class="flex items-center space-x-6">
                    <div class="space-x-4">
                        <a href="{{ route('dashboard') }}" class="hover:text-blue-200">Dashboard</a>
                        <a href="{{ route('tickets.index') }}" class="hover:text-blue-200">Yêu cầu của tôi</a>
                    </div>
                    <div class="flex items-center space-x-4 border-l pl-6">
                        <span>Xin chào, <strong>{{ Auth::user()->name }}</strong></span>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-red-500 hover:bg-red-700 px-4 py-2 rounded text-sm transition font-semibold">Đăng xuất</button>
                        </form>
                    </div>
                </div>
            @endauth
        </div>
    </nav>

    <main class="container mx-auto mt-10 p-4">
        @yield('content')
    </main>
</body>
</html>
