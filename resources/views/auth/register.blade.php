@extends('layouts.auth')

@section('title', 'Đăng ký')

@section('content')
<div class="auth-container @auth with-sidebar @endauth">
    <div class="card auth-card">
        <div class="card-body p-5">
            <div class="text-center mb-4">
                <i class="fas fa-user-plus fa-3x text-primary mb-3"></i>
                <h2>Đăng ký tài khoản</h2>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="mb-3">
                    <label class="form-label">Họ và tên</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name') }}" required autofocus>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Username -->
                <div class="mb-3">
                    <label for="username" class="form-label">Tên đăng nhập</label>
                    <input id="username" type="text"
                           class="form-control @error('username') is-invalid @enderror"
                           name="username" value="{{ old('username') }}" required>
                    @error('username')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Chỉ chứa chữ cái, số và dấu gạch dưới</small>
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email') }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label class="form-label">Mật khẩu</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="mb-3">
                    <label class="form-label">Xác nhận mật khẩu</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>

                <!-- Terms Checkbox -->
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input @error('terms') is-invalid @enderror" name="terms" id="terms">
                    <label class="form-check-label" for="terms">
                        Tôi đồng ý với <a href="#">điều khoản sử dụng</a>
                    </label>
                    @error('terms')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2 mb-3">
                    <i class="fas fa-user-plus me-2"></i> Đăng ký
                </button>

                <div class="text-center">
                    Đã có tài khoản? <a href="{{ route('login') }}">Đăng nhập ngay</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
