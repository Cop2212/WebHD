<?php

namespace App\Http\Controllers;

use App\Models\{Question, Tag, User, Answer};
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index(Request $request)
    {
        $questions = $this->buildQuestionQuery($request)->paginate(15);
        $allTags = Tag::withCount('questions')->orderBy('name')->get();

        return view('questions.index', [
            'questions' => $questions,
            'allTags' => $allTags,
            'popularTags' => Tag::popular()->limit(20)->get(),
            'selectedTags' => collect(),
            'mainTag' => null
        ]);
    }

    public function show(Question $question)
{
    // Load đầy đủ quan hệ và counts
    $question->load(['user', 'tags', 'answers'])
    ->loadCount(['answers', 'votes', 'views']);


    return view('questions.show', compact('question'));
}

    public function showByTag(Request $request, Tag $tag)
    {
        $questions = $this->buildQuestionQuery($request, $tag)->paginate(15);
        $allTags = Tag::withCount('questions')->orderBy('name')->get();

        return view('questions.index', [
            'questions' => $questions,
            'mainTag' => $tag,
            'selectedTags' => $this->getSelectedTags($request, $tag),
            'allTags' => $allTags,
            'popularTags' => Tag::popular()->limit(20)->get()
        ]);
    }

    public function filter(Request $request)
    {
        $questions = $this->buildQuestionQuery($request)->paginate(15);

        return response()->json([
            'html' => view('questions.partials.list', compact('questions'))->render()
        ]);
    }

    protected function buildQuestionQuery(Request $request, Tag $mainTag = null)
{
    $selectedTags = $this->getSelectedTags($request, $mainTag);

    return Question::with([
            'user',
            'tags',
            'answers' => fn($q) => $q->latest()->limit(3) // nếu muốn giới hạn số câu trả lời load
        ])
        ->when($selectedTags->isNotEmpty(), function ($query) use ($selectedTags) {
            $tagIds = $selectedTags->pluck('id');
            $query->whereHas('tags', function ($q) use ($tagIds) {
                $q->whereIn('id', $tagIds);
            }, '=', count($tagIds));
        })
        ->withCount(['answers', 'votes', 'views']) // quan trọng
        ->latest();
}

    protected function getSelectedTags(Request $request, Tag $mainTag = null)
    {
        $selectedTags = $mainTag ? collect([$mainTag]) : collect();

        if ($request->filled('tags')) {
            $tagIds = explode(',', $request->tags);
            $additionalTags = Tag::whereIn('id', $tagIds)->get();
            $selectedTags = $selectedTags->merge($additionalTags);
        }

        return $selectedTags;
    }

    // Các method khác cho create, store, edit, update, destroy...
}
