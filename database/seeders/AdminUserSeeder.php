<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('admin_users')->insert([
            [
                'id' => 1,
                'username' => 'superadmin',
                'password' => Hash::make('password'), // Ganti dengan password yang Anda inginkan
                'name' => 'Super Administrator',
                'role' => 'super_admin',
                'last_login_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}