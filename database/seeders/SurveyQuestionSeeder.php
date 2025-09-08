<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SurveyQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('survey_questions')->insert([
            // Data Diri Section (section_id: 13)
            [
                'id' => 23,
                'section_id' => 13,
                'question_text' => 'Email',
                'question_description' => null,
                'question_type' => 'short_text',
                'options' => null,
                'settings' => json_encode([]),
                'order_index' => 1,
                'is_required' => 1,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 24,
                'section_id' => 13,
                'question_text' => 'Nama Lengkap',
                'question_description' => 'Penulisan nama menggunakan huruf kapital dan gelar menyesuaikan, Contoh : INTANIA SARAH, S.Kom.',
                'question_type' => 'short_text',
                'options' => null,
                'settings' => json_encode([]),
                'order_index' => 2,
                'is_required' => 1,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 25,
                'section_id' => 13,
                'question_text' => 'jenis kelamin',
                'question_description' => null,
                'question_type' => 'multiple_choice',
                'options' => json_encode(['laki laki', 'perempuan']),
                'settings' => json_encode([]),
                'order_index' => 3,
                'is_required' => 1,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 26,
                'section_id' => 13,
                'question_text' => 'usia',
                'question_description' => null,
                'question_type' => 'multiple_choice',
                'options' => json_encode(['< 18 Tahun', '18 - 25 Tahun', '26 - 35 Tahun', '36 - 45 Tahun', '> 45 Tahun']),
                'settings' => json_encode([]),
                'order_index' => 4,
                'is_required' => 1,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 27,
                'section_id' => 13,
                'question_text' => 'Pendidikan Terakhir',
                'question_description' => null,
                'question_type' => 'multiple_choice',
                'options' => json_encode(['SMP ke bawah', 'SMA/ Sederajat', 'Diploma (D1-D4)', 'S1', 'S2/S3']),
                'settings' => json_encode([]),
                'order_index' => 5,
                'is_required' => 1,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 28,
                'section_id' => 13,
                'question_text' => 'Jenis Peserta',
                'question_description' => null,
                'question_type' => 'dropdown',
                'options' => json_encode(['Pemerintahan (Pegawai Pemerintah Dengan NIP/NIPTT-PK)', 'Masyarakat Umum']),
                'settings' => json_encode([]),
                'order_index' => 6,
                'is_required' => 1,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Survei Pelayanan Section (section_id: 14)
            [
                'id' => 29,
                'section_id' => 14,
                'question_text' => 'Pelayanan',
                'question_description' => null,
                'question_type' => 'dropdown',
                'options' => json_encode([
                    'Layanan Presentasi Pegawai',
                    'Layanan PPID (Pejabat Pengelola Informasi dan Dokumentasi)',
                    'Layanan Pengaduan Masyarakat',
                    'Layanan Jaringan Internet',
                    'Layanan Aplikasi Diskominfo Lamongan & Layanan Tanda Tangan Elektronik (TTE)',
                    'Layanan Lainnya'
                ]),
                'settings' => json_encode([]),
                'order_index' => 1,
                'is_required' => 1,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 30,
                'section_id' => 14,
                'question_text' => 'Apakah Saudara pernah mendapati praktik diskriminasi pada layanan Dinas Kominfo Kab. Lamongan',
                'question_description' => null,
                'question_type' => 'linear_scale',
                'options' => null,
                'settings' => json_encode([
                    'scale_max' => '5',
                    'scale_min' => '1',
                    'scale_max_label' => 'Selalu',
                    'scale_min_label' => 'Tidak Pernah'
                ]),
                'order_index' => 2,
                'is_required' => 1,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 31,
                'section_id' => 14,
                'question_text' => 'Apakah Saudara pernah mendapati praktik kecurangan, pungutan liar, atau imbalan dalam layanan ini?',
                'question_description' => null,
                'question_type' => 'linear_scale',
                'options' => null,
                'settings' => json_encode([
                    'scale_max' => '5',
                    'scale_min' => '1',
                    'scale_max_label' => 'Selalu',
                    'scale_min_label' => 'Tidak Pernah'
                ]),
                'order_index' => 3,
                'is_required' => 1,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 32,
                'section_id' => 14,
                'question_text' => 'Apakah sistem layanan ini mudah diakses dan digunakan?',
                'question_description' => null,
                'question_type' => 'linear_scale',
                'options' => null,
                'settings' => json_encode([
                    'scale_max' => '5',
                    'scale_min' => '1',
                    'scale_max_label' => 'Sangat Setuju (sangat mudah diakses dan digunakan)',
                    'scale_min_label' => 'Sangat Tidak Setuju (sulit diakses, rumit digunakan)'
                ]),
                'order_index' => 4,
                'is_required' => 1,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 33,
                'section_id' => 14,
                'question_text' => 'Apakah layanan ini memberikan respon atau tindak lanjut dengan cepat dan sesuai prosedur?',
                'question_description' => null,
                'question_type' => 'linear_scale',
                'options' => null,
                'settings' => json_encode([
                    'scale_max' => '5',
                    'scale_min' => '1',
                    'scale_max_label' => 'Sangat Setuju (sangat cepat dan sesuai prosedur)',
                    'scale_min_label' => 'Sangat Tidak Setuju (sangat lambat, tidak sesuai prosedur)'
                ]),
                'order_index' => 5,
                'is_required' => 1,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 34,
                'section_id' => 14,
                'question_text' => 'Apakah Saudara merasa puas dengan layanan ini secara keseluruhan?',
                'question_description' => null,
                'question_type' => 'linear_scale',
                'options' => null,
                'settings' => json_encode([
                    'scale_max' => '5',
                    'scale_min' => '1',
                    'scale_max_label' => 'sangat puas',
                    'scale_min_label' => 'sangat tidak puas'
                ]),
                'order_index' => 6,
                'is_required' => 1,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Testimoni Pelayanan Section (section_id: 15)
            [
                'id' => 35,
                'section_id' => 15,
                'question_text' => 'Ceritakan Pengelaman anda !',
                'question_description' => null,
                'question_type' => 'long_text',
                'options' => null,
                'settings' => json_encode([]),
                'order_index' => 1,
                'is_required' => 1,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}