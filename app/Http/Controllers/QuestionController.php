<?php

namespace App\Http\Controllers;

use App\Models\{Question, Tag, User, Answer};
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index(Request $request)
{
    $selectedTagIds = (array)$request->input('tags', []);

    $query = Question::with(['user', 'tags', 'answers'])
        ->withCount(['answers', 'votes'])
        ->latest();

    // Lọc theo nhiều tag (AND condition)
    if (!empty($selectedTagIds)) {
        $query->whereHas('tags', function($q) use ($selectedTagIds) {
            $q->whereIn('id', $selectedTagIds);
        }, '=', count($selectedTagIds)); // Quan trọng: thêm điều kiện count
    }

    $questions = $query->paginate(15);
    $allTags = Tag::withCount('questions')->orderBy('name')->get();
    $popularTags = Tag::withCount('questions')->orderByDesc('questions_count')->limit(20)->get();

    return view('questions.index', [
        'questions' => $questions,
        'allTags' => $allTags,
        'popularTags' => $popularTags,
        'selectedTags' => Tag::whereIn('id', $selectedTagIds)->get()
    ]);
}

    public function filter(Request $request)
    {
        $tagIds = (array)$request->input('tags', []);

        $questions = Question::with(['user', 'tags', 'answers'])
            ->when(!empty($tagIds), function($query) use ($tagIds) {
                $query->whereHas('tags', function($q) use ($tagIds) {
                    $q->whereIn('id', $tagIds);
                });
            })
            ->withCount('answers')
            ->latest()
            ->paginate(15);

        return response()->json([
            'html' => view('questions._questions_list', compact('questions'))->render()
        ]);
    }

    public function questionsByTag(Tag $tag)
    {
        $questions = Question::with(['user', 'tags', 'answers'])
            ->whereHas('tags', function($q) use ($tag) {
                $q->where('id', $tag->id);
            })
            ->withCount('answers')
            ->latest()
            ->paginate(15);

        $allTags = Tag::withCount('questions')->orderBy('name')->get();
        $popularTags = Tag::withCount('questions')->orderByDesc('questions_count')->limit(20)->get();

        return view('questions.index', [
            'questions' => $questions,
            'allTags' => $allTags,
            'popularTags' => $popularTags,
            'tag' => $tag
        ]);
    }

    public function show(Question $question)
    {
        $question->load(['user', 'tags', 'answers.user'])
            ->loadCount(['answers', 'votes']);

        // Tăng view count
        $question->increment('views');

        return view('questions.show', compact('question'));
    }

    // Các method khác cho create, store, edit, update, destroy...
}
