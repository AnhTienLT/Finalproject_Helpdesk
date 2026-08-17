<?php

namespace App\Http\Controllers;

use App\Models\Priority;
use Illuminate\Http\Request;

class PriorityController extends Controller
{
    public function index()
    {
        $priorities = Priority::orderBy('level', 'desc')->paginate(10);
        return view('priorities.index', compact('priorities'));
    }

    public function create()
    {
        return view('priorities.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:100|unique:priorities',
            'level' => 'required|integer',
            'color' => 'required|max:20',
        ]);

        Priority::create($validated);

        return redirect()->route('priorities.index')->with('success', 'Thêm độ ưu tiên thành công!');
    }

    public function edit(Priority $priority)
    {
        return view('priorities.edit', compact('priority'));
    }

    public function update(Request $request, Priority $priority)
    {
        $validated = $request->validate([
            'name' => 'required|max:100|unique:priorities,name,' . $priority->id,
            'level' => 'required|integer',
            'color' => 'required|max:20',
        ]);

        $priority->update($validated);

        return redirect()->route('priorities.index')->with('success', 'Cập nhật độ ưu tiên thành công!');
    }

    public function destroy(Priority $priority)
    {
        if ($priority->tickets()->count() > 0) {
            return back()->with('error', 'Không thể xóa độ ưu tiên đang có ticket!');
        }

        $priority->delete();
        return redirect()->route('priorities.index')->with('success', 'Xóa độ ưu tiên thành công!');
    }
}
