<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->id(); // ID tự tăng
            
            // 1. Cột ID liên kết với bảng campaigns
            $table->unsignedBigInteger('campaign_id');
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');

            // 2. Cột Tên chiến dịch
            $table->string('campaign_title')->nullable();

            // 3. Cột Số tiền VNĐ (Lưu tối đa 15 chữ số, 2 số thập phân)
            $table->decimal('amount_vnd', 15, 2)->nullable();

            // 4. Tự động tạo 2 cột created_at và updated_at
            $table->timestamps(); 
        });
    }

    public function down()
    {
        Schema::dropIfExists('donations');
    }
};