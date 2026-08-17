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
}
