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
        Schema::create('users', function (Blueprint $table) {
            // Khóa chính: Địa chỉ ví
            $table->string('wallet_address', 42)->primary();
            
            // --- 2 CỘT MỚI THÊM VÀO ĐỂ ĐĂNG NHẬP ---
            $table->string('email')->unique()->nullable()->comment('Tên đăng nhập');
            $table->string('password')->nullable()->comment('Mật khẩu (sẽ được mã hóa)');
            // ---------------------------------------

            // Các cột thông tin chi tiết (giữ nguyên như cũ)
            $table->text('description')->nullable()->comment('Nội dung chi tiết về chương trình');
            $table->string('image_url', 255)->nullable()->comment('Link ảnh bìa chiến dịch');
            $table->timestamp('start_date')->nullable()->comment('Ngày bắt đầu');
            $table->timestamp('end_date')->nullable()->comment('Ngày kết thúc dự kiến');
            $table->integer('status')->default(0)->comment('0: Nháp, 1: Đang chạy, 2: Đã hoàn thành, 3: Đã đóng');
            
            $table->timestamps();
        });

        // Bảng sessions (giữ nguyên)
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('user_id', 42)->nullable()->index(); 
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('sessions');
    }
};