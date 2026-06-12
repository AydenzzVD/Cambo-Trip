<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name'];

    public function places()
    {
        return $this->belongsToMany(Place::class, 'place_tag', 'tag_id', 'place_id');
    }
}
