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
        Schema::create('admins', function (Blueprint $table) {
            $table->id(); // Tự động tạo cột id INT(PK) tự tăng
            
            // Cột ví MetaMask (Thêm nullable để không bắt buộc nếu chỉ dùng email)
            $table->string('wallet_address', 42)->unique()->nullable(); 
            
            // VARCHAR(100) cho tên người điều hành
            $table->string('full_name', 100); 

            // --- 2 CỘT MỚI THÊM ĐỂ ĐĂNG NHẬP ---
            $table->string('email')->unique()->nullable()->comment('Email đăng nhập Admin');
            $table->string('password')->nullable()->comment('Mật khẩu Admin');
            // -----------------------------------
            
            // ENUM cho phân quyền
            $table->enum('role', ['super_admin', 'editor'])->default('editor'); 
            
            $table->timestamps(); // Tự động tạo 2 cột created_at và updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};