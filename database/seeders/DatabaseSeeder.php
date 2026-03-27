<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Tạo sẵn tài khoản Admin
        DB::table('admins')->insert([
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
            'full_name' => 'Sếp Tổng',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // 2. Tạo sẵn tài khoản User
        DB::table('users')->insert([
            'email' => 'user@gmail.com',
            'password' => Hash::make('12345678'),
            'full_name' => 'Nguyễn Công Thức',
            'wallet_address' => '0xNguoiDungTest9876543210', 
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}