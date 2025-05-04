<?php

namespace App\Http\Controllers;

use App\Models\{Question, User, Answer};
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            // Người dùng đã đăng nhập
            $questions = Question::with(['user', 'tags'])
                ->withCount('answers')
                ->latest()
                ->paginate(10);

            return view('home.user', compact('questions'));
        }

        // Khách
        $popularQuestions = Question::with(['user', 'tags'])
            ->withCount('answers')
            ->orderByDesc('answers_count')
            ->take(5)
            ->get();

        return view('home.guest', compact('popularQuestions'));
    }
}
