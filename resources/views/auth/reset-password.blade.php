@extends('layouts.auth')

@section('title', 'Đặt lại mật khẩu')

@section('content')
<div class="auth-container">
    <div class="card auth-card">
        <div class="card-body p-4">
            <div class="text-center mb-4">
                <i class="fas fa-key fa-3x text-danger mb-3"></i>
                <h4>Đặt lại mật khẩu</h4>
                <p class="text-muted">Nhập mật khẩu mới cho tài khoản của bạn.</p>
            </div>

            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <!-- Token ẩn -->
                <input type="hidden" name="token" value="{{ $token }}">

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" type="email"
       class="form-control @error('email') is-invalid @enderror"
       name="email" value="{{ old('email', $email) }}" required autofocus>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Mật khẩu mới -->
                <div class="mb-3">
                    <label for="password" class="form-label">Mật khẩu mới</label>
                    <input id="password" type="password"
                           class="form-control @error('password') is-invalid @enderror"
                           name="password" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Nhập lại mật khẩu -->
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Xác nhận mật khẩu</label>
                    <input id="password_confirmation" type="password"
                           class="form-control" name="password_confirmation" required>
                </div>

                <button type="submit" class="btn btn-danger w-100">
                    <i class="fas fa-check me-2"></i> Cập nhật mật khẩu
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
