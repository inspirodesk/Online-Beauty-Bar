<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image_url',
        'category',
        'ispopup',
        'isclosepopup',
        'display_time',
        'author',
       'email',
        'mobile',
       'address',
        'content',
        'date',
    ];
}