<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name', 'slug'];
    // Hoặc nếu muốn cho phép tất cả trường:
    // protected $guarded = [];

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'question_tag');
    }
}
