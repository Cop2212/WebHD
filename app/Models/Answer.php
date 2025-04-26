<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = [
        'body',
        'question_id',
        'user_id',
        'is_accepted',
        'votes_count'
    ];

    protected $casts = [
        'is_accepted' => 'boolean',
    ];

    /**
     * Quan hệ với Question
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * Quan hệ với User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Đánh dấu câu trả lời được chấp nhận
     */
    public function markAsBest()
    {
        $this->question->answers()->update(['is_accepted' => false]);
        $this->update(['is_accepted' => true]);

        // Cập nhật best_answer_id trong questions nếu cần
        // $this->question->update(['best_answer_id' => $this->id]);
    }

    /**
     * Scope cho câu trả lời được chấp nhận
     */
    public function scopeAccepted($query)
    {
        return $query->where('is_accepted', true);
    }

    /**
     * Scope sắp xếp theo điểm vote
     */
    public function scopeOrderByVotes($query)
    {
        return $query->orderBy('votes_count', 'desc');
    }
}
