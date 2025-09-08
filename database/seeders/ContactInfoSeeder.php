<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('contact_info')->insert([
            [
                'id' => 1,
                'department_name' => 'Dinas Komunikasi dan Informatika',
                'regency_name' => 'Kabupaten Lamongan',
                'address' => 'Jl. Basuki Rahmat No. 1, Lamongan',
                'province' => 'Jawa Timur 62211',
                'whatsapp' => '+62 811 302 1708',
                'email' => 'diskominfo@lamongankab.go.id',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}