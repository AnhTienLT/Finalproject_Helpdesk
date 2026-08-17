<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
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

    public function show(Notification $notification)
    {
        $notification->update(['is_read' => true]);
        return view('notifications.show', compact('notification'));
    }

    public function destroy(Notification $notification)
    {
        $notification->delete();
        return redirect()->route('notifications.index')->with('success', 'Xóa thông báo thành công!');
    }
}
