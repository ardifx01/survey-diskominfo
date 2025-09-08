<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FooterLinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('footer_links')->insert([
            [
                'id' => 1,
                'title' => 'Tentang kami',
                'url' => 'https://lamongankab.go.id/',
                'category' => 'informasi',
                'order_index' => 1,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'title' => 'Website Resmi',
                'url' => 'https://lamongankab.go.id/',
                'category' => 'layanan',
                'order_index' => 1,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'title' => 'Portal Data',
                'url' => 'https://lamongankab.go.id/',
                'category' => 'layanan',
                'order_index' => 2,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'title' => 'Aplikasi Mobile',
                'url' => 'https://lamongankab.go.id/',
                'category' => 'layanan',
                'order_index' => 3,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'title' => 'Helpdesk',
                'url' => 'https://laporpakyes.lamongankab.go.id/',
                'category' => 'layanan',
                'order_index' => 4,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 6,
                'title' => 'Kebijakan Privasi',
                'url' => 'https://lamongankab.go.id/',
                'category' => 'informasi',
                'order_index' => 2,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}