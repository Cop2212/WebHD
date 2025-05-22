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

    // ❌ Tạo procedure chỉ cho question
    DB::unprepared('
        IF NOT EXISTS (SELECT * FROM sys.objects WHERE type = \'P\' AND name = \'sp_delete_question_with_comments\')
        BEGIN
            EXEC(\'
                CREATE PROCEDURE sp_delete_question_with_comments(@question_id INT)
                AS
                BEGIN
                    BEGIN TRANSACTION;
                    DELETE FROM comments WHERE question_id = @question_id;
                    DELETE FROM questions WHERE id = @question_id;
                    COMMIT;
                END
            \')
        END
        ELSE
        BEGIN
            EXEC(\'
                ALTER PROCEDURE sp_delete_question_with_comments(@question_id INT)
                AS
                BEGIN
                    BEGIN TRANSACTION;
                    DELETE FROM comments WHERE question_id = @question_id;
                    DELETE FROM questions WHERE id = @question_id;
                    COMMIT;
                END
            \')
        END
    ');
}

public function down()
{
    DB::unprepared('DROP PROCEDURE IF EXISTS sp_delete_question_with_comments');
    Schema::dropIfExists('comments');
}

}
