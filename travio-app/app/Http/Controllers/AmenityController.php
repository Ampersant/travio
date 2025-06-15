<?php

namespace App\Http\Controllers;

use App\Models\Amenity;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AmenityController extends Controller
{
    public function all(): JsonResponse
    {
        $amenities = Amenity::all()->map(fn($amenity) => [
            'id' => $amenity->id,
            'name' => $amenity->name,
        ]);
        return response()->json($amenities);
    }
}
