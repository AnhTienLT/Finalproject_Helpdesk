@extends('layouts.app')

@section('title', 'Báo cáo tài sản theo phòng')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl">Báo cáo tài sản theo phòng</h2>
    <p class="mt-1 text-sm text-gray-500">Số lượng và tình trạng tài sản của từng phòng / vị trí.</p>
</div>

<div class="space-y-6">
    @forelse($rooms as $room)
        <div class="bg-white shadow-sm border border-gray-200 rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">{{ $room->name }}</h3>
                    <p class="text-xs text-gray-500">{{ $room->location }}</p>
                </div>
                <div class="flex space-x-2 text-xs">
                    <span class="px-2.5 py-0.5 rounded-full bg-gray-100 text-gray-700">Tổng: {{ $room->total_assets }}</span>
                    <span class="px-2.5 py-0.5 rounded-full bg-green-100 text-green-800">Active: {{ $room->active_assets }}</span>
                    <span class="px-2.5 py-0.5 rounded-full bg-red-100 text-red-800">Hỏng: {{ $room->broken_assets }}</span>
                    <span class="px-2.5 py-0.5 rounded-full bg-amber-100 text-amber-800">Bảo trì: {{ $room->maintenance_assets }}</span>
                </div>
            </div>
            <div class="p-4">
                @if($room->assets->isEmpty())
                    <p class="text-sm text-gray-500 italic">Chưa có tài sản.</p>
                @else
                <table class="min-w-full text-sm">
                    <thead class="text-xs text-gray-500 uppercase">
                        <tr><th class="text-left pb-2">Mã</th><th class="text-left pb-2">Tên</th><th class="text-left pb-2">Loại</th><th class="text-left pb-2">Trạng thái</th></tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($room->assets as $asset)
                            <tr>
                                <td class="py-2 pr-4 text-gray-700 font-mono text-xs">{{ $asset->asset_code }}</td>
                                <td class="py-2 pr-4 text-gray-900">{{ $asset->name }}</td>
                                <td class="py-2 pr-4 text-gray-600">{{ $asset->category?->name }}</td>
                                <td class="py-2 pr-4">
                                    @php $colors = ['active'=>'green','broken'=>'red','maintenance'=>'amber','disposed'=>'gray']; $c = $colors[$asset->status] ?? 'gray'; @endphp
                                    <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-{{ $c }}-100 text-{{ $c }}-800">{{ $asset->status }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    @empty
        <p class="text-sm text-gray-500 italic">Chưa có phòng nào.</p>
    @endforelse
</div>
@endsection
