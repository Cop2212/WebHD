<?php

namespace App\Http\Controllers;

use App\Models\{Question, User, Answer, Tag};
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $stats = $this->getSystemStats();

        if (Auth::check()) {
            // Người dùng đã đăng nhập - hiển thị trang user.blade.php
            return $this->authenticatedHome($stats);
        } else {
            // Người dùng chưa đăng nhập - hiển thị trang guest
            return $this->guestHome($stats);
        }
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
    $user = Auth::user();

    $userQuestions = Question::where('user_id', $user->id)
        ->with(['tags', 'answers'])
        ->withCount(['answers', 'votes'])
        ->latest()
        ->paginate(10);

    // Lọc theo tag nếu có
    $selectedTagIds = request()->input('tags')
        ? explode(',', request()->input('tags'))
        : [];

    $questions = Question::with(['user', 'tags'])
    ->withCount('answers')
    ->when(!empty($selectedTagIds), function ($query) use ($selectedTagIds) {
        // Join bảng trung gian và đếm số lượng tag khớp với câu hỏi
        $query->whereHas('tags', function ($q) use ($selectedTagIds) {
            $q->whereIn('tags.id', $selectedTagIds);
        }, '=', count($selectedTagIds));
    })
    ->latest()
    ->paginate(10);


    // Lấy tất cả tag
    $allTags = Tag::withCount('questions')->get();

    // Lấy tag đã chọn
    $selectedTags = Tag::whereIn('id', $selectedTagIds)->get();

    return view('home.user', array_merge(
        compact('user', 'userQuestions', 'questions', 'allTags', 'selectedTags'),
        $stats
    ));
}


    protected function guestHome(array $stats)
    {
        $popularQuestions = Question::with(['user', 'tags', 'answers'])
            ->withCount(['answers', 'votes'])
            ->orderBy('answers_count', 'desc')
            ->orderByDesc('vote_count')
            ->take(5)
            ->get();

        $popularTags = Tag::withCount('questions')
            ->orderBy('questions_count', 'desc')
            ->take(10)
            ->get();

        return view('home.guest', array_merge(compact('popularQuestions', 'popularTags'), $stats));
    }
}
