<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Question;
use Illuminate\Support\Facades\DB;

class UpdateCommentCount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-comment-count';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cập nhật lại comments_count cho tất cả câu hỏi dựa trên comments hiện có';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Bắt đầu cập nhật comments_count...');

        $counts = DB::table('comments')
            ->select('question_id', DB::raw('count(*) as total'))
            ->groupBy('question_id')
            ->pluck('total', 'question_id');

        foreach ($counts as $questionId => $total) {
            Question::where('id', $questionId)->update(['comments_count' => $total]);
        }

        // Cập nhật 0 cho các câu hỏi không có comment
        Question::whereNotIn('id', $counts->keys())->update(['comments_count' => 0]);

        $this->info('Hoàn thành cập nhật comments_count!');
    }
}
