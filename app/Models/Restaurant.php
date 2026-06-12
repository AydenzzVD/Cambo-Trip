<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    protected $fillable = ['place_id', 'name', 'image', 'description', 'map_link'];

    public function place()
    {
        return $this->belongsTo(Place::class, 'place_id', 'id');
    }
}
