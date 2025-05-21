<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Support\Facades\DB;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagController extends Controller
{
    public function show(Tag $tag)
{
    $questions = $tag->questions()
        ->with(['user', 'tags', 'answers'])
        ->latest()
        ->paginate(15);

    // Tính số người dùng đã sử dụng tag này
    $usersCount = DB::table('questions')
        ->join('question_tag', 'questions.id', '=', 'question_tag.question_id')
        ->where('question_tag.tag_id', $tag->id)
        ->distinct('questions.user_id')
        ->count('questions.user_id');

    // Lấy các tag liên quan
    $relatedTags = Tag::whereHas('questions', function($query) use ($tag) {
            $query->whereHas('tags', function($q) use ($tag) {
                $q->where('tags.id', $tag->id);
            });
        })
        ->withCount('questions')
        ->where('id', '!=', $tag->id)
        ->orderBy('questions_count', 'desc')
        ->limit(10)
        ->get();

    return view('tags.show', compact('tag', 'questions', 'usersCount', 'relatedTags'));
}

}
