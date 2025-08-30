<?php
// database/seeders/AdminUserSeeder.php
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
        // Hapus data lama jika ada
        DB::table('admin_users')->truncate();

        // Tambah super admin default
        DB::table('admin_users')->insert([
            'username' => 'superadmin',
            'password' => Hash::make('superadmin123'),
            'name' => 'Super Administrator',
            'role' => 'super_admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Tambah admin biasa untuk contoh
        DB::table('admin_users')->insert([
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'name' => 'Administrator',
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}