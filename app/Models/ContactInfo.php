<?php
// app/Models/ContactInfo.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactInfo extends Model
{
    use HasFactory;

    protected $table = 'contact_info';

    protected $fillable = [
        'department_name',
        'regency_name',
        'address',
        'province',
        'whatsapp',
        'email'
    ];

    /**
     * Get the current contact info (always use the first/latest record)
     */
    public static function getCurrent()
    {
        return self::first() ?: self::create([
            'department_name' => 'Dinas Komunikasi dan Informatika',
            'regency_name' => 'Kabupaten Lamongan',
            'address' => 'Jl. Basuki Rahmat No. 1, Lamongan',
            'province' => 'Jawa Timur 62211',
            'whatsapp' => '+628113021708',
            'email' => 'diskominfo@lamongankab.go.id'
        ]);
    }

    /**
     * Update or create contact info (singleton pattern)
     */
    public static function updateInfo($data)
    {
        $contact = self::first();
        if ($contact) {
            $contact->update($data);
            return $contact;
        } else {
            return self::create($data);
        }
    }
}