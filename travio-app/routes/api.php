<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\FriendshipController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\PlannerController;
use Illuminate\Support\Facades\Route;

Route::get('/places', [PlaceController::class, 'all'])->name('api.places.all');
Route::get('/countries/all', [CountryController::class, 'all'])->name('api.countries.all');
Route::get('/countries/{country}/cities', [CityController::class, 'show'])->name('api.city.get');

Route::prefix('api')->group(function () {
    Route::post('/friends/request/{id}', [FriendshipController::class, 'sendRequest']);
    Route::post('/friends/respond/', [FriendshipController::class, 'respondRequest']);
    Route::get('/friends/all', [FriendshipController::class, 'allFriends']);

    Route::get('/planner', [PlannerController::class, 'index']);
    Route::post('/planner', [PlannerController::class, 'store']);
    Route::put('/planner/{destination}', [PlannerController::class, 'update']);
    Route::delete('/planner/{destination}', [PlannerController::class, 'destroy']);
});
