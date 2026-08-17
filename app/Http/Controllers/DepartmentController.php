<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::paginate(10);
        return view('departments.index', compact('departments'));
    }

    public function create()
    {
        return view('departments.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:100',
            'description' => 'nullable|max:255',
        ]);

        Department::create($validated);

        return redirect()->route('departments.index')->with('success', 'Thêm phòng ban thành công!');
    }

    public function edit(Department $department)
    {
        return view('departments.edit', compact('department'));
    }

    public function update(Request $request, Department $department)
    {
        $validated = $request->validate([
            'name' => 'required|max:100',
            'description' => 'nullable|max:255',
        ]);

        $department->update($validated);

        return redirect()->route('departments.index')->with('success', 'Cập nhật phòng ban thành công!');
    }

    public function destroy(Department $department)
    {
        if ($department->users()->count() > 0) {
            return back()->with('error', 'Không thể xóa phòng ban đang có nhân viên!');
        }

        $department->delete();
        return redirect()->route('departments.index')->with('success', 'Xóa phòng ban thành công!');
    }
}
