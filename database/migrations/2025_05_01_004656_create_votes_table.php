<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVotesTable extends Migration
{
    public function up()
    {
        Schema::create('votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->tinyInteger('vote_type'); // 1: upvote, -1: downvote

            // Thay đổi ở đây:
            $table->foreignId('question_id')->nullable()->constrained()->onDelete('no action');
            $table->foreignId('answer_id')->nullable()->constrained()->onDelete('no action');

            $table->timestamps();
        });

        // Thêm constraint CHECK bằng raw SQL
        DB::statement('
            ALTER TABLE votes ADD CONSTRAINT chk_vote_target
            CHECK (
                (question_id IS NOT NULL AND answer_id IS NULL) OR
                (question_id IS NULL AND answer_id IS NOT NULL)
            )
        ');
    }

    public function down()
    {
        Schema::dropIfExists('votes');
    }
}
