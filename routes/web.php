<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ProfileController,
    HomeController,
    QuestionController,
    Auth\LoginController,
    Auth\RegisterController,
    Auth\PasswordResetController,
    Auth\EmailVerificationController,
    TagController
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

// Authenticated Routes
Route::middleware('auth')->group(function () {
    // Profile routes
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name('profile.show');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/update', [ProfileController::class, 'update'])->name('profile.update');
        Route::patch('/update-password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
    });

    // Email Verification
    Route::controller(EmailVerificationController::class)->group(function () {
        Route::get('email/verify', 'notice')->name('verification.notice');
        Route::get('email/verify/{id}/{hash}', 'verify')
            ->middleware('signed')
            ->name('verification.verify');
        Route::post('email/verification-notification', 'resend')
            ->name('verification.send');
    });

    // Questions Management (create/edit/delete)
    Route::resource('questions', QuestionController::class)
        ->except(['index', 'show'])
        ->names([
            'create' => 'questions.create',
            'store' => 'questions.store',
            'edit' => 'questions.edit',
            'update' => 'questions.update',
            'destroy' => 'questions.destroy'
        ]);

    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});

// Public Questions Routes
Route::controller(QuestionController::class)->group(function () {
    Route::get('/questions', 'index')->name('questions.index');
    Route::get('/questions/filter', 'filter')->name('questions.filter'); // Thêm route filter
    Route::get('/questions/{question}', 'show')->name('questions.show');
    Route::get('/questions/tagged/{tag:slug}', 'questionsByTag')->name('questions.by-tag'); // Route mới cho tag cụ thể
});

// Tags Routes (public)
Route::controller(TagController::class)->group(function () {
    Route::get('/tags', 'index')->name('tags.index');
    Route::get('/tags/{tag:slug}', 'show')->name('tags.show');
});
