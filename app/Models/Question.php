<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'body', 'views'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // app/Models/Question.php
public function answers()
{
    return $this->hasMany(Answer::class);
}

public function acceptedAnswer()
{
    return $this->hasOne(Answer::class)->where('is_accepted', true);
}

public function tags()
    {
        return $this->belongsToMany(Tag::class, 'question_tag'); // hoặc 'question_tag' là tên pivot table
    }
}
