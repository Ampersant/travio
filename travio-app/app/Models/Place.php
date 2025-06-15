<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Place extends Model
{
    protected $fillable = [
        'name',
        'price',
        'description',
        'rating',
        'destination_id',
        'image_url',
    ];

    public function trips(): BelongsToMany
    {
        return $this->belongsToMany(Trip::class);
    }
    public function amenities(): BelongsToMany
    {
        return $this->belongsToMany(Amenity::class);
    }
    public function destination(): BelongsTo
    {
       return $this->belongsTo(Destination::class);
    }
}
