<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::withCount(['assets', 'tickets'])->latest()->paginate(10);
        return view('rooms.index', compact('rooms'));
    }

    public function create()
    {
        return view('rooms.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:100',
            'location'    => 'required|string|max:200',
            'description' => 'nullable|string|max:255',
        ]);

        Room::create($validated);

        return redirect()->route('rooms.index')
            ->with('success', 'Phòng đã được tạo thành công.');
    }

    public function show(Room $room)
    {
        $room->load(['assets.assetCategory', 'tickets']);
        return view('rooms.show', compact('room'));
    }

    public function edit(Room $room)
    {
        return view('rooms.edit', compact('room'));
    }

    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:100',
            'location'    => 'required|string|max:200',
            'description' => 'nullable|string|max:255',
        ]);

        $room->update($validated);

        return redirect()->route('rooms.index')
            ->with('success', 'Phòng đã được cập nhật thành công.');
    }

    public function destroy(Room $room)
    {
        if ($room->assets()->count() > 0 || $room->tickets()->count() > 0) {
            return redirect()->route('rooms.index')
                ->with('error', 'Không thể xóa phòng đang có tài sản hoặc ticket liên quan.');
        }

        $room->delete();

        return redirect()->route('rooms.index')
            ->with('success', 'Phòng đã được xóa thành công.');
    }
}
