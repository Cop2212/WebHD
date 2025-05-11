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
    TagController,
    UserController
};

// Public Routes
Route::middleware(['web'])->group(function () {
    // Trang chủ
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // Authentication Routes (cho guest)
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

    // Questions Routes (public)
    Route::controller(QuestionController::class)->group(function () {
        Route::get('/questions', 'index')->name('questions.index');
        Route::get('/questions/create', 'create')->name('questions.create');
        Route::get('/questions/{question}', 'show')->name('questions.show');
    });

    // Tags Routes (public)
    Route::controller(TagController::class)->group(function () {
        Route::get('/tags/{tag:slug}', 'show')->name('tags.show');
    });
});

// Authenticated Routes
Route::middleware(['auth', 'web'])->group(function () {
    // Profile routes
    Route::prefix('profile')->controller(ProfileController::class)->group(function () {
        Route::get('/', 'show')->name('profile.show');
        Route::get('/edit', 'edit')->name('profile.edit');
        Route::patch('/update', 'update')->name('profile.update');
        Route::patch('/update-password', 'updatePassword')->name('profile.update-password');
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

    Route::post('/send-email-verification', [UserController::class, 'sendEmailVerification']);

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
