<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id', 'name', 'province_id', 'category', 'tagline', 'image',
        'quick_info', 'about', 'about_image', 'about_image_2', 'about_image_3', 'map_link',
    ];

    protected $casts = [
        'quick_info' => 'array',
    ];

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id', 'id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'place_tag', 'place_id', 'tag_id');
    }

    public function activities()
    {
        return $this->hasMany(Activity::class, 'place_id', 'id');
    }

    public function foods()
    {
        return $this->hasMany(Food::class, 'place_id', 'id');
    }

    public function hotels()
    {
        return $this->hasMany(Hotel::class, 'place_id', 'id');
    }

    public function restaurants()
    {
        return $this->hasMany(Restaurant::class, 'place_id', 'id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'place_id', 'id');
    }

    // Helper: calculate average rating
    public function getAverageRatingAttribute()
    {
        $average = $this->reviews()->avg('rating');
        return $average ? round($average, 1) : 0;
    }

    // Helper: calculate total reviews count
    public function getReviewsCountAttribute()
    {
        return $this->reviews()->count();
    }
}
