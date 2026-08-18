@extends('layouts.app')

@section('title', 'Sửa log bảo trì')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow-sm rounded-lg border border-gray-200 overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-200 bg-gray-50">
        <h3 class="text-lg font-bold text-gray-900">Sửa log bảo trì</h3>
    </div>
    <form action="{{ route('maintenance-logs.update', $log) }}" method="POST" class="p-8 space-y-6">
        @csrf @method('PUT')
        @include('maintenance-logs._form')
        <div class="pt-4 flex justify-end space-x-3 border-t border-gray-100">
            <a href="{{ route('maintenance-logs.index') }}" class="px-4 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">Hủy</a>
            <button class="px-6 py-2 text-sm font-bold text-white bg-indigo-600 rounded-md hover:bg-indigo-700">Lưu</button>
        </div>
    </form>
</div>
@endsection
