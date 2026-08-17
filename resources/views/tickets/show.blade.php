@extends('layouts.app')

@section('title', 'Chi tiết Ticket #' . $ticket->id)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    @php
        $statusBorderClasses = [
            'open' => 'border-blue-600',
            'in_progress' => 'border-amber-500',
            'resolved' => 'border-green-600',
            'closed' => 'border-gray-500',
        ];
        $statusBadgeClasses = [
            'open' => 'bg-blue-600 text-white',
            'in_progress' => 'bg-amber-500 text-white',
            'resolved' => 'bg-green-600 text-white',
            'closed' => 'bg-gray-500 text-white',
        ];
        $statusBadgeTexts = [
            'open' => 'Mở (Open)',
            'in_progress' => 'Đang xử lý (In Progress)',
            'resolved' => 'Đã giải quyết (Resolved)',
            'closed' => 'Đã đóng (Closed)',
        ];
    @endphp
    <div class="flex justify-between items-center bg-white p-6 rounded-lg shadow-md border-l-4 {{ $statusBorderClasses[$ticket->status] ?? 'border-gray-500' }}">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">{{ $ticket->title }}</h1>
            <div class="mt-2 flex items-center space-x-4 text-sm text-gray-600">
                <span>Mã yêu cầu: <strong>#{{ $ticket->id }}</strong></span>
                <span>•</span>
                <span>Ngày tạo: {{ $ticket->created_at->format('d/m/Y H:i') }}</span>
            </div>
        </div>
        <div class="text-right">
            <span class="px-4 py-2 rounded-full text-sm font-bold text-white shadow-sm" style="background-color: {{ $ticket->priority->color }}">
                {{ $ticket->priority->name }}
            </span>
            <div class="mt-2">
                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase {{ $statusBadgeClasses[$ticket->status] ?? 'bg-gray-500 text-white' }}">
                    {{ $statusBadgeTexts[$ticket->status] ?? ucfirst($ticket->status) }}
                </span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="md:col-span-2 space-y-6">
            <!-- Ticket Description -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-lg font-bold mb-4 border-b pb-2">Mô tả chi tiết</h2>
                <div class="text-gray-700 whitespace-pre-line text-sm leading-relaxed">
                    {{ $ticket->description }}
                </div>
            </div>

            <!-- Responses (Conversation) -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-lg font-bold mb-6 border-b pb-2">Thảo luận & Phản hồi</h2>

                <div class="space-y-6 mb-8">
                    @forelse($ticket->responses as $response)
                        <div class="flex space-x-4 {{ $response->user_id === Auth::id() ? 'justify-end' : '' }}">
                            @if($response->user_id !== Auth::id())
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center font-bold text-indigo-700">
                                        {{ substr($response->user->name, 0, 1) }}
                                    </div>
                                </div>
                            @endif
                            <div class="max-w-[80%] {{ $response->user_id === Auth::id() ? 'bg-indigo-50 border-indigo-200' : 'bg-gray-50 border-gray-200' }} border p-4 rounded-lg relative group">
                                <div class="flex justify-between items-center mb-1 space-x-4">
                                    <span class="font-bold text-sm text-gray-900">
                                        {{ $response->user->name }}
                                        <span class="text-xs font-normal text-gray-500">
                                            ({{ $response->user->role->name ?? 'User' }})
                                        </span>
                                    </span>
                                    <span class="text-xs text-gray-500">{{ $response->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="text-gray-700 text-sm leading-relaxed pr-6">
                                    {{ $response->message }}
                                </div>

                                {{-- Nút xóa phản hồi (chỉ người tạo hoặc Admin) --}}
                                @if (Auth::user()->role->name === 'Admin' || $response->user_id === Auth::id())
                                    <form action="{{ route('responses.destroy', $response->id) }}" method="POST" class="absolute bottom-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200" onsubmit="return confirm('Bạn có chắc chắn muốn xóa phản hồi này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-semibold">
                                            Xóa
                                        </button>
                                    </form>
                                @endif
                            </div>
                            @if($response->user_id === Auth::id())
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 rounded-full bg-indigo-600 flex items-center justify-center font-bold text-white">
                                        {{ substr($response->user->name, 0, 1) }}
                                    </div>
                                </div>
                            @endif
                        </div>
                    @empty
                        <p class="text-center text-gray-500 text-sm py-4 italic">Chưa có phản hồi nào.</p>
                    @endforelse
                </div>

                <!-- Response Form -->
                <form action="{{ route('responses.store', $ticket->id) }}" method="POST" class="mt-6 border-t pt-6">
                    @csrf
                    <div class="mb-4">
                        <textarea name="message" rows="3" class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none text-sm" placeholder="Nhập phản hồi của bạn tại đây..." required></textarea>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg transition text-sm">
                            Gửi phản hồi
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="space-y-6">
            <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                <h2 class="text-lg font-bold mb-4 border-b pb-2">Thông tin liên quan</h2>
                <div class="space-y-4 text-sm">
                    <div>
                        <p class="text-gray-500">Người yêu cầu</p>
                        <p class="font-bold text-gray-800">{{ $ticket->user->name }}</p>
                        <p class="text-xs text-gray-400">{{ $ticket->user->department->name ?? 'Không rõ phòng' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Danh mục</p>
                        <p class="font-semibold text-gray-800">{{ $ticket->category->name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Phòng / Vị trí</p>
                        <p class="font-semibold text-gray-800">{{ $ticket->room ? $ticket->room->name : 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Người phụ trách xử lý</p>
                        <p class="font-bold text-indigo-600 text-sm">
                            {{ $ticket->assignedTo ? $ticket->assignedTo->name : 'Đang chờ phân công...' }}
                        </p>
                    </div>

                    <!-- Quản lý & Phân công dành cho Admin / Technician -->
                    @if (Auth::user()->role->name === 'Admin' || Auth::user()->role->name === 'Technician')
                        <div class="mt-6 border-t border-gray-200 pt-4">
                            <h3 class="text-sm font-bold text-gray-900 mb-3">Phân công & Trạng thái</h3>
                            <form action="{{ route('tickets.update', $ticket->id) }}" method="POST" class="space-y-4">
                                @csrf
                                @method('PUT')
                                
                                <div>
                                    <label for="status" class="block text-xs font-semibold text-gray-500 uppercase">Trạng thái</label>
                                    <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-xs">
                                        <option value="open" {{ $ticket->status === 'open' ? 'selected' : '' }}>Mở (Open)</option>
                                        <option value="in_progress" {{ $ticket->status === 'in_progress' ? 'selected' : '' }}>Đang xử lý (In Progress)</option>
                                        <option value="resolved" {{ $ticket->status === 'resolved' ? 'selected' : '' }}>Đã giải quyết (Resolved)</option>
                                        <option value="closed" {{ $ticket->status === 'closed' ? 'selected' : '' }}>Đã đóng (Closed)</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="assigned_to" class="block text-xs font-semibold text-gray-500 uppercase">Người xử lý (KTV)</label>
                                    <select name="assigned_to" id="assigned_to" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-xs">
                                        <option value="">-- Chưa phân công --</option>
                                        @foreach ($technicians as $tech)
                                            <option value="{{ $tech->id }}" {{ $ticket->assigned_to == $tech->id ? 'selected' : '' }}>
                                                {{ $tech->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <button type="submit" class="w-full inline-flex justify-center items-center py-2 px-3 border border-transparent rounded-md shadow-sm text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none transition">
                                    Cập nhật cấu hình
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>

            <div class="bg-indigo-50 p-4 rounded-lg border border-indigo-100 text-xs text-indigo-800 leading-relaxed">
                <p><strong>Ghi chú:</strong> Kỹ thuật viên phụ trách có nhiệm vụ cập nhật trạng thái yêu cầu sau khi xử lý sự cố hoàn tất.</p>
            </div>
        </div>
    </div>

    <div class="flex justify-center pb-10">
        <a href="{{ route('tickets.index') }}" class="text-gray-500 hover:text-gray-800 flex items-center text-sm font-medium">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Quay lại danh sách yêu cầu
        </a>
    </div>
</div>
@endsection
