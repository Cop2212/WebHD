@extends('layouts.auth')

@section('title', 'Quên mật khẩu')

@section('content')
<div class="auth-container">
    <div class="card auth-card">
        <div class="card-body p-4">
            <div class="text-center mb-4">
                <i class="fas fa-unlock-alt fa-3x text-warning mb-3"></i>
                <h4>Khôi phục mật khẩu</h4>
                <p class="text-muted">Nhập email của bạn để nhận liên kết đặt lại mật khẩu.</p>
            </div>

            @if (session('status'))
                <div class="alert alert-success text-center">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">Địa chỉ email</label>
                    <input id="email" type="email"
                           class="form-control @error('email') is-invalid @enderror"
                           name="email" value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-warning w-100">
                    <i class="fas fa-paper-plane me-2"></i> Gửi liên kết khôi phục
                </button>

                <div class="text-center mt-3">
                    <a href="{{ route('login') }}" class="text-muted">
                        <i class="fas fa-arrow-left me-1"></i> Quay lại đăng nhập
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
