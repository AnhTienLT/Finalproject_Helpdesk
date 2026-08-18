@extends('layouts.app')

@section('title', 'Sửa tài sản #' . $asset->id)

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white shadow-sm rounded-lg border border-gray-200 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-bold text-gray-900">Chỉnh sửa tài sản: {{ $asset->name }}</h3>
        </div>

        <form action="{{ route('assets.update', $asset) }}" method="POST" class="p-8 space-y-6">
            @csrf
            @method('PUT')
            @include('assets._form')
            <div class="pt-4 flex items-center justify-end space-x-3 border-t border-gray-100">
                <a href="{{ route('assets.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">Hủy bỏ</a>
                <button type="submit" class="px-6 py-2 text-sm font-bold text-white bg-indigo-600 rounded-md shadow-sm hover:bg-indigo-700">Lưu thay đổi</button>
            </div>
        </form>
    </div>
</div>
@endsection
