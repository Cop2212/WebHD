<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Đổi tên cột từ display_name thành name
            $table->renameColumn('display_name', 'name');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Đổi lại tên cũ nếu rollback
            $table->renameColumn('name', 'display_name');
        });
    }
};
