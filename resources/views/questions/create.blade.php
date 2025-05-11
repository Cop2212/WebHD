@extends('layouts.app')

@section('title', 'Đặt câu hỏi mới')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="mb-4">Đặt câu hỏi mới</h2>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('questions.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="title" class="form-label">Tiêu đề câu hỏi</label>
                    <input type="text" class="form-control" name="title" id="title"
                           value="{{ old('title') }}" required>
                </div>

                <div class="mb-3">
                    <label for="body" class="form-label">Nội dung chi tiết</label>
                    <textarea name="body" id="body" rows="6" class="form-control" required>{{ old('body') }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="tags" class="form-label">Chọn tags liên quan</label>
                    <select name="tags[]" id="tags" class="form-select" multiple required>
                        @foreach($allTags as $tag)
                            <option value="{{ $tag->id }}"
                                {{ collect(old('tags'))->contains($tag->id) ? 'selected' : '' }}>
                                {{ $tag->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('home') }}" class="btn btn-secondary">Hủy</a>
                    <button type="submit" class="btn btn-primary">Đăng câu hỏi</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function () {
        $('#tags').select2({
            placeholder: "Chọn tags liên quan...",
            width: '100%'
        });
    });
</script>
@endpush
