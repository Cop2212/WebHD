<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class PasswordResetController extends Controller
{
    /**
     * Hiển thị form yêu cầu reset mật khẩu
     */
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Xử lý gửi email reset mật khẩu
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    /**
     * Hiển thị form reset mật khẩu
     */
    public function showResetForm(Request $request, $token = null)
{
    return view('auth.reset-password', [
        'token' => $token,
        'email' => $request->email, // truyền email từ URL query string
    ]);
}

    /**
     * Xử lý reset mật khẩu
     */
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
    $request->only('email', 'password', 'password_confirmation', 'token'),
    function ($user, $password) {
        $user->forceFill([
            'password' => Hash::make($password),
            'remember_token' => Str::random(60),
        ])->save();

        event(new PasswordReset($user));

        // Đăng nhập user để có thể gọi logoutOtherDevices
        Auth::login($user);

        // Đăng xuất mọi phiên đăng nhập khác
        Auth::logoutOtherDevices($password);
    }
);

        return $status == Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
                    : back()->withInput($request->only('email'))
                        ->withErrors(['email' => __($status)]);
    }
}
