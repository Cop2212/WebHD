<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    // Hiển thị trang profile
    public function show()
    {
        return view('profile.profile');
    }

    // Hiển thị form chỉnh sửa
    public function edit()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để tiếp tục.');
        }

        return view('profile.edit', [
            'user' => $user
        ]);
    }

    // Xử lý cập nhật profile
    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,'.$user->id,
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->save();

        return redirect()->route('profile.show')
            ->with('success', 'Cập nhật thông tin thành công!');
    }

    public function updatePassword(Request $request)
{
    /** @var \App\Models\User $user */
    $user = Auth::user();

    // Validate dữ liệu
    $validator = Validator::make($request->all(), [
        'current_password' => [
            'required',
            function ($attribute, $value, $fail) use ($user) {
                if (!Hash::check($value, $user->password)) {
                    $fail('Mật khẩu hiện tại không đúng');
                }
            }
        ],
        'new_password' => 'required|min:8|different:current_password',
        'new_password_confirmation' => 'required|same:new_password',
    ], [
        'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại',
        'new_password.required' => 'Vui lòng nhập mật khẩu mới',
        'new_password.min' => 'Mật khẩu mới phải có ít nhất 8 ký tự',
        'new_password.different' => 'Mật khẩu mới phải khác mật khẩu hiện tại',
        'new_password_confirmation.required' => 'Vui lòng xác nhận mật khẩu mới',
        'new_password_confirmation.same' => 'Xác nhận mật khẩu không khớp',
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    // Cập nhật mật khẩu mới
    $user->password = Hash::make($request->new_password);
    $user->save();

    // Đăng xuất sau khi đổi mật khẩu
    Auth::logout();

    return redirect()->route('login')
        ->with('success', 'Đổi mật khẩu thành công. Vui lòng đăng nhập lại.');
}
}
