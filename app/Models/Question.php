<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'body', 'user_id', 'view_count',
        'vote_count', 'comments_count', 'is_answered',
        'is_closed', 'closed_at', 'closed_reason'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'Người dùng đã xóa',
            'id' => null
        ]);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    public function acceptedAnswer()
    {
        return $this->hasOne(Answer::class)->where('is_accepted', true);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'question_tag');
    }

    public function isVotedByUser($userId = null)
{
    $userId = $userId ?? optional(Auth::user())->id;

    return $userId && $this->votes()->where('user_id', $userId)->exists();
}

    // Thêm relationship votes
    public function votes(): HasMany
    {
        return $this->hasMany(QuestionVote::class); // Giả sử bạn có model QuestionVote
    }

    public function comments()
{
    return $this->hasMany(Comment::class);
}

    // Hoặc nếu bạn dùng polymorphic relationship
    /*
    public function votes(): MorphMany
    {
        return $this->morphMany(Vote::class, 'votable');
    }
    */

    // Thêm scope để tìm kiếm theo nhiều tag
    public function scopeWithAllTags($query, array $tagIds)
    {
        return $query->whereHas('tags', function($query) use ($tagIds) {
            $query->whereIn('tags.id', $tagIds);
        }, '=', count($tagIds));
    }
}
