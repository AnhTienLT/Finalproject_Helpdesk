<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketStatusLog;
use App\Models\Category;
use App\Models\Priority;
use App\Models\Room;
use App\Models\User;
use App\Services\NotifyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    /**
     * State machine hợp lệ giữa các trạng thái.
     */
    private array $allowedTransitions = [
        'open'        => ['in_progress'],
        'in_progress' => ['resolved'],
        'resolved'    => ['closed', 'in_progress'], // cho phép reopen
        'closed'      => [],
    ];

    public function index(Request $request)
    {
        $user = Auth::user();

        $query = Ticket::query()->with(['user', 'category', 'priority', 'assignedTo']);

        // Nếu User thường → chỉ xem ticket của mình
        if (!$user->hasRole('Admin') && !$user->hasRole('Technician')) {
            $query->where('user_id', $user->id);
        }

        // Bộ lọc (B10)
        $query->when($request->filled('status'), fn ($q) => $q->where('status', $request->input('status')))
              ->when($request->filled('priority'), fn ($q) => $q->where('priority_id', $request->input('priority')))
              ->when($request->filled('category'), fn ($q) => $q->where('category_id', $request->input('category')))
              ->when($request->filled('assigned_to'), fn ($q) => $q->where('assigned_to', $request->input('assigned_to')))
              ->when($request->filled('q'), function ($q) use ($request) {
                  $kw = '%' . $request->input('q') . '%';
                  $q->where(function ($sub) use ($kw) {
                      $sub->where('title', 'like', $kw)->orWhere('description', 'like', $kw);
                  });
              });

        $tickets = $query->latest()->paginate(10)->withQueryString();

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

        $ticket = DB::transaction(function () use ($validated) {
            $ticket = Ticket::create($validated);
            TicketStatusLog::create([
                'ticket_id'   => $ticket->id,
                'user_id'     => Auth::id(),
                'from_status' => null,
                'to_status'   => 'open',
                'note'        => 'Ticket được tạo.',
            ]);
            return $ticket;
        });

        return redirect()->route('tickets.show', $ticket->id)
            ->with('success', 'Yêu cầu của bạn đã được gửi thành công!');
    }

    public function show(Ticket $ticket)
    {
        $ticket->load([
            'user.department', 'category', 'priority', 'room',
            'assignedTo', 'responses.user',
            'statusLogs.user',
        ]);

        // Quyền xem
        if (!Auth::user()->hasRole('Admin')
            && !Auth::user()->hasRole('Technician')
            && $ticket->user_id !== Auth::id()) {
            abort(403, 'Bạn không có quyền xem yêu cầu này.');
        }

        return view('tickets.show', compact('ticket'));
    }

    /**
     * Sửa ticket (chỉ chủ ticket & còn ở trạng thái open).
     */
    public function edit(Ticket $ticket)
    {
        $this->authorizeOwner($ticket);
        if ($ticket->status !== 'open') {
            abort(403, 'Chỉ có thể sửa ticket khi còn ở trạng thái Mới.');
        }
        $categories = Category::all();
        $priorities = Priority::orderBy('level', 'asc')->get();
        $rooms = Room::all();
        return view('tickets.edit', compact('ticket', 'categories', 'priorities', 'rooms'));
    }

    public function update(Request $request, Ticket $ticket)
    {
        $this->authorizeOwner($ticket);
        if ($ticket->status !== 'open') {
            abort(403, 'Chỉ có thể sửa ticket khi còn ở trạng thái Mới.');
        }
        $validated = $request->validate([
            'title' => 'required|max:200',
            'description' => 'required',
            'category_id' => 'required|exists:categories,id',
            'priority_id' => 'required|exists:priorities,id',
            'room_id' => 'nullable|exists:rooms,id',
        ]);
        $ticket->update($validated);
        return redirect()->route('tickets.show', $ticket)->with('success', 'Đã cập nhật yêu cầu.');
    }

    public function destroy(Ticket $ticket)
    {
        $this->authorizeOwner($ticket);
        if ($ticket->status !== 'open') {
            abort(403, 'Chỉ có thể huỷ ticket khi còn ở trạng thái Mới.');
        }
        DB::transaction(function () use ($ticket) {
            $ticket->responses()->delete();
            $ticket->statusLogs()->delete();
            $ticket->delete();
        });
        return redirect()->route('tickets.index')->with('success', 'Đã huỷ ticket.');
    }

    /**
     * Kỹ thuật viên/Admin tiếp nhận Ticket.
     */
    public function assignToMe(Ticket $ticket)
    {
        $user = Auth::user();
        if (!$user->hasRole('Technician') && !$user->hasRole('Admin')) {
            abort(403);
        }

        if ($ticket->status === 'closed') {
            return back()->with('error', 'Ticket đã đóng, không thể tiếp nhận.');
        }
        if ($ticket->assigned_to && $ticket->assigned_to !== $user->id) {
            return back()->with('error', 'Ticket đang được xử lý bởi người khác.');
        }

        DB::transaction(function () use ($ticket, $user) {
            $from = $ticket->status;
            $ticket->update([
                'assigned_to' => $user->id,
                'status'      => $from === 'open' ? 'in_progress' : $from,
            ]);
            if ($ticket->status !== $from) {
                TicketStatusLog::create([
                    'ticket_id'   => $ticket->id,
                    'user_id'     => $user->id,
                    'from_status' => $from,
                    'to_status'   => $ticket->status,
                    'note'        => 'Tự động chuyển In progress khi tiếp nhận.',
                ]);
            }
        });

        NotifyService::for($ticket->fresh())->assigned($user);

        return back()->with('success', 'Bạn đã tiếp nhận yêu cầu này.');
    }

    /**
     * Cập nhật trạng thái Ticket với state machine + resolution note.
     */
    public function updateStatus(Request $request, Ticket $ticket)
    {
        $user = Auth::user();
        if (!$user->hasRole('Technician') && !$user->hasRole('Admin')) {
            abort(403);
        }

        $validated = $request->validate([
            'status'          => 'required|in:open,in_progress,resolved,closed',
            'resolution_note' => 'required_if:status,resolved|nullable|string|max:2000',
        ]);

        $from = $ticket->status;
        $to = $validated['status'];

        if (!in_array($to, $this->allowedTransitions[$from] ?? [], true)) {
            return back()->with('error', "Không thể chuyển từ '{$from}' sang '{$to}'.");
        }

        if ($to === 'closed' && $ticket->responses()->count() === 0) {
            return back()->with('error', 'Ticket chưa có phản hồi nào, không thể đóng.');
        }

        DB::transaction(function () use ($ticket, $from, $to, $validated, $user) {
            $updates = ['status' => $to];
            if ($to === 'resolved') {
                $updates['resolution_note'] = $validated['resolution_note'] ?? $ticket->resolution_note;
                $updates['resolved_at'] = now();
            }
            if ($to === 'closed') {
                $updates['closed_at'] = now();
            }
            $ticket->update($updates);

            TicketStatusLog::create([
                'ticket_id'   => $ticket->id,
                'user_id'     => $user->id,
                'from_status' => $from,
                'to_status'   => $to,
                'note'        => $validated['resolution_note'] ?? null,
            ]);
        });

        NotifyService::for($ticket->fresh())->statusChanged($user, $from, $to);

        return back()->with('success', 'Trạng thái yêu cầu đã được cập nhật.');
    }

    private function authorizeOwner(Ticket $ticket): void
    {
        if ($ticket->user_id !== Auth::id() && !Auth::user()->hasRole('Admin')) {
            abort(403, 'Bạn không có quyền chỉnh sửa yêu cầu này.');
        }
    }
}
