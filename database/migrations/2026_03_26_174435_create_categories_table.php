<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Chạy khi gõ lệnh: php artisan migrate
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // VD: Y tế, Giáo dục
            $table->string('slug')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * Chạy khi gõ lệnh: php artisan migrate:rollback
     */
    public function down(): void
    {
        // Xóa bảng categories nếu nó tồn tại
        Schema::dropIfExists('categories');
    }
};