<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DestinationType extends Model
{
    protected $fillable = [
        'name',
    ];
    public $timestamps = false;  
    public function destinations(): HasMany
    {
        return $this->hasMany(Destination::class);
    }
}
