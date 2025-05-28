<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function all(): JsonResponse
    {
        $countries = Country::all()->map(fn($country) => [
            'id'   => $country->id,
            'name' => $country->name,
        ]);

        return response()->json($countries);
    }
}
