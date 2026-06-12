<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id', 'name', 'tagline', 'description', 'image', 'sections',
    ];

    protected $casts = [
        'sections' => 'array',
    ];

    public function places()
    {
        return $this->hasMany(Place::class, 'province_id', 'id');
    }

    public function placesForSection(string $section)
    {
        $ids = $this->sections[$section] ?? [];
        return Place::whereIn('id', $ids)->get()->sortBy(function ($p) use ($ids) {
            return array_search($p->id, $ids);
        })->values();
    }
}
