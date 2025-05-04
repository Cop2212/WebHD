<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ProfileController,
    HomeController,
    QuestionController,
    Auth\LoginController,
    Auth\RegisterController,
    Auth\PasswordResetController,
    Auth\EmailVerificationController
};

// Trang chủ
Route::get('/', [HomeController::class, 'index'])->name('home');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::controller(LoginController::class)->group(function () {
        Route::get('login', 'showLoginForm')->name('login');
        Route::post('login', 'login');
    });

    Route::controller(RegisterController::class)->group(function () {
        Route::get('register', 'showRegistrationForm')->name('register');
        Route::post('register', 'register');
    });

    Route::controller(PasswordResetController::class)->group(function () {
        Route::get('forgot-password', 'showLinkRequestForm')->name('password.request');
        Route::post('forgot-password', 'sendResetLinkEmail')->name('password.email');
        Route::get('reset-password/{token}', 'showResetForm')->name('password.reset');
        Route::post('reset-password', 'reset')->name('password.update');
    });
});

// Email Verification
Route::middleware('auth')->group(function () {
    Route::get('/user', function () {
        return view('user'); // Sẽ sử dụng layout user.blade.php
    })->name('user');

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');

    Route::controller(EmailVerificationController::class)->group(function () {
        Route::get('email/verify', 'notice')->name('verification.notice');
        Route::get('email/verify/{id}/{hash}', 'verify')
            ->middleware('signed')
            ->name('verification.verify');
        Route::post('email/verification-notification', 'resend')
            ->name('verification.send');
    });

    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});

// Questions Resource (with custom index)
Route::resource('questions', QuestionController::class)->except(['index']);
Route::get('/questions', [QuestionController::class, 'index'])->name('questions.index');
