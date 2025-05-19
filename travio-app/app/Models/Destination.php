<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Destination extends Model
{
    protected $fillable = [
        'description',
        'city_id',
    ];
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
