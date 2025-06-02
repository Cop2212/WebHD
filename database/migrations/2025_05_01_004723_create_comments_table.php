<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    public function up()
{
    Schema::create('comments', function (Blueprint $table) {
        $table->id();
        $table->text('body');
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('question_id')->constrained();
        $table->timestamps();
    });

    // ❌ Xoá đoạn stored procedure này vì SQLite không hỗ trợ
    // DB::unprepared(...);
}

public function down()
{
    // Không cần DROP PROCEDURE nếu không tạo
    // DB::unprepared('DROP PROCEDURE IF EXISTS sp_delete_question_with_comments');
    Schema::dropIfExists('comments');
}


}
