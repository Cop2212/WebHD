<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Tag;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard() {
        $questions = Question::latest()->take(5)->get();
        $tags = Tag::all();
        $users = User::latest()->take(5)->get();

        return view('admin.dashboard', compact('questions', 'tags', 'users'));
    }

    public function questions() {
        $questions = Question::all();
        return view('admin.manager.question', compact('questions'));
    }

    public function tags() {
        $tags = Tag::all();
        return view('admin.manager.tags', compact('tags'));
    }

    public function users() {
        $users = User::all();
        return view('admin.manager.user', compact('users'));
    }
}
