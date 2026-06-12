<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    protected $table = 'foods';
    protected $fillable = ['place_id', 'name', 'image', 'description'];

    public function place()
    {
        return $this->belongsTo(Place::class, 'place_id', 'id');
    }
}
