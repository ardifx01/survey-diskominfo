<?php
// app/Models/FooterLink.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'url',
        'category',
        'order_index',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order_index');
    }

    public function scopeLayanan($query)
    {
        return $query->where('category', 'layanan');
    }

    public function scopeInformasi($query)
    {
        return $query->where('category', 'informasi');
    }

    public function getCategoryLabelAttribute()
    {
        return $this->category === 'layanan' ? 'Layanan' : 'Informasi';
    }
}