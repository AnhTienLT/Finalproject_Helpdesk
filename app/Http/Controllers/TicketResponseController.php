<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketResponse;
use App\Services\NotifyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketResponseController extends Controller
{
    public function store(Request $request, Ticket $ticket)
    {
        $user = Auth::user();

        // S1: Kiểm tra quyền phản hồi (chủ ticket, Admin, hoặc Technician)
        $canRespond = $ticket->user_id === $user->id
            || $user->hasRole('Admin')
            || $user->hasRole('Technician');

        if (!$canRespond) {
            abort(403, 'Bạn không có quyền phản hồi ticket này.');
        }

        if ($ticket->status === 'closed') {
            return back()->with('error', 'Ticket đã đóng, không thể phản hồi.');
        }

        $validated = $request->validate([
            'message' => 'required|string|max:5000',
        ]);

        TicketResponse::create([
            'ticket_id' => $ticket->id,
            'user_id' => $user->id,
            'message' => $validated['message'],
        ]);

        // Auto-assign & chuyển trạng thái CHỈ khi ticket chưa được gán
        if ($user->hasRole('Technician') || $user->hasRole('Admin')) {
            $updates = [];
            if ($ticket->status === 'open') {
                $updates['status'] = 'in_progress';
            }
            if (!$ticket->assigned_to) {
                $updates['assigned_to'] = $user->id;
            }
            if (!empty($updates)) {
                $ticket->update($updates);
            }
        }

        // Thông báo cho các bên liên quan (chủ ticket & người được gán, khác actor)
        NotifyService::for($ticket)->newResponse($user);

        return back()->with('success', 'Phản hồi đã được gửi.');
    }
}
