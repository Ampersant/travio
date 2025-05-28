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
Route::post('/api/friends/request/{id}', [FriendshipController::class, 'sendRequest']);
Route::post('/api/friends/respond/', [FriendshipController::class, 'respondRequest']);
Route::get('/api/friends/all', [FriendshipController::class, 'allFriends']);
// planner
Route::get('/api/planner', [PlannerController::class, 'index']);
Route::post('/api/planner', [PlannerController::class, 'store']);
Route::put('/api/planner/{destination}', [PlannerController::class, 'update']);
Route::delete('/api/planner/{destination}', [PlannerController::class, 'destroy']);
