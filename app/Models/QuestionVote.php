<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuestionVote extends Model
{
    use HasFactory;

    protected $fillable = ['question_id', 'user_id'];
protected $casts = [
    'vote' => 'integer'
];
    /**
     * @return BelongsTo<Question, QuestionVote>
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * @return BelongsTo<User, QuestionVote>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
