<?php

use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TicketResponseController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PriorityController;
use App\Http\Controllers\NotificationController;

Route::get('/', function () {
    return redirect('/login');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin Only Routes
    Route::middleware(['role:Admin'])->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('roles', RoleController::class);
        Route::resource('departments', DepartmentController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('priorities', PriorityController::class);
        Route::resource('notifications', NotificationController::class);

        Route::get('/admin/test', function () {
            return "Chào Admin! Bạn có quyền truy cập vào trang quản trị này.";
        });
    });

    // Resource routes accessible by multiple roles
    Route::resource('tickets', TicketController::class);
    Route::resource('assets', AssetController::class);
    Route::resource('rooms', RoomController::class);

    // Technician Only Routes
    Route::middleware(['role:Technician'])->group(function () {
        Route::get('/tech/test', function () {
            return "Chào Kỹ thuật viên! Đây là khu vực dành cho bạn.";
        });
    });
});
