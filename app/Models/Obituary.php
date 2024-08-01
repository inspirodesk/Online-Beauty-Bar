<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obituary extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'dateOfBirth',
        'dateOfDeath',
        'normal_image_url',
        'frame_image_url',
        'permanentAddress',
        'temporaryAddress',
        'dateOfStartView',
        'dateOfEndView',
        'dateOfDeathDeeds',
        'dateOfCremation',
        'furtherAnnouncement',
        'contactId',
        'adStartDate',
        'adEndDate'
    ];
   
    public function contactDetails()
    {
        return $this->hasMany(ContactDetail::class, 'object_id','contactId');
    }
}
