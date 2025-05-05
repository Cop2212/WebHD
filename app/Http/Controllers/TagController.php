<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Question;
use Illuminate\Http\Request;

class TagController extends Controller
{
    // Trong TagController@show
public function show(Tag $tag, Request $request)
{
    $selectedTagIds = $request->filled('tags')
        ? explode(',', $request->input('tags'))
        : [$tag->id]; // Mặc định là tag hiện tại

    $questions = Question::withAllTags($selectedTagIds)
        ->with(['user', 'tags'])
        ->latest()
        ->paginate(15);

    return view('tags.show', [
        'tag' => $tag,
        'questions' => $questions,
        'selectedTags' => Tag::whereIn('id', $selectedTagIds)->get(),
        'allTags' => Tag::orderBy('name')->get()
    ]);
}
}
