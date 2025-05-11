<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Models\User; // Giả sử bạn dùng model User

class UserController extends Controller
{
    public function sendEmailVerification(Request $request)
    {
        $user = auth()->user();

        try {
            // Gửi thông báo xác minh email
            $user->sendEmailVerificationNotification();

            // Thông báo gửi thành công
            return response()->json([
                'message' => 'Vui lòng kiểm tra email của bạn để xác minh tài khoản.',
            ]);
        } catch (\Exception $e) {
            // Nếu có lỗi xảy ra trong quá trình gửi email, ghi log lỗi
            Log::error('Email verification failed for user ID ' . $user->id . ': ' . $e->getMessage());

            // Thông báo lỗi
            return response()->json([
                'error' => 'Không thể gửi email xác minh, vui lòng thử lại sau.',
            ], 500);
        }
    }
}
