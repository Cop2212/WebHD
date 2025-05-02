@extends('layouts.guest')

@section('title', 'Đăng nhập')

@section('content')
<div class="max-w-md mx-auto bg-white rounded-lg shadow-md overflow-hidden md:max-w-2xl mt-10">
    <div class="p-8">
        <div class="flex justify-center mb-6">
            <i class="fas fa-user-circle text-5xl text-blue-500"></i>
        </div>

        <h2 class="text-center text-2xl font-bold text-gray-800 mb-6">Đăng nhập hệ thống</h2>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">
                    <i class="fas fa-envelope mr-2"></i>Email
                </label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Nhập email của bạn">
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-6">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">
                    <i class="fas fa-lock mr-2"></i>Mật khẩu
                </label>
                <input id="password" type="password" name="password" required
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Nhập mật khẩu">
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me -->
<div class="mb-6">
    <label class="inline-flex items-center">
        <input type="checkbox" name="remember"
               value="1"
               class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
               {{ old('remember') ? 'checked' : '' }}
        >
        <span class="ml-2 text-sm text-gray-600">Ghi nhớ đăng nhập</span>
    </label>
</div>

            <!-- Submit Button -->
            <div class="flex items-center justify-between">
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline">
                    <i class="fas fa-sign-in-alt mr-2"></i> Đăng nhập
                </button>
            </div>

            <!-- Forgot Password -->
            <div class="text-center mt-4">
                @if (Route::has('password.request'))
                    <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="{{ route('password.request') }}">
                        Quên mật khẩu?
                    </a>
                @endif
            </div>
        </form>
    </div>
</div>
@endsection
