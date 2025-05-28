<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function show(Country $country): JsonResponse
    {
        $cities = $country->cities->map(fn($city) => [
            'id'   => $city->id,
            'name' => $city->name,
        ]);

        return response()->json($cities);
    }
}
