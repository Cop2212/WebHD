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
            $table->foreignId('question_id')->nullable()->constrained();
            $table->foreignId('answer_id')->nullable()->constrained()->onDelete('no action');
            $table->timestamps();
        });

        // Sửa thành CREATE OR ALTER PROCEDURE (SQL Server 2016+)
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

        // Tương tự cho procedure xóa answer
        DB::unprepared('
            IF NOT EXISTS (SELECT * FROM sys.objects WHERE type = \'P\' AND name = \'sp_delete_answer_with_comments\')
            BEGIN
                EXEC(\'
                    CREATE PROCEDURE sp_delete_answer_with_comments(@answer_id INT)
                    AS
                    BEGIN
                        BEGIN TRANSACTION;
                        DELETE FROM comments WHERE answer_id = @answer_id;
                        DELETE FROM answers WHERE id = @answer_id;
                        COMMIT;
                    END
                \')
            END
            ELSE
            BEGIN
                EXEC(\'
                    ALTER PROCEDURE sp_delete_answer_with_comments(@answer_id INT)
                    AS
                    BEGIN
                        BEGIN TRANSACTION;
                        DELETE FROM comments WHERE answer_id = @answer_id;
                        DELETE FROM answers WHERE id = @answer_id;
                        COMMIT;
                    END
                \')
            END
        ');

        DB::statement('
            IF NOT EXISTS (SELECT * FROM sys.check_constraints WHERE name = \'chk_comment_target\')
            BEGIN
                ALTER TABLE comments ADD CONSTRAINT chk_comment_target
                CHECK (
                    (question_id IS NOT NULL AND answer_id IS NULL) OR
                    (question_id IS NULL AND answer_id IS NOT NULL)
                )
            END
        ');
    }

    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_delete_question_with_comments');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_delete_answer_with_comments');
        DB::statement('ALTER TABLE comments DROP CONSTRAINT IF EXISTS chk_comment_target');
        Schema::dropIfExists('comments');
    }
}
