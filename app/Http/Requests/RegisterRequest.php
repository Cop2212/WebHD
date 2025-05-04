<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Cho phép tất cả users gửi request
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'username' => [
                'required',
                'string',
                'max:50',
                'unique:users',
                'regex:/^[a-zA-Z0-9_]+$/' // Chỉ cho phép chữ, số và dấu _
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users'
            ],
            'password' => [
                'required',
                'confirmed',
                Rules\Password::defaults()->mixedCase()->numbers()->symbols()
            ],
        ];
    }

    /**
     * Custom validation messages
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Vui lòng nhập họ tên',
            'username.required' => 'Vui lòng nhập tên đăng nhập',
            'username.regex' => 'Tên đăng nhập chỉ được chứa chữ cái, số và dấu gạch dưới',
            'username.unique' => 'Tên đăng nhập đã tồn tại',
            'email.unique' => 'Email đã được sử dụng',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp',
        ];
    }

    /**
     * Prepare the data for validation
     */
    protected function prepareForValidation()
    {
        // Chuẩn hóa dữ liệu trước khi validate
        $this->merge([
            'username' => strtolower($this->username), // Chuyển username về chữ thường
            'email' => strtolower($this->email),
        ]);
    }
}
