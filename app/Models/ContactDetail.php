<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactDetail extends Model
{
    protected $fillable = ['contact_name', 'contact_number', 'object_id'];

    public function obituary()
    {
        return $this->belongsTo(Obituary::class);
    }
}
