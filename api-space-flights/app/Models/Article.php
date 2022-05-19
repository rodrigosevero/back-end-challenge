<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        "featured",
        "title",
        "url",
        "imageUrl",
        "newsSite",
        "summary",
        "published_at"
    ];

    // public function launches()
    // {
    //     return $this->hasMany(Launch::class, 'article', 'id');
    // }

    // public function events()
    // {
    //     return $this->hasMany(Event::class, 'article', 'id');
    // }

    // public function setFeaturedAttribute($value)
    // {
    //     $this->attributes['featured'] = ($value == true ? 1 : 0);
    // }

    // public function setUrlAttribute($value)
    // {
    //     $this->attributes['url'] = Str::slug($value);
    // }

    // public function setImageUrlAttribute($value)
    // {
    //     $this->attributes['imageUrl'] = Str::slug($value);
    // }
}