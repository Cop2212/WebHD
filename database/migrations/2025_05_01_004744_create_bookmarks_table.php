<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookmarksTable extends Migration
{
    public function up()
    {
        Schema::create('bookmarks', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('question_id')->constrained()->onDelete('no action');
            $table->timestamps();

            $table->primary(['user_id', 'question_id']);
        });

        // Chỉ tạo procedure nếu dùng SQL Server
        if (DB::getDriverName() === 'sqlsrv') {
            DB::unprepared('
                IF NOT EXISTS (SELECT * FROM sys.objects WHERE type = \'P\' AND name = \'sp_delete_question_with_bookmarks\')
                BEGIN
                    EXEC(\'CREATE PROCEDURE sp_delete_question_with_bookmarks(@question_id INT)
                        AS
                        BEGIN
                            BEGIN TRANSACTION;
                            DELETE FROM bookmarks WHERE question_id = @question_id;
                            DELETE FROM questions WHERE id = @question_id;
                            COMMIT;
                        END\')
                END
                ELSE
                BEGIN
                    EXEC(\'ALTER PROCEDURE sp_delete_question_with_bookmarks(@question_id INT)
                        AS
                        BEGIN
                            BEGIN TRANSACTION;
                            DELETE FROM bookmarks WHERE question_id = @question_id;
                            DELETE FROM questions WHERE id = @question_id;
                            COMMIT;
                        END\')
                END
            ');
        }
    }

    public function down()
    {
        if (DB::getDriverName() === 'sqlsrv') {
            DB::unprepared('DROP PROCEDURE IF EXISTS sp_delete_question_with_bookmarks');
        }

        Schema::dropIfExists('bookmarks');
    }
}
