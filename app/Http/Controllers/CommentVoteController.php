<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Comment;

class CommentVoteController extends Controller
{
    public function store(Comment $comment, Request $request)
    {
        $user = Auth::user();

        // Kiểm tra đã vote chưa
        $existingVote = $comment->votes()->where('user_id', $user->id)->first();

        if ($existingVote) {
            if ($existingVote->value == $request->value) {
                // Nếu nhấn lại vote cũ => xóa vote
                $existingVote->delete();
            } else {
                // Nếu đổi vote => cập nhật lại
                $existingVote->update(['value' => $request->value]);
            }
        } else {
            // Chưa vote => tạo mới
            $comment->votes()->create([
                'user_id' => $user->id,
                'value' => $request->value,
            ]);
        }

        return back();
    }
}
