<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class AssetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat direktori assets jika belum ada
        $assetsPath = public_path('assets');
        if (!File::exists($assetsPath)) {
            File::makeDirectory($assetsPath, 0755, true);
        }

        // Insert data assets berdasarkan export database
        DB::table('assets')->insert([
            [
                'id' => 9,
                'type' => 'logo',
                'name' => '1757297130_pngegg.png',
                'file_path' => 'assets/1757297130_pngegg.png',
                'original_name' => 'pngegg.png',
                'is_active' => 1,
                'description' => 'Logo Dinas Komunikasi dan Informatika Kabupaten Lamongan',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        // Optional: Copy logo default jika file ada
        $defaultLogoSource = resource_path('images/logo-diskominfo.png');
        $defaultLogoDestination = public_path('assets/1757297130_pngegg.png');
        
        if (File::exists($defaultLogoSource)) {
            File::copy($defaultLogoSource, $defaultLogoDestination);
        } else {
            // Jika tidak ada file logo, buat placeholder
            $this->createPlaceholderLogo($defaultLogoDestination);
        }
    }

    /**
     * Buat placeholder logo sederhana
     */
    private function createPlaceholderLogo($destination)
    {
        // Buat gambar placeholder sederhana dengan GD (jika tersedia)
        if (extension_loaded('gd')) {
            $width = 200;
            $height = 200;
            
            $image = imagecreate($width, $height);
            $background = imagecolorallocate($image, 90, 155, 158); // Warna tema
            $textColor = imagecolorallocate($image, 255, 255, 255);
            
            // Tambah teks
            $text = 'LOGO';
            $fontSize = 5;
            $textWidth = imagefontwidth($fontSize) * strlen($text);
            $textHeight = imagefontheight($fontSize);
            $x = ($width - $textWidth) / 2;
            $y = ($height - $textHeight) / 2;
            
            imagestring($image, $fontSize, $x, $y, $text, $textColor);
            
            // Simpan sebagai PNG
            imagepng($image, $destination);
            imagedestroy($image);
        }
    }
}