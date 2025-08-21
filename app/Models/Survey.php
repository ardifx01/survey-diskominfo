<?php
// app/Models/Survey.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'jenis_kelamin',
        'usia',
        'ip_address',
        'user_agent'
    ];

    protected $casts = [
        'usia' => 'integer',
    ];

    // Accessor untuk menampilkan jenis kelamin
    public function getJenisKelaminLabelAttribute()
    {
        return $this->jenis_kelamin === 'perempuan' ? 'Perempuan' : 'Laki-laki';
    }

    // Scope untuk filter berdasarkan jenis kelamin
    public function scopeByGender($query, $gender)
    {
        return $query->where('jenis_kelamin', $gender);
    }

    // Scope untuk filter berdasarkan rentang usia
    public function scopeByAgeRange($query, $min, $max)
    {
        return $query->whereBetween('usia', [$min, $max]);
    }
}
