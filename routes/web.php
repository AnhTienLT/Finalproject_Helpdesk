<?php

use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TicketResponseController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\AssetCategoryController;
use App\Http\Controllers\MaintenanceLogController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PriorityController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ReportController;

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

    // Thông báo cá nhân (mọi vai trò)
    Route::get('/my-notifications', [NotificationController::class, 'mine'])->name('notifications.mine');
    Route::patch('/my-notifications/{notification}/read', [NotificationController::class, 'markRead'])->name('notifications.markRead');
    Route::post('/my-notifications/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifications.markAllRead');

    // Ticket: xem/tạo cho mọi role, sửa/xoá cho chủ ticket (kiểm tra trong controller)
    Route::get('tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('tickets/create', [TicketController::class, 'create'])->name('tickets.create');
    Route::post('tickets', [TicketController::class, 'store'])->name('tickets.store');
    Route::get('tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
    Route::get('tickets/{ticket}/edit', [TicketController::class, 'edit'])->name('tickets.edit');
    Route::put('tickets/{ticket}', [TicketController::class, 'update'])->name('tickets.update');
    Route::delete('tickets/{ticket}', [TicketController::class, 'destroy'])->name('tickets.destroy');
    Route::post('/tickets/{ticket}/responses', [TicketResponseController::class, 'store'])->name('responses.store');

    // Admin & Technician: tiếp nhận/đổi trạng thái ticket, quản lý phòng & tài sản
    Route::middleware(['role:Admin,Technician'])->group(function () {
        Route::post('/tickets/{ticket}/assign', [TicketController::class, 'assignToMe'])->name('tickets.assign');
        Route::patch('/tickets/{ticket}/status', [TicketController::class, 'updateStatus'])->name('tickets.updateStatus');

        Route::resource('rooms', RoomController::class);
        Route::resource('assets', AssetController::class);
        Route::resource('asset-categories', AssetCategoryController::class)->except(['show']);
        Route::resource('maintenance-logs', MaintenanceLogController::class)->except(['show']);
    });

    // Admin Only Routes
    Route::middleware(['role:Admin'])->group(function () {
        Route::resource('users', UserController::class)->except(['show']);
        Route::resource('roles', RoleController::class)->except(['show']);
        Route::resource('departments', DepartmentController::class)->except(['show']);
        Route::resource('categories', CategoryController::class)->except(['show']);
        Route::resource('priorities', PriorityController::class)->except(['show']);
        Route::resource('notifications', NotificationController::class)->except(['edit', 'update']);
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/assets-by-room', [ReportController::class, 'assetsByRoom'])->name('reports.assets');

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
