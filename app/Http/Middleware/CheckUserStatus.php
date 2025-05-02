<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckUserStatus
{
    public function handle($request, Closure $next)
    {
        // Nếu user đã đăng nhập
        if (Auth::check()) {
            // Kiểm tra user còn tồn tại trong database không
            if (!Auth::user()->exists) {
                Auth::logout();
                return redirect()->route('login')->with('error', 'Tài khoản của bạn đã bị xóa hoặc không tồn tại.');
            }
        }

        return $next($request);
    }
}
