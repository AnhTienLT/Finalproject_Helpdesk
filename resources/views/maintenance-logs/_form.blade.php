@php $l = $log ?? null; $preselect = $l?->asset_id ?? ($selectedAssetId ?? null); @endphp
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Tài sản <span class="text-red-500">*</span></label>
        <select name="asset_id" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border p-2.5" required>
            <option value="">— chọn tài sản —</option>
            @foreach($assets as $a)
                <option value="{{ $a->id }}" @selected(old('asset_id', $preselect) == $a->id)>{{ $a->name }} ({{ $a->asset_code }})</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Ngày bảo trì <span class="text-red-500">*</span></label>
        <input type="date" name="maintenance_date" value="{{ old('maintenance_date', $l?->maintenance_date) }}" required max="{{ now()->toDateString() }}"
            class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border p-2.5">
    </div>
    <div class="md:col-span-2">
        <label class="block text-sm font-semibold text-gray-700 mb-1">Nội dung bảo trì / sửa chữa <span class="text-red-500">*</span></label>
        <textarea name="description" rows="4" required class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border p-2.5">{{ old('description', $l->description ?? '') }}</textarea>
    </div>
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Chi phí (VNĐ)</label>
        <input type="number" name="cost" min="0" step="1000" value="{{ old('cost', $l->cost ?? '') }}"
            class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border p-2.5">
    </div>
</div>
