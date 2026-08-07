@extends('layouts.app')

@section('title', 'Danh sách Ticket')

@section('content')
<div class="bg-white p-8 rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Danh sách yêu cầu hỗ trợ</h1>
        <a href="{{ route('tickets.create') }}" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded">
            + Gửi yêu cầu mới
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">ID</th>
                    <th class="py-3 px-6 text-left">Tiêu đề</th>
                    <th class="py-3 px-6 text-left">Danh mục</th>
                    <th class="py-3 px-6 text-center">Ưu tiên</th>
                    <th class="py-3 px-6 text-center">Trạng thái</th>
                    <th class="py-3 px-6 text-center">Ngày tạo</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @forelse($tickets as $ticket)
                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                        <td class="py-3 px-6 text-left whitespace-nowrap">#{{ $ticket->id }}</td>
                        <td class="py-3 px-6 text-left font-medium">{{ $ticket->title }}</td>
                        <td class="py-3 px-6 text-left">{{ $ticket->category->name }}</td>
                        <td class="py-3 px-6 text-center">
                            <span class="px-3 py-1 rounded-full text-xs text-white" style="background-color: {{ $ticket->priority->color }}">
                                {{ $ticket->priority->name }}
                            </span>
                        </td>
                        <td class="py-3 px-6 text-center">
                            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs">
                                {{ ucfirst($ticket->status) }}
                            </span>
                        </td>
                        <td class="py-3 px-6 text-center">{{ $ticket->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-6 text-center text-gray-500">Chưa có yêu cầu nào được gửi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
