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

    @include('admin.manager.question')
    @include('admin.manager.tags')
    @include('admin.manager.user')
@endsection
