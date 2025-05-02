<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class AddVotesCascadeDeleteHandling extends Migration
{
    public function up()
    {
        // Xóa trigger cũ nếu tồn tại
        DB::unprepared('DROP TRIGGER IF EXISTS tr_votes_on_question_delete');
        DB::unprepared('DROP TRIGGER IF EXISTS tr_votes_on_answer_delete');

        // Tạo stored procedure xử lý xóa question
        DB::unprepared('
            IF NOT EXISTS (SELECT * FROM sys.objects WHERE type = \'P\' AND name = \'sp_delete_question_with_votes\')
            BEGIN
                EXEC(\'
                    CREATE PROCEDURE sp_delete_question_with_votes(@question_id INT)
                    AS
                    BEGIN
                        BEGIN TRANSACTION;
                        DELETE FROM votes WHERE question_id = @question_id;
                        DELETE FROM comments WHERE question_id = @question_id;
                        DELETE FROM questions WHERE id = @question_id;
                        COMMIT;
                    END
                \')
            END
            ELSE
            BEGIN
                EXEC(\'
                    ALTER PROCEDURE sp_delete_question_with_votes(@question_id INT)
                    AS
                    BEGIN
                        BEGIN TRANSACTION;
                        DELETE FROM votes WHERE question_id = @question_id;
                        DELETE FROM comments WHERE question_id = @question_id;
                        DELETE FROM questions WHERE id = @question_id;
                        COMMIT;
                    END
                \')
            END
        ');

        // Tạo stored procedure xử lý xóa answer
        DB::unprepared('
            IF NOT EXISTS (SELECT * FROM sys.objects WHERE type = \'P\' AND name = \'sp_delete_answer_with_votes\')
            BEGIN
                EXEC(\'
                    CREATE PROCEDURE sp_delete_answer_with_votes(@answer_id INT)
                    AS
                    BEGIN
                        BEGIN TRANSACTION;
                        DELETE FROM votes WHERE answer_id = @answer_id;
                        DELETE FROM comments WHERE answer_id = @answer_id;
                        DELETE FROM answers WHERE id = @answer_id;
                        COMMIT;
                    END
                \')
            END
            ELSE
            BEGIN
                EXEC(\'
                    ALTER PROCEDURE sp_delete_answer_with_votes(@answer_id INT)
                    AS
                    BEGIN
                        BEGIN TRANSACTION;
                        DELETE FROM votes WHERE answer_id = @answer_id;
                        DELETE FROM comments WHERE answer_id = @answer_id;
                        DELETE FROM answers WHERE id = @answer_id;
                        COMMIT;
                    END
                \')
            END
        ');
    }

    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_delete_question_with_votes');
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_delete_answer_with_votes');
    }
}
