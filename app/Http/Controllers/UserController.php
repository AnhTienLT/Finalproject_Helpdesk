<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['role', 'department'])->paginate(10);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        $departments = Department::all();
        return view('users.create', compact('roles', 'departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'role_id' => 'required|exists:roles,id',
            'department_id' => 'required|exists:departments,id',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        User::create($validated);

        return redirect()->route('users.index')->with('success', 'Thêm người dùng thành công!');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        $departments = Department::all();
        return view('users.edit', compact('user', 'roles', 'departments'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'role_id' => 'required|exists:roles,id',
            'department_id' => 'required|exists:departments,id',
        ]);

        // S7: Không cho tự đổi vai trò của chính mình
        if ($user->id === Auth::id() && (int) $validated['role_id'] !== (int) $user->role_id) {
            return back()->with('error', 'Bạn không thể tự thay đổi vai trò của chính mình.');
        }

        // S7: Không cho hạ cấp Admin cuối cùng
        $adminRoleId = Role::where('name', 'Admin')->value('id');
        if ($adminRoleId && (int) $user->role_id === (int) $adminRoleId
            && (int) $validated['role_id'] !== (int) $adminRoleId) {
            $adminCount = User::where('role_id', $adminRoleId)->count();
            if ($adminCount <= 1) {
                return back()->with('error', 'Không thể hạ cấp Admin duy nhất còn lại của hệ thống.');
            }
        }

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'Cập nhật người dùng thành công!');
    }

    public function destroy(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Bạn không thể tự xóa chính mình!');
        }

        // Chặn xoá Admin cuối cùng
        $adminRoleId = Role::where('name', 'Admin')->value('id');
        if ($adminRoleId && (int) $user->role_id === (int) $adminRoleId) {
            $adminCount = User::where('role_id', $adminRoleId)->count();
            if ($adminCount <= 1) {
                return back()->with('error', 'Không thể xoá Admin duy nhất còn lại của hệ thống.');
            }
        }

        // Chặn xoá nếu còn ràng buộc dữ liệu
        $blockers = [];
        if ($user->tickets()->exists())         $blockers[] = 'ticket đã tạo';
        if ($user->assignedTickets()->exists()) $blockers[] = 'ticket đang phụ trách';
        if ($user->maintenanceLogs()->exists()) $blockers[] = 'log bảo trì';
        if ($user->responses()->exists())       $blockers[] = 'phản hồi ticket';
        if (!empty($blockers)) {
            return back()->with('error', 'Không thể xoá vì người dùng còn: ' . implode(', ', $blockers) . '.');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'Xóa người dùng thành công!');
    }
}
