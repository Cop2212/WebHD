<?php

namespace App\Http\Controllers;

use App\Models\{Question, User, Answer, Tag};
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    // Trong HomeController
public function index()
{
    // Đảm bảo sử dụng paginate() thay vì get() nếu cần phân trang
    $popularQuestions = Question::with(['user', 'tags', 'answers'])
        ->withCount(['answers', 'votes'])
        ->orderBy('answers_count', 'desc')
        ->take(5)
        ->get(); // Không phân trang nên không dùng withQueryString

    $questions = Question::with(['user', 'tags', 'answers'])
        ->withCount(['answers', 'votes'])
        ->latest()
        ->paginate(10); // Có phân trang nên có thể dùng withQueryString

    $popularTags = Tag::withCount('questions')
        ->orderBy('questions_count', 'desc')
        ->take(10)
        ->get();

    return view('home.guest', compact('popularQuestions', 'questions', 'popularTags'));
}

protected function getSystemStats()
    {
        return [
            'totalUsers' => User::count(),
            'totalQuestions' => Question::count(),
            'totalAnswers' => Answer::count(),
            'totalTags' => Tag::count()
        ];
    }

    protected function authenticatedHome(array $stats)
    {
        $questions = Question::with(['user', 'tags'])
            ->withCount('answers')
            ->latest()
            ->paginate(10);

        return view('home.dashboard', array_merge(compact('questions'), $stats));
    }

    protected function guestHome(array $stats)
    {
        return view('home.welcome', array_merge([
            'popularQuestions' => Question::popular()->limit(5)->get(),
            'popularTags' => Tag::popular()->limit(10)->get()
        ], $stats));
    }
}
