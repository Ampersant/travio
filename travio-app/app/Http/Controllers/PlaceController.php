<?php

namespace App\Http\Controllers;

use App\Models\Place;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PlaceController extends Controller
{
    public function all(Request $request): JsonResponse
    {
        $query = Place::with([
            'destination.city.country',
            'amenities',
            'destination.destinationType'
        ]);

        if ($request->filled('country')) {
            $query->whereHas('destination.city.country', function ($q) use ($request) {
                $q->where('countries.id', $request->input('country'));
            });
        }

        if ($request->filled('city')) {
            $query->whereHas('destination.city', function ($q) use ($request) {
                $q->where('cities.id', $request->input('city'));
            });
        }

        if ($request->filled('priceMin')) {
            $query->where('places.price', '>=', $request->input('priceMin'));
        }

        if ($request->filled('priceMax')) {
            $query->where('places.price', '<=', $request->input('priceMax'));
        }

        if ($request->filled('ratings')) {
            $ratings = $request->input('ratings');
            if (!empty($ratings)) {
                $query->whereIn('places.rating', $ratings);
            }
        }

        if ($request->filled('types')) {
            $types = $request->input('types');
            if (!empty($types)) {
                $query->whereHas('destination.destinationType', function ($q) use ($types) {
                    $q->whereIn('destination_types.id', $types);
                });
            }
        }

        if ($request->filled('amenities')) {
            $amenities = $request->input('amenities');
            if (!empty($amenities)) {
                foreach ($amenities as $amenityId) {
                    $query->whereHas('amenities', function ($q) use ($amenityId) {
                        $q->where('amenities.id', $amenityId);
                    });
                }
            }
        }

        $perPage = 8;
        $places = $query->paginate($perPage);

        $data = $places->map(function ($place) {
            return [
                'id' => $place->id,
                'name' => $place->name,
                'price' => $place->price,
                'rating' => $place->rating,
                'description' => $place->description,
                'image_url' =>  asset('images/' . $place->image_url),
                'destination' => [
                    'id' => $place->destination->id,
                    'type' => $place->destination->destinationType->name,
                    'city' => $place->destination->city->name,
                    'country' => $place->destination->city->country->name,
                ],
                'amenities' => $place->amenities->map(fn($a) => [
                    'id' => $a->id,
                    'name' => $a->name
                ])
            ];
        });

        return response()->json([
            'data' => $data,
            'current_page' => $places->currentPage(),
            'last_page' => $places->lastPage(),
            'total' => $places->total()
        ]);
    }
    public function show(int $id)
    {
        $place = Place::with([
            'destination.city.country',
            'destination.destinationType',
            'amenities'
        ])->findOrFail($id);
        $amenityIcons = [
            'Swimming Pool'      => 'swimming-pool',
            'Free WiFi'           => 'wifi',
            'Breakfast Included' => 'coffee',
            'Free Parking'       => 'parking',
            'Spa Service'        => 'spa',
            'Concierge'          => 'concierge-bell',
        ];
        $amenityDescriptions = [
            'Swimming Pool'      => 'Private infinity pool',
            'Free WiFi'           => 'High-speed internet',
            'Breakfast Included' => 'Daily gourmet breakfast',
            'Free Parking'       => 'Secure private parking',
            'Spa Service'        => 'On-site massage therapy',
            'Concierge'          => '24/7 guest services',
        ];

        $data = [
            'id'                => $place->id,
            'name'              => $place->name,
            'price'             => $place->price,
            'rating'            => $place->rating,
            'description'       => $place->description,

            'destination'       => [
                'id'    => $place->destination->id,
                'type'  => $place->destination->destinationType->name,
                'city'  => $place->destination->city->name,
                'country' => $place->destination->city->country->name,
            ],

            'amenities' => $place->amenities
                ->map(fn($amenity) => ['id' => $amenity->id, 'name' => $amenity->name])
                ->all(),
        ];

        return view('single-place', compact('place', 'amenityIcons', 'amenityDescriptions'));
    }
    
}
