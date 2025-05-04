@extends('layouts.auth')

@section('title', 'Đăng nhập')

@section('content')
<div class="auth-container @auth with-sidebar @endauth">
    <div class="card auth-card">
        <div class="card-body p-5">
            <div class="text-center mb-4">
                <i class="fas fa-sign-in-alt fa-3x text-primary mb-3"></i>
                <h2>Đăng nhập</h2>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
               value="{{ old('email') }}" required autofocus>
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

                <!-- Remember Me -->
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" name="remember">
                    <label class="form-check-label">Ghi nhớ đăng nhập</label>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2 mb-3">
                    <i class="fas fa-sign-in-alt me-2"></i> Đăng nhập
                </button>

                <div class="text-center">
                    <a href="{{ route('password.request') }}">Quên mật khẩu?</a>
                    <span class="mx-2">|</span>
                    <a href="{{ route('register') }}">Đăng ký tài khoản</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
