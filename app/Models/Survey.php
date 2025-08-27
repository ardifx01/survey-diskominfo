<?php
// app/Models/Survey.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;

    protected $fillable = [
        'ip_address',
        'user_agent'
    ];

    // Relasi ke survey responses
    public function responses()
    {
        return $this->hasMany(SurveyResponse::class);
    }

    // Helper method untuk mendapatkan jawaban berdasarkan pertanyaan
    public function getAnswerByQuestion($questionId)
    {
        return $this->responses()->where('question_id', $questionId)->first();
    }

    // Helper method untuk mendapatkan nama dari jawaban pertanyaan nama
    public function getNamaAttribute()
    {
        // Cari pertanyaan dengan teks yang mengandung "nama"
        $namaQuestion = \App\Models\SurveyQuestion::where('question_text', 'LIKE', '%nama%')
            ->orWhere('question_text', 'LIKE', '%Nama%')
            ->first();
            
        if ($namaQuestion) {
            $response = $this->getAnswerByQuestion($namaQuestion->id);
            return $response ? $response->answer : 'Anonymous';
        }
        
        return 'Anonymous';
    }

    // Helper method untuk mendapatkan jenis kelamin dari jawaban
    public function getJenisKelaminAttribute()
    {
        $genderQuestion = \App\Models\SurveyQuestion::where('question_text', 'LIKE', '%jenis kelamin%')
            ->orWhere('question_text', 'LIKE', '%Jenis Kelamin%')
            ->orWhere('question_text', 'LIKE', '%gender%')
            ->first();
            
        if ($genderQuestion) {
            $response = $this->getAnswerByQuestion($genderQuestion->id);
            return $response ? strtolower($response->answer) : null;
        }
        
        return null;
    }

    // Helper method untuk mendapatkan usia dari jawaban
    public function getUsiaAttribute()
    {
        $ageQuestion = \App\Models\SurveyQuestion::where('question_text', 'LIKE', '%usia%')
            ->orWhere('question_text', 'LIKE', '%Usia%')
            ->orWhere('question_text', 'LIKE', '%umur%')
            ->orWhere('question_text', 'LIKE', '%age%')
            ->first();
            
        if ($ageQuestion) {
            $response = $this->getAnswerByQuestion($ageQuestion->id);
            return $response ? (int)$response->answer : 0;
        }
        
        return 0;
    }

    // Accessor untuk label jenis kelamin
    public function getJenisKelaminLabelAttribute()
    {
        $jenisKelamin = $this->jenis_kelamin;
        
        if (strpos($jenisKelamin, 'perempuan') !== false || strpos($jenisKelamin, 'Perempuan') !== false) {
            return 'Perempuan';
        } elseif (strpos($jenisKelamin, 'laki') !== false || strpos($jenisKelamin, 'Laki') !== false) {
            return 'Laki-laki';
        }
        
        return $jenisKelamin ?: 'Tidak Diketahui';
    }

    // Scope untuk filter berdasarkan jenis kelamin (sekarang dari responses)
    public function scopeByGender($query, $gender)
    {
        return $query->whereHas('responses', function($q) use ($gender) {
            $q->whereHas('question', function($qq) {
                $qq->where('question_text', 'LIKE', '%jenis kelamin%')
                    ->orWhere('question_text', 'LIKE', '%Jenis Kelamin%')
                    ->orWhere('question_text', 'LIKE', '%gender%');
            })->where('answer', 'LIKE', '%' . $gender . '%');
        });
    }

    // Scope untuk filter berdasarkan rentang usia (sekarang dari responses)
    public function scopeByAgeRange($query, $min, $max)
    {
        return $query->whereHas('responses', function($q) use ($min, $max) {
            $q->whereHas('question', function($qq) {
                $qq->where('question_text', 'LIKE', '%usia%')
                    ->orWhere('question_text', 'LIKE', '%Usia%')
                    ->orWhere('question_text', 'LIKE', '%umur%')
                    ->orWhere('question_text', 'LIKE', '%age%');
            })->whereBetween('answer', [$min, $max]);
        });
    }
}