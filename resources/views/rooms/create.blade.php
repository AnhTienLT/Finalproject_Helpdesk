@extends('layouts.app')

@section('content')
<h2 class="mb-3">Thêm phòng mới</h2>

<form action="{{ route('rooms.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label for="name" class="form-label">Tên phòng <span class="text-danger">*</span></label>
        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
               value="{{ old('name') }}" required maxlength="100">
        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
        <label for="location" class="form-label">Vị trí <span class="text-danger">*</span></label>
        <input type="text" name="location" id="location" class="form-control @error('location') is-invalid @enderror"
               value="{{ old('location') }}" required maxlength="200">
        @error('location') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Mô tả</label>
        <textarea name="description" id="description" rows="3"
                  class="form-control @error('description') is-invalid @enderror"
                  maxlength="255">{{ old('description') }}</textarea>
        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <button type="submit" class="btn btn-primary">Lưu</button>
    <a href="{{ route('rooms.index') }}" class="btn btn-secondary">Hủy</a>
</form>
@endsection
