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
        if ($user->role->name === 'Admin' || $user->role->name === 'Technician') {
            $tickets = Ticket::with(['user', 'category', 'priority'])->latest()->get();
        } else {
            $tickets = Ticket::where('user_id', $user->id)
                ->with(['category', 'priority'])
                ->latest()
                ->get();
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

        Ticket::create($validated);

        return redirect()->route('tickets.index')->with('success', 'Yêu cầu của bạn đã được gửi thành công!');
    }
}
