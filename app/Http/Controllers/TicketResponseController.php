<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketResponseController extends Controller
{
    public function store(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'message' => 'required',
        ], [
            'message.required' => 'Nội dung phản hồi không được để trống.',
        ]);

        TicketResponse::create([
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'message' => $validated['message'],
        ]);

        // Tự động chuyển trạng thái ticket sang in_progress nếu Tech hoặc Admin phản hồi
        if (Auth::user()->role->name !== 'User' && $ticket->status === 'open') {
            $ticket->update(['status' => 'in_progress']);
        }

        return back()->with('success', 'Phản hồi đã được gửi.');
    }

    public function destroy(TicketResponse $response)
    {
        $user = Auth::user();

        // Chỉ Admin hoặc chính người viết phản hồi mới có quyền xóa
        if ($user->role->name === 'Admin' || $response->user_id === $user->id) {
            $response->delete();
            return back()->with('success', 'Đã xóa phản hồi thành công.');
        }

        return back()->with('error', 'Bạn không có quyền xóa phản hồi này.');
    }
}
