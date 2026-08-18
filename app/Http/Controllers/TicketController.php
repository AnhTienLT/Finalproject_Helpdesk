<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Category;
use App\Models\Priority;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Nếu là Admin hoặc Tech, xem tất cả. Nếu là User, chỉ xem ticket của mình.
        if ($user->hasRole('Admin') || $user->hasRole('Technician')) {
            $tickets = Ticket::with(['user', 'category', 'priority', 'assignedTo'])->latest()->paginate(10);
        } else {
            $tickets = Ticket::where('user_id', $user->id)
                ->with(['category', 'priority', 'assignedTo'])
                ->latest()
                ->paginate(10);
        }

        return view('tickets.index', compact('tickets'));
    }

    public function create()
    {
        $categories = Category::all();
        $priorities = Priority::orderBy('level', 'asc')->get();
        $rooms = Room::all();

        return view('tickets.create', compact('categories', 'priorities', 'rooms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:200',
            'description' => 'required',
            'category_id' => 'required|exists:categories,id',
            'priority_id' => 'required|exists:priorities,id',
            'room_id' => 'nullable|exists:rooms,id',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'open';

        $ticket = Ticket::create($validated);

        return redirect()->route('tickets.show', $ticket->id)->with('success', 'Yêu cầu của bạn đã được gửi thành công!');
    }

    public function show(Ticket $ticket)
    {
        $ticket->load(['user.department', 'category', 'priority', 'room', 'assignedTo', 'responses.user']);

        // Kiểm tra quyền xem (Admin/Tech có thể xem mọi ticket, User chỉ xem ticket của mình)
        if (!Auth::user()->hasRole('Admin') && !Auth::user()->hasRole('Technician') && $ticket->user_id !== Auth::id()) {
            abort(403, 'Bạn không có quyền xem yêu cầu này.');
        }

        return view('tickets.show', compact('ticket'));
    }

    /**
     * Kỹ thuật viên tiếp nhận Ticket
     */
    public function assignToMe(Ticket $ticket)
    {
        if (!Auth::user()->hasRole('Technician') && !Auth::user()->hasRole('Admin')) {
            abort(403);
        }

        $ticket->update([
            'assigned_to' => Auth::id(),
            'status' => 'in_progress'
        ]);

        return back()->with('success', 'Bạn đã tiếp nhận yêu cầu này.');
    }

    /**
     * Cập nhật trạng thái Ticket
     */
    public function updateStatus(Request $request, Ticket $ticket)
    {
        if (!Auth::user()->hasRole('Technician') && !Auth::user()->hasRole('Admin')) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => 'required|in:open,in_progress,resolved,closed',
        ]);

        $ticket->update($validated);

        return back()->with('success', 'Trạng thái yêu cầu đã được cập nhật.');
    }
}
