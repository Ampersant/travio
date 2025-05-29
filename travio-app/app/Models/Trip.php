<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Trip extends Model
{
    protected $fillable = [
        'name',
        'creator_id',
        'status',
        'sum_price',
    ];
    public const STATUS_ACTIVE  = 'active';
    public const STATUS_DRAFT = 'draft';
    public const STATUS_FINISHED = 'finished';

    public function places(): BelongsToMany
    {
        return $this->belongsToMany(Place::class, 'trip_place', 'trip_id', 'place_id')
                    ->withPivot('price', 'shares', 'check_in', 'check_out');
    }
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
