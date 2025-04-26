<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Question;

class QuestionController extends Controller
{
    // Trong QuestionController.php
// app/Http/Controllers/QuestionController.php

public function filter(Request $request)
{
    $tags = $request->tags ? explode(',', $request->tags) : [];

    $questions = Question::with(['user', 'tags'])
        ->when(!empty($tags), function($query) use ($tags) {
            $query->whereHas('tags', function($q) use ($tags) {
                $q->whereIn('name', $tags);
            });
        })
        ->latest()
        ->paginate(10); // <- Phân trang sẽ tự hiểu ?page=2

    return response()->json([
        'html' => view('partials.questions', ['questions' => $questions])->render()
    ]);
}



    public function index()
    {
        $questions = Question::with(['user', 'tags'])
            ->latest()
            ->paginate(10); // 10 câu hỏi mỗi trang
    }

    public function create()
    {
        $tags = Tag::all();
        return view('questions.create', compact('tags'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|min:10|max:255',
            'body' => 'required|min:20',
            'tags' => 'required|array'
        ]);

        $question = Auth::user()->questions()->create([
            'title' => $request->title,
            'body' => $request->body
        ]);

        $question->tags()->attach($request->tags);

        return redirect()->route('questions.show', $question->id)
            ->with('success', 'Question posted successfully!');
    }

    public function show(Question $question)
    {
        $question->load(['user', 'tags', 'answers.user']);
        return view('questions.show', compact('question'));
    }
}
