<?php

// Kiểm tra đầu file mỗi Model phải có:
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;       // Add this import
use App\Models\Question;

class Comment extends Model
{
    protected $fillable = ['body', 'user_id', 'question_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function votes()
{
    return $this->hasMany(CommentVote::class);
}

public function voteScore()
{
    return $this->votes()->sum('value');
}

public function isVotedBy($userId)
{
    return $this->votes()->where('user_id', $userId)->exists();
}

}
