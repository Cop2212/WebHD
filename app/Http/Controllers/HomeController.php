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
    $perPage = 10;
    $selectedTags = $request->tags ? explode(',', $request->tags) : [];

    $questionsQuery = Question::with(['user', 'tags'])
                        ->withCount(['answers'])
                        ->latest();

    if (!empty($selectedTags)) {
        $questionsQuery->whereHas('tags', function($query) use ($selectedTags) {
            $query->whereIn('name', $selectedTags);
        });
    }

    if ($request->ajax()) {
        $questions = $questionsQuery->paginate($perPage)
                          ->appends(['tags' => implode(',', $selectedTags)]);

        return response()->json([
            'html' => view('partials.questions', compact('questions'))->render(),
            'pagination' => $questions->links()->toHtml()
        ]);
    }

    $questions = $questionsQuery->paginate($perPage);

    return view('home', [
        'questions' => $questions,
        'popularTags' => Tag::withCount('questions')->orderByDesc('questions_count')->take(15)->get(),
        'userCount' => User::count(),
        'questionCount' => Question::count(),
        'answerCount' => Answer::count(),
        'selectedTags' => $selectedTags
    ]);
}
}
