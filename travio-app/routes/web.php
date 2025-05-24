<?php

use App\Http\Controllers\FriendshipController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\RenderController;
use App\Http\Controllers\TripController;
use Illuminate\Support\Facades\Route;

Route::get('/', [RenderController::class, 'index'])->name('index');
Route::get('/search', function () {
    return view('searchtrips');
});
Route::get('/searchtss', function () {
    return view('searchtss');
});
Route::get('/profile', function () {
    return view('profile');
});
Route::get('/chat', function () {
    return view('chat');
});
Route::get('/modal', function () { 
    return view('modal');
});
Route::get('/connections', function () {
    return view('connections');
});
Route::get('/places/{id}', [PlaceController::class, 'show'])->name('places.show');
Route::post('/trip/confirm', [TripController::class, 'confirm'])
    ->middleware('auth')
    ->name('trip.confirm');
Route::middleware(['auth'])->group(function () {
    Route::get('/friends', [FriendshipController::class, 'index'])->name('friends.index');
});
require __DIR__ . '/auth.php';
require __DIR__ . '/api.php';
