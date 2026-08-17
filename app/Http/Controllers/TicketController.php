<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Category;
use App\Models\Priority;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Nếu là Admin hoặc Tech, xem tất cả. Nếu là User, chỉ xem ticket của mình.
        if ($user->role->name === 'Admin' || $user->role->name === 'Technician') {
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
        ], [
            'title.required' => 'Tiêu đề yêu cầu không được để trống.',
            'title.max' => 'Tiêu đề không được vượt quá 200 ký tự.',
            'description.required' => 'Nội dung chi tiết yêu cầu không được để trống.',
            'category_id.required' => 'Vui lòng chọn danh mục yêu cầu.',
            'category_id.exists' => 'Danh mục đã chọn không hợp lệ.',
            'priority_id.required' => 'Vui lòng chọn mức độ ưu tiên.',
            'priority_id.exists' => 'Mức độ ưu tiên đã chọn không hợp lệ.',
            'room_id.exists' => 'Phòng máy / Vị trí đã chọn không hợp lệ.',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'open';

        Ticket::create($validated);

        return redirect()->route('tickets.index')->with('success', 'Yêu cầu của bạn đã được gửi thành công!');
    }

    public function show(Ticket $ticket)
    {
        $ticket->load(['user', 'assignedTo', 'category', 'priority', 'room', 'responses.user.role']);

        // Lấy danh sách kỹ thuật viên để hiển thị dropdown gán việc
        $technicians = User::whereHas('role', function ($q) {
            $q->where('name', 'Technician');
        })->get();

        return view('tickets.show', compact('ticket', 'technicians'));
    }

    public function edit(Ticket $ticket)
    {
        // Chỉ người tạo ra ticket mới có quyền sửa khi ticket chưa xử lý (open), hoặc Admin
        $user = Auth::user();
        if ($user->role->name !== 'Admin' && $ticket->user_id !== $user->id) {
            return redirect()->route('tickets.index')->with('error', 'Bạn không có quyền chỉnh sửa yêu cầu này.');
        }

        if ($user->role->name !== 'Admin' && $ticket->status !== 'open') {
            return redirect()->route('tickets.index')->with('error', 'Không thể sửa yêu cầu khi đã được tiếp nhận xử lý.');
        }

        $categories = Category::all();
        $priorities = Priority::orderBy('level', 'asc')->get();
        $rooms = Room::all();

        return view('tickets.edit', compact('ticket', 'categories', 'priorities', 'rooms'));
    }

    public function update(Request $request, Ticket $ticket)
    {
        $user = Auth::user();

        // Xử lý cập nhật nhanh Status & Assigned_to từ trang Show (dành cho Admin/Technician)
        if ($request->has('status') || $request->has('assigned_to')) {
            if ($user->role->name !== 'Admin' && $user->role->name !== 'Technician') {
                return back()->with('error', 'Bạn không có quyền thực hiện chức năng này.');
            }

            $validated = $request->validate([
                'status' => 'required|in:open,in_progress,resolved,closed',
                'assigned_to' => 'nullable|exists:users,id',
            ], [
                'status.required' => 'Trạng thái không được bỏ trống.',
                'status.in' => 'Trạng thái không hợp lệ.',
                'assigned_to.exists' => 'Kỹ thuật viên gán việc không hợp lệ.',
            ]);

            $ticket->update($validated);

            return redirect()->route('tickets.show', $ticket->id)->with('success', 'Cập nhật trạng thái và phân công thành công!');
        }

        // Xử lý sửa thông tin yêu cầu (dành cho người tạo)
        if ($user->role->name !== 'Admin' && $ticket->user_id !== $user->id) {
            return redirect()->route('tickets.index')->with('error', 'Bạn không có quyền chỉnh sửa yêu cầu này.');
        }

        $validated = $request->validate([
            'title' => 'required|max:200',
            'description' => 'required',
            'category_id' => 'required|exists:categories,id',
            'priority_id' => 'required|exists:priorities,id',
            'room_id' => 'nullable|exists:rooms,id',
        ], [
            'title.required' => 'Tiêu đề không được để trống.',
            'title.max' => 'Tiêu đề không được vượt quá 200 ký tự.',
            'description.required' => 'Mô tả chi tiết không được để trống.',
            'category_id.required' => 'Vui lòng chọn danh mục.',
            'category_id.exists' => 'Danh mục không hợp lệ.',
            'priority_id.required' => 'Vui lòng chọn độ ưu tiên.',
            'priority_id.exists' => 'Độ ưu tiên không hợp lệ.',
            'room_id.exists' => 'Vị trí đã chọn không hợp lệ.',
        ]);

        $ticket->update($validated);

        return redirect()->route('tickets.show', $ticket->id)->with('success', 'Cập nhật yêu cầu thành công!');
    }

    public function destroy(Ticket $ticket)
    {
        $user = Auth::user();
        // Chỉ Admin hoặc người tạo mới được quyền xóa ticket
        if ($user->role->name !== 'Admin' && $ticket->user_id !== $user->id) {
            return redirect()->route('tickets.index')->with('error', 'Bạn không có quyền xóa yêu cầu này.');
        }

        $ticket->delete();

        return redirect()->route('tickets.index')->with('success', 'Xóa yêu cầu thành công!');
    }
}
