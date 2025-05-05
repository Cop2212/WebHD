<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    public function run()
    {
        // Tạo 50 câu hỏi với dữ liệu giả lập
        Question::factory(50)->create();

        // Cập nhật answer_count và is_answered dựa trên logic thực tế
        Question::each(function ($question) {
            $question->update([
                'answer_count' => $question->answers()->count(),
                'is_answered' => $question->answers()->where('is_accepted', true)->exists()
            ]);
        });
    }
}
