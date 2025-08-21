<?php

namespace Database\Seeders;

use App\Models\Survey;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class SurveySeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');

        for ($i = 0; $i < 50; $i++) {
            Survey::create([
                'nama' => $faker->name,
                'jenis_kelamin' => $faker->randomElement(['perempuan', 'laki_laki']),
                'usia' => $faker->numberBetween(15, 80),
                'ip_address' => $faker->ipv4,
                'user_agent' => $faker->userAgent,
                'created_at' => $faker->dateTimeBetween('-1 month', 'now'),
                'updated_at' => now(),
            ]);
        }
    }
}