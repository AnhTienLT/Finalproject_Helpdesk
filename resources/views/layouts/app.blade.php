<!DOCTYPE html>
<<<<<<< HEAD
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Helpdesk CNTT & CSVC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="{{ route('rooms.index') }}">Helpdesk CNTT & CSVC</a>
            <div class="navbar-nav">
                <a class="nav-link active" href="{{ route('rooms.index') }}">Quản lý Phòng</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
=======
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
                        <a href="{{ route('tickets.index') }}" class="hover:text-blue-200">Yêu cầu</a>
                        <a href="{{ route('assets.index') }}" class="hover:text-blue-200">Tài sản</a>
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
>>>>>>> 54a89ad30240b3de97b5a935a2ac40ac51a63455
</body>
</html>
