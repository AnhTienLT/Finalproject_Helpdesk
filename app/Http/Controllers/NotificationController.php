<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    // Admin: quản lý toàn hệ thống
    public function index()
    {
        $notifications = Notification::with('user')->latest()->paginate(15);
        return view('notifications.index', compact('notifications'));
    }

    public function create()
    {
        $users = User::all();
        return view('notifications.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|max:200',
            'message' => 'required',
        ]);

        Notification::create($validated);

        return redirect()->route('notifications.index')->with('success', 'Gửi thông báo thành công!');
    }

    /**
     * Admin xem chi tiết notification bất kỳ (KHÔNG mark-read hộ) — S6.
     */
    public function show(Notification $notification)
    {
        return view('notifications.show', compact('notification'));
    }

    public function destroy(Notification $notification)
    {
        $notification->delete();
        return redirect()->route('notifications.index')->with('success', 'Xóa thông báo thành công!');
    }

    /**
     * Thông báo cá nhân của user đang đăng nhập (B5).
     */
    public function mine()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->latest()
            ->paginate(20);
        return view('notifications.mine', compact('notifications'));
    }

    /**
     * Đánh dấu 1 thông báo đã đọc (chỉ chính chủ), rồi điều hướng tới link nếu có.
     */
    public function markRead(Notification $notification)
    {
        if ($notification->user_id !== Auth::id()) {
            abort(403);
        }
        $notification->update(['is_read' => true]);

        if ($notification->link) {
            return redirect($notification->link);
        }
        return back();
    }

    public function markAllRead()
    {
        Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);
        return back()->with('success', 'Đã đánh dấu tất cả là đã đọc.');
    }
}
