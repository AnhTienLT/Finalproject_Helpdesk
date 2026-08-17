<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::paginate(10);
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        return view('roles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:100|unique:roles',
            'description' => 'nullable|max:255',
        ]);

        Role::create($validated);

        return redirect()->route('roles.index')->with('success', 'Thêm vai trò thành công!');
    }

    public function edit(Role $role)
    {
        return view('roles.edit', compact('role'));
    }

    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => 'required|max:100|unique:roles,name,' . $role->id,
            'description' => 'nullable|max:255',
        ]);

        $role->update($validated);

        return redirect()->route('roles.index')->with('success', 'Cập nhật vai trò thành công!');
    }

    public function destroy(Role $role)
    {
        if ($role->users()->count() > 0) {
            return back()->with('error', 'Không thể xóa vai trò đang được gán cho người dùng!');
        }

        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Xóa vai trò thành công!');
    }
}
