<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255|unique:tags,name',
    ], [
        'name.unique' => 'Tên thẻ đã tồn tại.',
        'name.required' => 'Vui lòng nhập tên thẻ.',
    ]);

    \App\Models\Tag::create([
        'name' => $request->name,
        'slug' => Str::slug($request->name),
    ]);

    return redirect()->back()->with('success', 'Đã thêm thẻ mới!');
}

    public function dashboard() {
    // Thay đổi từ get() sang paginate() nếu muốn phân trang
    $questions = Question::latest()->paginate(5); // Thay thế take(5)->get()
    $tags = Tag::paginate(5, ['*'], 'tags_page');
    $users = User::latest()->paginate(5); // Thay thế take(5)->get()

    return view('admin.dashboard', compact('questions', 'tags', 'users'));
}

    public function questions() {
        // Sử dụng paginate để phân trang với mỗi trang 10 câu hỏi
        $questions = Question::paginate(5);
        return view('admin.manager.question', compact('questions'));
    }

    public function tags() {
        $tags = \App\Models\Tag::orderBy('created_at', 'desc')->get();
        return view('admin.manager.tags', compact('tags'));
    }

    public function users() {
        // Sử dụng paginate để phân trang với mỗi trang 10 người dùng
        $users = User::paginate(5);
        return view('admin.manager.user', compact('users'));
    }

    public function destroyQuestion($id) {
        $question = Question::findOrFail($id);
        $question->delete();

        return redirect()->route('admin.question')->with('success', 'Câu hỏi đã được xóa thành công.');
    }

    public function destroyTag($id) {
        $tag = Tag::findOrFail($id);
        $tag->delete();

        return redirect()->route('admin.tags')->with('success', 'Thẻ đã được xóa thành công.');
    }

    public function destroyUser($id) {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users')->with('success', 'Người dùng đã được xóa thành công.');
    }
}
