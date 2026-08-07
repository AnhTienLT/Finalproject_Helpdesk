@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Danh sách Phòng</h2>
    <a href="{{ route('rooms.create') }}" class="btn btn-primary">+ Thêm phòng</a>
</div>

<table class="table table-bordered table-hover">
    <thead class="table-light">
        <tr>
            <th>#</th>
            <th>Tên phòng</th>
            <th>Vị trí</th>
            <th>Mô tả</th>
            <th>Tài sản</th>
            <th>Ticket</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($rooms as $room)
        <tr>
            <td>{{ $room->id }}</td>
            <td><a href="{{ route('rooms.show', $room) }}">{{ $room->name }}</a></td>
            <td>{{ $room->location }}</td>
            <td>{{ $room->description ?? '—' }}</td>
            <td><span class="badge bg-info">{{ $room->assets_count }}</span></td>
            <td><span class="badge bg-warning text-dark">{{ $room->tickets_count }}</span></td>
            <td>
                <a href="{{ route('rooms.edit', $room) }}" class="btn btn-sm btn-outline-primary">Sửa</a>
                <form action="{{ route('rooms.destroy', $room) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Bạn có chắc muốn xóa phòng này?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger">Xóa</button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="7" class="text-center">Chưa có phòng nào.</td></tr>
        @endforelse
    </tbody>
</table>

{{ $rooms->links() }}
@endsection
