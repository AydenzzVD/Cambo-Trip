<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['place_id', 'user_id', 'rating', 'comment'];

    public function place()
    {
        return $this->belongsTo(Place::class, 'place_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
