<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class AddVotesCascadeDeleteHandling extends Migration
{
    public function up()
    {
        // Xóa trigger cũ nếu tồn tại
        DB::unprepared('DROP TRIGGER IF EXISTS tr_votes_on_question_delete');

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
    }

    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_delete_question_with_votes');
    }
}
