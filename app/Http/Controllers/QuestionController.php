<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Question;

class QuestionController extends Controller
{
    public function filter(Request $request)
{
    $questions = Question::with(['user', 'tags', 'answers'])
        ->withCount(['answers'])
        ->when($request->tags, function ($query, $tags) {
            $query->whereHas('tags', function ($q) use ($tags) {
                $q->whereIn('name', explode(',', $tags));
            });
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10)
        ->withQueryString();

    // Thống nhất message với HomeController
    if ($questions->isEmpty()) {
        return response()->json([
            'html' => view('partials.no_questions')->render(),
            'pagination' => ''
        ]);
    }

    return response()->json([
        'html' => view('partials.questions', compact('questions'))->render(),
        'pagination' => $questions->links()->toHtml()
    ]);
}
}
