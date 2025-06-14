<?php

// namespace App\Http\Controllers\Auth;

// use App\Http\Controllers\Controller;
// use App\Models\User;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Hash;
// use Illuminate\Validation\Rules;

// class RegisteredUserController extends Controller
// {
//     public function create()
//     {
//         return view('auth.register');
//     }

//     public function store(Request $request)
// {
//     $request->validate([
//         'name' => ['required', 'string', 'max:255'],
//         'username' => ['required', 'string', 'max:255', 'unique:users'], // Thêm rule cho username
//         'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
//         'password' => ['required', 'confirmed', Rules\Password::defaults()],
//     ]);

//     $user = User::create([
//         'name' => $request->name,
//         'username' => $request->username, // Thêm username
//         'email' => $request->email,
//         'password' => Hash::make($request->password),
//     ]);

//     Auth::login($user);

//     return redirect(route('home'));
// }
// }
