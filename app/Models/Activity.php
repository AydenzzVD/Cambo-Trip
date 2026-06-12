<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = ['place_id', 'name'];

    public function place()
    {
        return $this->belongsTo(Place::class, 'place_id', 'id');
    }
}
