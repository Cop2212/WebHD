<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->morphs('votable'); // Cho cả questions và answers
            $table->smallInteger('vote')->comment('1 for upvote, -1 for downvote');
            $table->timestamps();

            $table->unique(['user_id', 'votable_id', 'votable_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('votes');
    }
};
