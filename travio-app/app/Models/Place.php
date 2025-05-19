<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Place extends Model
{
    protected $fillable = [
        'name',
        'price',
        'description',
        'destination_id',
    ];

    public function trips(): BelongsToMany
    {
        return $this->belongsToMany(Trip::class);
    }
}
