<?php

namespace App\Http\Controllers;

use App\Models\{Question, User, Answer, Tag};
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        // Thống kê chung cho cả 2 trường hợp
        $stats = [
            'totalUsers' => User::count(),
            'totalQuestions' => Question::count(),
            'totalAnswers' => Answer::count(),
            'totalTags' => Tag::count()
        ];

        if (Auth::check()) {
            // Người dùng đã đăng nhập
            $questions = Question::with(['user', 'tags'])
                ->withCount('answers')
                ->latest()
                ->paginate(10);

            return view('home.user', array_merge(compact('questions'), $stats));
        }

        $popularTags = Tag::withCount('questions')
        ->orderByDesc('questions_count')
        ->limit(10)
        ->get();

        // Khách
        $popularQuestions = Question::with(['user', 'tags'])
            ->withCount('answers')
            ->orderByDesc('answers_count')
            ->take(5)
            ->get();

        return view('home.guest', array_merge(compact('popularQuestions', 'popularTags'), $stats));
    }
}
