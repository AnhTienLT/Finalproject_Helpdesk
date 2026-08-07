<?php

use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TicketController;

<<<<<<< HEAD
Route::get('/', fn () => redirect()->route('rooms.index'));

Route::resource('rooms', RoomController::class);
=======
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

    // Ticket Routes
    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
    Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');

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
>>>>>>> 54a89ad30240b3de97b5a935a2ac40ac51a63455
