<?php

namespace App\Events;

use App\Models\Trip;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class TripCreated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Trip $trip;
    public $participants;

    public function __construct(Trip $trip, $participants)
    {
        $this->trip = $trip;
        $this->participants = $participants;
    }

    // имя канала для каждого пользователя
    public function broadcastOn()
    {
        return $this->participants->map(fn($user) => new PrivateChannel('notifications.' . $user->id))->toArray();
    }

    public function broadcastWith()
    {
        return [
            'trip_id'   => $this->trip->id,
            'trip_name' => $this->trip->name,
            'creator'   => $this->trip->creator_id,
        ];
    }
}
