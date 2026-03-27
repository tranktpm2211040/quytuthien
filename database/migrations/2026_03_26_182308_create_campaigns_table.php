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
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            
            // Địa chỉ Smart Contract (dùng cho Web3)
            $table->string('contract_address', 42)->nullable();
            
            // Tên quỹ (Ảnh 1: Tên quỹ)
            $table->string('title', 255);
            
            // Mục tiêu ETH (Ảnh 1: Mục tiêu (ETH))
            // 15 chữ số tổng cộng, 2 chữ số sau dấu phẩy
            $table->decimal('goal_eth', 15, 2)->default(0);
            
            // Danh mục (Ảnh 1: Danh mục - Giáo dục, Y tế,...)
            $table->string('category')->nullable();
            
            // Mô tả chi tiết (Ảnh 1: Mô tả chi tiết)
            $table->text('description')->nullable();
            
            // Link ảnh bìa (Ảnh 1: Hình ảnh đại diện)
            $table->string('image_url', 255)->nullable();
            
            // Ngày bắt đầu & kết thúc (Ảnh 2: Ngày bắt đầu, Ngày kết thúc)
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            
            // Trạng thái (Ảnh 2: Trạng thái - 0: Nháp, 1: Đang chạy,...)
            $table->integer('status')->default(0);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};