<?php

namespace App\Http\Controllers;

use App\Models\{Question, Tag, User, Answer, QuestionVote};
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
    ->loadCount(['answers', 'votes']);


    return view('questions.show', compact('question'));
}

// QuestionController.php
public function vote(Question $question)
{
    $user = auth()->user();

    // Kiểm tra user đã vote chưa
    $existingVote = QuestionVote::where([
        'user_id' => $user->id,
        'question_id' => $question->id
    ])->first();

    if ($existingVote) {
        // Nếu đã vote -> unvote
        $existingVote->delete();
        $question->decrement('votes_count');
        return back()->with('success', 'Đã hủy vote!');
    }

    // Nếu chưa vote -> tạo vote mới
    QuestionVote::create([
        'user_id' => $user->id,
        'question_id' => $question->id
    ]);

    $question->increment('votes_count');
    return back()->with('success', 'Vote thành công!');
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

    $query = Question::with([
            'user',
            'tags',
            'answers' => fn($q) => $q->latest()->limit(3)
        ])
        ->withCount(['answers', 'votes', 'views']);

    if ($selectedTags->isNotEmpty()) {
        $tagIds = $selectedTags->pluck('id')->toArray();
        $query->whereHas('tags', function($q) use ($tagIds) {
            $q->whereIn('id', $tagIds);
        }, '=', count($tagIds));
    }

    return $query->latest();
}

    protected function getSelectedTags(Request $request, Tag $mainTag = null)
{
    // Khởi tạo collection rỗng
    $selectedTags = collect();

    // Thêm mainTag nếu tồn tại
    if ($mainTag) {
        $selectedTags->push($mainTag);
    }

    // Thêm các tag từ request nếu có
    if ($request->filled('tags')) {
        $tagIds = explode(',', $request->tags);
        $additionalTags = Tag::whereIn('id', $tagIds)->get();
        $selectedTags = $selectedTags->merge($additionalTags);
    }

    return $selectedTags;
}

    public function create()
{
    $allTags = \App\Models\Tag::all(); // Sử dụng đúng tên $allTags như trong view
    return view('questions.create', compact('allTags'));
}

public function store(Request $request)
{
    // Xác thực dữ liệu từ request
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'body' => 'required|string',
        'tags' => 'required|array|min:1',
        'tags.*' => 'exists:tags,id',
    ]);

    // Tạo câu hỏi mới
    $question = new Question();
    $question->title = $validated['title'];
    $question->body = $validated['body'];
    $question->user_id = auth()->id(); // Gắn ID người dùng hiện tại
    $question->save();

    // Gắn tag cho câu hỏi (sử dụng bảng trung gian question_tag)
    $question->tags()->sync($validated['tags']);

    // Chuyển hướng về trang chủ của người dùng (hoặc dashboard)
    return redirect()->route('home')->with('success', 'Đã đăng câu hỏi thành công!');
}


    // Các method khác cho create, store, edit, update, destroy...
}
