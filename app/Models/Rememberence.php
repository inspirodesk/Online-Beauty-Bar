<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rememberence extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'dateOfDeath',
        'normal_image_url',
        'frame_image_url',
        'address',
        'commenterName',
        'tribute',
        'rememberanceDay',
        'startTime',
        'endTime',
        'furtherAnnouncement',
        'contactName',
        'contactNumber',
        'contactName1',
        'contactNumber1',
        'contactName2',
        'contactNumber2',
        'adStartDate',
        'adEndDate'
    ];
    public function contactDetails()
    {
        return $this->hasMany(ContactDetail::class, 'object_id','contactId');
    }
}
