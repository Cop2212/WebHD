@extends('layouts.user')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Đặt câu hỏi mới</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('questions.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Tiêu đề</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Nội dung câu hỏi</label>
                <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Đăng câu hỏi</button>
        </form>
    </div>
</div>
@endsection
