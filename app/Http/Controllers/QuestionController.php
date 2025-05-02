<?php

namespace App\Http\Controllers;

use App\Models\{Question, Tag, User, Answer};

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::with(['user', 'tags'])
            ->latest()
            ->paginate(10);

        $stats = [
            'users' => User::count(),
            'questions' => Question::count(),
            'answers' => Answer::count()
        ];

        $popularTags = Tag::withCount('questions')
            ->orderByDesc('questions_count')
            ->limit(5)
            ->get();

        return view('home.guest', compact('questions', 'stats', 'popularTags'));
    }
}
