<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Question;
use App\Models\Tag;
use App\Models\User;
use App\Models\Answer;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
    $selectedTags = $request->tags ? explode(',', $request->tags) : [];

    $questionsQuery = Question::with(['user', 'tags'])
        ->withCount(['answers'])
        ->when($selectedTags, function ($query, $tags) {
            $query->whereHas('tags', function ($q) use ($tags) {
                $q->whereIn('name', $tags);
            });
        })
        ->latest();

    // Sử dụng withQueryString() thay vì appends()
    $questions = $questionsQuery->paginate(10)->withQueryString();

    // AJAX response
    if ($request->ajax()) {
        return response()->json([
            'html' => view('partials.questions', compact('questions'))->render(),
            'pagination' => $questions->links()->toHtml()
        ]);
    }

    // Thêm xử lý khi không có kết quả
    $noResults = $questions->isEmpty() && !empty($selectedTags);

    $viewData = [
        'questions' => $questions,
        'popularTags' => Tag::withCount('questions')
                       ->orderByDesc('questions_count')
                       ->take(15)
                       ->get(),
        'userCount' => User::count(),
        'questionCount' => Question::count(),
        'answerCount' => Answer::count(),
        'selectedTags' => $selectedTags,
        'noResults' => $noResults
    ];
        if (!$user) {
            return view('home_guest', $viewData);
        }

        if (!User::find($user->id)) {
            Auth::logout();
            return redirect()->route('register')
                   ->withErrors(['email' => 'Tài khoản của bạn không còn tồn tại.']);
        }

        return view('home', $viewData);
    }
}
