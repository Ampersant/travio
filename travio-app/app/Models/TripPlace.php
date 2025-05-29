<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class TripPlace extends Pivot
{
    protected $table = 'trip_place';
    protected $fillable = [
        'place_id',
        'trip_id',
        'price',
        'shares',
        'check_in',
        'check_out'
    ];
    protected $casts = [
        'check_in' => 'datetime',
        'check_out' => 'datetime',
        'share' => 'array',
    ];

}
