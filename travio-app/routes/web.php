<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\FriendshipController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\PlannerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RenderController;
use App\Http\Controllers\TripController;
use Illuminate\Support\Facades\Route;

Route::get('/', [RenderController::class, 'index'])->name('index');
Route::get('/search', function () {
    return view('searchtrips');
})->name('search');
Route::get('/places/{id}', [PlaceController::class, 'show'])->name('places.show');

Route::middleware(['auth'])->group(function () {
    Route::get('/friends', [FriendshipController::class, 'index'])->name('friends.index');

    Route::get('/trips', [TripController::class, 'index'])->name('trips.index');
    Route::post('/trip/confirm', [TripController::class, 'confirm'])->name('trip.confirm');

    Route::get('/profile/{userId}', [ProfileController::class, 'show'])->name('profile.show');

    Route::get('/chats', [ChatController::class, 'index'])->name('chats.index');
    Route::get('/chats/{chat}', [ChatController::class, 'show'])->name('chats.show');
    Route::post('/chats/{chat}/message', [ChatController::class, 'sendMessage'])->name('chats.message.send');
    Route::get('/chats/{chat}/messages', [ChatController::class, 'messages']);

    Route::get('/planner/{tripId}', [PlannerController::class, 'show'])->name('planner.show');

});
require __DIR__ . '/auth.php';
require __DIR__ . '/api.php';
