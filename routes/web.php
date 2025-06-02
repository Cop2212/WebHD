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
    UserController,
    AdminController,
    CommentController,
    CommentVoteController,
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
        // Đúng: đặt 'create' trước 'show'
        Route::get('/questions/create', 'create')->name('questions.create');
        Route::get('/questions/{question}', 'show')->name('questions.show');

        // Thêm route vote nhưng chỉ cho authenticated users
        Route::middleware('auth')->post('/questions/{question}/vote', 'vote')->name('questions.vote');
    });

    // Tags Routes (public)
    Route::controller(TagController::class)->group(function () {
        Route::get('/tags/{tag:slug}', 'show')->name('tags.show');
    });
});

// Authenticated Routes
Route::middleware(['auth', 'web'])->group(function () {

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

    Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/questions', [AdminController::class, 'questions'])->name('admin.questions');
        Route::get('/tags', [AdminController::class, 'tags'])->name('admin.tags');
        Route::get('/users', [AdminController::class, 'users'])->name('admin.users');

        Route::post('/tags', [AdminController::class, 'store'])->name('admin.tags.store');
        Route::delete('questions/{id}', [AdminController::class, 'destroyQuestion'])->name('admin.questions.delete');
        Route::delete('tags/{id}', [AdminController::class, 'destroyTag'])->name('admin.tags.delete');
        Route::delete('users/{id}', [AdminController::class, 'destroyUser'])->name('admin.users.delete');
    });



    // Profile routes
    Route::prefix('profile')->controller(ProfileController::class)->group(function () {
        Route::get('/', 'show')->name('profile.show');
        Route::get('/edit', 'edit')->name('profile.edit');
        Route::get('/my-questions', [QuestionController::class, 'myQuestions'])->name('questions.mine');


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


    Route::post('/questions/{question}/comments', [CommentController::class, 'store'])
        ->name('questions.comments.store')
        ->middleware('auth');

    Route::post('/comments/{comment}/vote', [CommentVoteController::class, 'store'])
        ->name('comments.vote')->middleware('auth');

    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});
