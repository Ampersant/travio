<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    protected $fillable = [
        'name',
        'country_id',
    ];
    public $timestamps = false;  

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
    public function destinations(): HasMany
    {
        return $this->hasMany(Country::class);
    }
}
