<?php
// app/Models/SurveySection.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveySection extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'order_index',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function questions()
    {
        return $this->hasMany(SurveyQuestion::class, 'section_id')
                    ->where('is_active', true)
                    ->orderBy('order_index');
    }

    public function allQuestions()
    {
        return $this->hasMany(SurveyQuestion::class, 'section_id')
                    ->orderBy('order_index');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order_index');
    }
}
