<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\DashboardController;
use Illuminate\Http\Request; // Thêm dòng này
use App\Models\Question;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Trang chủ
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/questions/filter', [QuestionController::class, 'filter'])->name('questions.filter');

// Các route auth (breeze)
Route::middleware('auth')->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::view('profile', 'profile')->name('profile');
});

Route::post('logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/questions/create', [QuestionController::class, 'create'])->name('questions.create');
    Route::post('/questions', [QuestionController::class, 'store'])->name('questions.store');
});

Route::resource('questions', QuestionController::class);


require __DIR__.'/auth.php';
