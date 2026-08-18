@extends('layouts.app')

@section('title', 'Đăng nhập')

@section('content')
<div class="min-h-[60vh] flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md text-center">
        <div class="inline-flex items-center justify-center p-3 bg-indigo-600 rounded-xl shadow-lg mb-4">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
        </div>
        <h2 class="text-3xl font-extrabold text-gray-900">Đăng nhập hệ thống</h2>
        <p class="mt-2 text-sm text-gray-600">
            Truy cập bảng điều khiển Helpdesk của bạn
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow-xl border border-gray-100 sm:rounded-xl sm:px-10">
            @if($errors->any())
                <div class="mb-4 bg-red-50 border-l-4 border-red-400 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700">Thông tin đăng nhập không chính xác.</p>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Địa chỉ Email</label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" autocomplete="email" required
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            value="{{ old('email') }}">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Mật khẩu</label>
                    <div class="mt-1">
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <label for="remember_me" class="ml-2 block text-sm text-gray-900">Ghi nhớ đăng nhập</label>
                    </div>

                    <div class="text-sm">
                        <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">Quên mật khẩu?</a>
                    </div>
                </div>

                <div>
                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                        Đăng nhập
                    </button>
                </div>
            </form>

            <div class="mt-8 pt-6 border-t border-gray-100">
                <h4 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">Tài khoản trải nghiệm</h4>
                <div class="space-y-2">
                    <div class="flex items-center justify-between bg-gray-50 p-2 rounded text-xs">
                        <span class="text-gray-600">Quản trị: <strong>admin@helpdesk.com</strong></span>
                        <span class="text-gray-400 font-mono">password</span>
                    </div>
                    <div class="flex items-center justify-between bg-gray-50 p-2 rounded text-xs">
                        <span class="text-gray-600">Kỹ thuật: <strong>tech@helpdesk.com</strong></span>
                        <span class="text-gray-400 font-mono">password</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
