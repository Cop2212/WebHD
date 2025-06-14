<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('comment_votes', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->unsignedBigInteger('comment_id')->nullable();
    $table->foreign('comment_id')->references('id')->on('comments')->onDelete('no action');
    $table->tinyInteger('value'); // 1 = upvote, -1 = downvote
    $table->timestamps();

    $table->unique(['user_id', 'comment_id']); // mỗi user chỉ vote 1 lần
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comment_votes');
    }
};
