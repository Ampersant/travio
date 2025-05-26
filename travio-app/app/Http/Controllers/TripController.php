<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\User;
use App\Models\Chat;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
// подключаем наше событие
use App\Events\TripCreated;

class TripController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $user_trips = $user->trips;
        return view('alltrips', compact('user_trips'));
    }
    public function confirm(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|integer',
            'items.*.name' => 'required|string',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.check_in' => 'required|date',
            'items.*.check_out' => 'required|date|after:items.*.check_in',
            'participants' => 'array',
            'participants.*' => 'email|exists:users,email',
        ]);
        try {
            DB::transaction(function () use ($validated,  $request) {
                $user = auth()->user();

                $participantUsers = User::whereIn('email', $validated['participants'])->get();
                if (! $participantUsers->contains($user)) {
                    $participantUsers->push($user);
                }
                $participantCount = $participantUsers->count();

                $sumPrice = 0;
                foreach ($validated['items'] as $item) {
                    $ci = Carbon::parse($item['check_in']);
                    $co = Carbon::parse($item['check_out']);
                    $nights = $ci->diffInDays($co) ?: 1;
                    $sumPrice += $item['price'] * $nights * $participantCount;
                }

                $trip = Trip::create([
                    'name'        => $request->input('name', 'Trip by ' . $user->name),
                    'creator_id'  => $user->id,
                    'status'      => 'active',
                    'sum_price'   => $sumPrice,
                ]);
                foreach ($validated['items'] as $item) {
                    $attachData[$item['id']] = [
                        'check_in'  => $item['check_in'],
                        'check_out' => $item['check_out'],
                        'price'     => $item['price'],
                    ];
                }
                $trip->places()->attach($attachData);
                $trip->users()->attach($participantUsers->pluck('id'));

                $chat = Chat::create([
                    'name'       => 'Chat for trip ' . $trip->name . '. Trip id:' . $trip->id,
                    'creator_id' => $user->id,
                ]);
                $chat->users()->attach($participantUsers->pluck('id'));

                Message::create([
                    'chat_id' => $chat->id,
                    'user_id' => $user->id,
                    'body'    => 'Welcome to the trip chat!',
                ]);

                event(new TripCreated($trip, $participantUsers));
            });

            return response()->json(['message' => 'Trip successfully created'], 201);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Error creating trip',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}
