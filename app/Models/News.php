<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'news_image_url',
        'status',
        'category',
        'site_selection'
    ];

    public function sites()
    {
        return $this->belongsToMany(Site::class, 'news_site', 'news_id', 'site_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'news_category', 'news_id', 'category_id');
    }
}
