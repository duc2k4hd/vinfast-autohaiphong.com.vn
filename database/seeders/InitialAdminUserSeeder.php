<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class InitialAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        // 1. Tạo vai trò Admin nếu chưa có
        $roleId = DB::table('roles')->where('name', 'admin')->value('id');
        if (! $roleId) {
            $roleId = DB::table('roles')->insertGetId([
                'name' => 'admin',
                'display_name' => 'Quản trị viên tối cao',
                'description' => 'Toàn quyền quản lý xe, đơn hàng, khách hàng và hệ thống website.',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // 2. Tạo tài khoản Admin mặc định
        $adminUser = DB::table('users')->where('email', 'admin@vinfast-autohaiphong.com.vn')->first();
        if (! $adminUser) {
            $userId = DB::table('users')->insertGetId([
                'name' => 'Quản Trị Viên VinFast',
                'email' => 'admin@vinfast-autohaiphong.com.vn',
                'password' => Hash::make('VinfastHaiPhong@2026'),
                'email_verified_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            // Gán role
            DB::table('role_user')->insert([
                'role_id' => $roleId,
                'user_id' => $userId,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}

