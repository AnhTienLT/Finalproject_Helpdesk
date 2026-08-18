@php $a = $asset ?? null; @endphp
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Tên tài sản <span class="text-red-500">*</span></label>
        <input type="text" name="name" value="{{ old('name', $a->name ?? '') }}"
            class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border p-2.5 @error('name') border-red-500 @enderror" required>
        @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Mã tài sản <span class="text-red-500">*</span></label>
        <input type="text" name="asset_code" value="{{ old('asset_code', $a->asset_code ?? '') }}"
            class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border p-2.5 @error('asset_code') border-red-500 @enderror" required>
        @error('asset_code')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Loại tài sản <span class="text-red-500">*</span></label>
        <select name="asset_category_id" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border p-2.5" required>
            @foreach($categories as $c)
                <option value="{{ $c->id }}" @selected(old('asset_category_id', $a->asset_category_id ?? '') == $c->id)>{{ $c->name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Phòng / Vị trí <span class="text-red-500">*</span></label>
        <select name="room_id" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border p-2.5" required>
            @foreach($rooms as $r)
                <option value="{{ $r->id }}" @selected(old('room_id', $a->room_id ?? '') == $r->id)>{{ $r->name }} ({{ $r->location }})</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Trạng thái <span class="text-red-500">*</span></label>
        <select name="status" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border p-2.5" required>
            @foreach(['active'=>'Hoạt động','broken'=>'Hỏng','maintenance'=>'Đang bảo trì','disposed'=>'Thanh lý'] as $k=>$v)
                <option value="{{ $k }}" @selected(old('status', $a->status ?? 'active') === $k)>{{ $v }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Ngày mua</label>
        <input type="date" name="purchase_date" value="{{ old('purchase_date', $a?->purchase_date) }}"
            class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border p-2.5">
    </div>
    <div class="md:col-span-2">
        <label class="block text-sm font-semibold text-gray-700 mb-1">Mô tả</label>
        <textarea name="description" rows="3" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border p-2.5">{{ old('description', $a->description ?? '') }}</textarea>
    </div>
</div>
