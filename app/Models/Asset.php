<?php
// app/Models/Asset.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'name',
        'file_path',
        'original_name',
        'is_active',
        'description',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Scope untuk logo aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope untuk tipe tertentu
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    // Helper untuk mendapatkan URL file
    public function getFileUrlAttribute()
    {
        return asset('storage/' . $this->file_path);
    }

    // Static method untuk mendapatkan logo aktif berdasarkan tipe
    public static function getActiveLogo($type = 'logo_main')
    {
        return self::active()->ofType($type)->latest()->first();
    }

    // Tipe-tipe asset yang tersedia
    public static function getAvailableTypes()
    {
        return [
            'logo' => 'Logo',
        ];
    }

    // Static method untuk mendapatkan semua logo aktif
    public static function getAllActiveLogos()
    {
        return self::active()->ofType('logo')->orderBy('created_at', 'asc')->get();
    }
}