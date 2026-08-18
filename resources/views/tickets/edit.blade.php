@extends('layouts.app')

@section('title', 'Sửa yêu cầu #' . $ticket->id)

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white shadow-sm rounded-lg border border-gray-200 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-bold text-gray-900">Chỉnh sửa yêu cầu</h3>
            <p class="mt-1 text-sm text-gray-500">Bạn chỉ có thể sửa khi yêu cầu còn ở trạng thái "Mới".</p>
        </div>

        <form action="{{ route('tickets.update', $ticket) }}" method="POST" class="p-8 space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="title" class="block text-sm font-semibold text-gray-700 mb-1">Tiêu đề <span class="text-red-500">*</span></label>
                <input type="text" name="title" id="title" value="{{ old('title', $ticket->title) }}"
                    class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border p-2.5 @error('title') border-red-500 @enderror" required>
                @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-semibold text-gray-700 mb-1">Mô tả chi tiết <span class="text-red-500">*</span></label>
                <textarea name="description" id="description" rows="5"
                    class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border p-2.5 @error('description') border-red-500 @enderror" required>{{ old('description', $ticket->description) }}</textarea>
                @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="category_id" class="block text-sm font-semibold text-gray-700 mb-1">Danh mục <span class="text-red-500">*</span></label>
                    <select name="category_id" id="category_id" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border p-2.5" required>
                        @foreach($categories as $c)
                            <option value="{{ $c->id }}" @selected(old('category_id', $ticket->category_id) == $c->id)>{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="priority_id" class="block text-sm font-semibold text-gray-700 mb-1">Độ ưu tiên <span class="text-red-500">*</span></label>
                    <select name="priority_id" id="priority_id" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border p-2.5" required>
                        @foreach($priorities as $p)
                            <option value="{{ $p->id }}" @selected(old('priority_id', $ticket->priority_id) == $p->id)>{{ $p->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="room_id" class="block text-sm font-semibold text-gray-700 mb-1">Vị trí</label>
                    <select name="room_id" id="room_id" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border p-2.5">
                        <option value="">— không chọn —</option>
                        @foreach($rooms as $r)
                            <option value="{{ $r->id }}" @selected(old('room_id', $ticket->room_id) == $r->id)>{{ $r->name }} ({{ $r->location }})</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="pt-4 flex items-center justify-between border-t border-gray-100">
                <form action="{{ route('tickets.destroy', $ticket) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn huỷ yêu cầu này?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-red-700 bg-white border border-red-300 rounded-md shadow-sm hover:bg-red-50">Huỷ yêu cầu</button>
                </form>
                <div class="space-x-3">
                    <a href="{{ route('tickets.show', $ticket) }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">Quay lại</a>
                    <button type="submit" class="px-6 py-2 text-sm font-bold text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700">Lưu thay đổi</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
