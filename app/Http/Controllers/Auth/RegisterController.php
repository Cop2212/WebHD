<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected function registered(Request $request, $user)
{
    // Đăng xuất user ngay sau khi đăng ký
    Auth::logout();

    // Chuyển hướng đến trang login với thông báo
    return redirect('/login')->with('success', 'Đăng ký thành công! Vui lòng đăng nhập.');
}

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        Log::debug('Dữ liệu validator nhận được:', $data);

        $validator = Validator::make($data, [
            'username' => ['required', 'string', 'max:50', 'unique:users'],
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'terms' => ['accepted'],
        ]);

        if ($validator->fails()) {
            Log::error('Lỗi validation:', $validator->errors()->toArray());
        }

        return $validator;
    }

    protected function create(array $data)
    {
        Log::debug('Dữ liệu trước khi tạo user:', $data);

        try {
            $user = User::create([
                'username' => $data['username'],
                'email' => $data['email'],
                'display_name' => $data['name'],
                'password' => Hash::make($data['password']),
                'is_active' => true,
            ]);

            Log::debug('User đã được tạo:', $user->toArray());
            return $user;

        } catch (\Exception $e) {
            Log::error('Lỗi khi tạo user: ' . $e->getMessage());
            Log::error('Trace: ' . $e->getTraceAsString());
            throw $e;
        }
    }

    public function register(Request $request)
    {
        Log::info('Bắt đầu quá trình đăng ký');
        Log::debug('Dữ liệu request:', $request->all());

        try {
            // Validate
            $validator = $this->validator($request->all());
            if ($validator->fails()) {
                Log::error('Validation failed', $validator->errors()->toArray());
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            // Create user
            Log::info('Tạo user mới');
            $user = $this->create($request->all());

            // Fire event
            event(new Registered($user));
            Log::info('Event Registered đã được kích hoạt');

            // Login
            Auth::login($user);
            Log::info('User đã được login', ['user_id' => $user->id]);

            return $this->registered($request, $user)
                ?: redirect($this->redirectPath());

        } catch (\Exception $e) {
            Log::error('Lỗi trong quá trình đăng ký: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return back()->with('error', 'Đã xảy ra lỗi trong quá trình đăng ký: ' . $e->getMessage())
                        ->withInput();
        }
    }
}
