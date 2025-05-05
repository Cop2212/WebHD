<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    public function rules()
{
    return [
        'email' => ['required', 'string', 'email'],
        'password' => ['required', 'string'],
    ];
}

public function authenticate()
{
    $remember = $this->boolean('remember'); // Chỉ ghi nhớ khi tích checkbox

    if (! Auth::attempt($this->only('email', 'password'), $remember)) {
        throw ValidationException::withMessages([
            'email' => __('auth.failed'),
        ]);
    }
}
}
