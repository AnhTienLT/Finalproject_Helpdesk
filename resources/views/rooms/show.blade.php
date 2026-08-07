@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>{{ $room->name }}</h2>
    <a href="{{ route('rooms.index') }}" class="btn btn-secondary">Quay lại</a>
</div>

<div class="card mb-4">
    <div class="card-body">
        <p><strong>Vị trí:</strong> {{ $room->location }}</p>
        <p><strong>Mô tả:</strong> {{ $room->description ?? '—' }}</p>
    </div>
</div>

<h4>Tài sản trong phòng ({{ $room->assets->count() }})</h4>
@if ($room->assets->count())
<table class="table table-bordered table-sm">
    <thead class="table-light">
        <tr>
            <th>Mã</th>
            <th>Tên tài sản</th>
            <th>Danh mục</th>
            <th>Trạng thái</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($room->assets as $asset)
        <tr>
            <td>{{ $asset->asset_code }}</td>
            <td>{{ $asset->name }}</td>
            <td>{{ $asset->assetCategory->name ?? '—' }}</td>
            <td>
                @php
                    $colors = ['active' => 'success', 'broken' => 'danger', 'maintenance' => 'warning', 'disposed' => 'secondary'];
                @endphp
                <span class="badge bg-{{ $colors[$asset->status] ?? 'secondary' }}">{{ $asset->status }}</span>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<p class="text-muted">Chưa có tài sản nào trong phòng này.</p>
@endif
@endsection
