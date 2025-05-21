@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <h1 class="mb-4">Trang quản trị</h1>

    <!-- Hiển thị thông báo nếu có -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
    <div class="col-md-4">
        <div class="card border-primary mb-3">
            <div class="card-body text-center">
                <h5 class="card-title">Quản lý Câu hỏi</h5>
                <a href="{{ route('admin.questions') }}" class="btn btn-primary">Xem tất cả</a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-success mb-3">
            <div class="card-body text-center">
                <h5 class="card-title">Quản lý Thẻ</h5>
                <a href="{{ route('admin.tags') }}" class="btn btn-success">Xem tất cả</a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-info mb-3">
            <div class="card-body text-center">
                <h5 class="card-title">Quản lý Người dùng</h5>
                <a href="{{ route('admin.users') }}" class="btn btn-info">Xem tất cả</a>
            </div>
        </div>
    </div>
</div>

@endsection
