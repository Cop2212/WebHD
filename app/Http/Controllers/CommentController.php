<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Question;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Question $question)
    {
        $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        $question->comments()->create([
            'body' => $request->body,
            'user_id' => auth()->id(),
        ]);

        return back()->with('success', 'Bình luận đã được thêm.');
    }
}

