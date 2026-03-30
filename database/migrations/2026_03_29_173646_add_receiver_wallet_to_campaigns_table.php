<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('campaigns', function (Blueprint $table) {
            // Địa chỉ ví ETH dài chuẩn 42 ký tự (tính cả '0x')
            $table->string('receiver_wallet', 42)->nullable()->after('goal_eth');
        });
    }

    public function down()
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->dropColumn('receiver_wallet');
        });
    }
};
