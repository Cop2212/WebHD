@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <h1 class="mb-4">Trang quản trị</h1>

    @include('admin.manager.question')
    @include('admin.manager.tags')
    @include('admin.manager.user')
@endsection
