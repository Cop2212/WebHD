<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('comment_votes', function (Blueprint $table) {
            // Giả sử ban đầu là tinyInteger => đổi thành Integer
            $table->integer('value')->change();
        });
    }

    public function down(): void
    {
        Schema::table('comment_votes', function (Blueprint $table) {
            $table->tinyInteger('value')->change(); // hoặc kiểu cũ tùy bạn dùng gì
        });
    }
};

