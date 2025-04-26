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
        $perPage = 10;
        $selectedTags = $request->tags ? explode(',', $request->tags) : [];

        // Query cơ bản
        $questionsQuery = Question::with('user', 'tags')
                            ->latest();

        // Áp dụng filter tags nếu có
        if (!empty($selectedTags)) {
            $questionsQuery->whereHas('tags', function($query) use ($selectedTags) {
                $query->whereIn('name', $selectedTags);
            });
        }

        // Nếu cần trả về JSON (cho AJAX)
        if ($request->ajax() || $request->has('tags')) {
            return response()->json([
                'html' => view('partials.questions', [
    'questions' => $questionsQuery
        ->paginate($perPage)
        ->appends(['tags' => implode(',', $selectedTags)])
])->render()
            ]);
        }

        // Dữ liệu chung
        $viewData = [
            'questions' => $questionsQuery->paginate($perPage),
            'popularTags' => Tag::withCount('questions')
                           ->orderByDesc('questions_count')
                           ->take(15)
                           ->get(),
            'userCount' => User::count(),
            'questionCount' => Question::count(),
            'answerCount' => Answer::count(),
            'selectedTags' => $selectedTags
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
