@extends('layouts.app')

@section('title', 'Chỉnh sửa câu hỏi')

@section('content')
<div class="container py-4">
    <h3 class="mb-4"><i class="fas fa-edit me-2"></i>Chỉnh sửa câu hỏi</h3>

    <form action="{{ route('questions.update', $question->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Tiêu đề</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror"
                   name="title" id="title" value="{{ old('title', $question->title) }}">
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="body" class="form-label">Nội dung</label>
            <textarea class="form-control @error('body') is-invalid @enderror"
                      name="body" id="body" rows="6">{{ old('body', $question->body) }}</textarea>
            @error('body')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('questions.mine') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Quay lại
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-1"></i> Cập nhật
            </button>
        </div>
    </form>
</div>
@endsection
