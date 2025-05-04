<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create()
{
    return view('auth.login');
}

public function store(LoginRequest $request)
{
    $request->authenticate();

    // Xác định trạng thái remember từ checkbox
    $remember = $request->boolean('remember'); // Sử dụng boolean() để chuẩn hóa giá trị

    // Thiết lập đăng nhập với remember token nếu được chọn
    Auth::login(Auth::user(), $remember);

    $request->session()->regenerate();

    return redirect()->intended(route('home'));
}

public function destroy(Request $request)
{
    Auth::logout();

    // Xóa remember token
    if ($request->user()) {
        $request->user()->update(['remember_token' => null]);
    }

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/');
}
}
