<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\TripPlace;
use Illuminate\Http\Request;

class PlannerController extends Controller
{
    public function index()
    {
        $dests = TripPlace::all();
        // dd($dests);
        return response()->json($dests);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'price' => 'required|numeric|min:0',
            'shares' => 'required|array'
        ]);

        return TripPlace::create($validated);
    }

    public function update(Request $request, TripPlace $destination)                    
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'check_in' => 'sometimes|date',
            'check_out' => 'sometimes|date|after:check_in',
            'price' => 'sometimes|numeric|min:0',
            'shares' => 'sometimes|array'
        ]);

        $destination->update($validated);
        return $destination;
    }

    public function destroy(TripPlace $destination)
    {
        $destination->delete();
        return response()->noContent();
    }
    
    public function show($tripId) 
    {
        $trip = Trip::with(['places', 'users'])->findOrFail($tripId);

        // dd($trip);
        return view('planner', compact('trip'));
    }
}
