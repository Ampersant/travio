<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Amenity extends Model
{
    protected $fillable = [
        'name',
    ];
    public $timestamps = false;  

    public function places(): BelongsToMany
    {
        return $this->belongsToMany(Place::class);
    }
}
