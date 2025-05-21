<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\PlaceController;
use Illuminate\Support\Facades\Route;

Route::get('/places/all', [PlaceController::class, 'all'])->name('api.places.all');
Route::get('/countries/all', [CountryController::class, 'all'])->name('api.countries.all');
Route::get('/countries/{country}/cities', [CityController::class, 'show'])->name('api.city.get');