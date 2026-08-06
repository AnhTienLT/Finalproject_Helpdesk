<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return redirect('/login');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Admin Only Routes
    Route::middleware(['role:Admin'])->group(function () {
        Route::get('/admin/test', function () {
            return "Chào Admin! Bạn có quyền truy cập vào trang quản trị này.";
        });
    });

    // Technician Only Routes
    Route::middleware(['role:Technician'])->group(function () {
        Route::get('/tech/test', function () {
            return "Chào Kỹ thuật viên! Đây là khu vực dành cho bạn.";
        });
    });
});
