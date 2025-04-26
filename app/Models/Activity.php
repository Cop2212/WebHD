<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    /**
     * Các trường có thể gán giá trị
     */
    protected $fillable = [
        'user_id',
        'type',
        'subject_id',
        'subject_type',
        'data' // Đổi từ 'changes' sang 'data' để khớp với migration
    ];

    /**
     * Kiểu dữ liệu sẽ được chuyển đổi
     */
    protected $casts = [
        'data' => 'array', // Đổi từ 'changes' sang 'data'
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Quan hệ với User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Quan hệ đa hình (polymorphic)
     */
    public function subject()
    {
        return $this->morphTo();
    }

    /**
     * Ghi log hoạt động (cập nhật phiên bản mới)
     */
    public static function log(string $type, $subject = null, array $data = [])
    {
        return static::create([
            'user_id' => auth()->id,
            'type' => $type,
            'subject_id' => $subject?->id,
            'subject_type' => $subject ? get_class($subject) : null,
            'data' => $data
        ]);
    }
}
