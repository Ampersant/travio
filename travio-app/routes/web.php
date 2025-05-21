<?php

use App\Http\Controllers\RenderController;
use Illuminate\Support\Facades\Route;

Route::get('/', [RenderController::class, 'index'])->name('index');
Route::get('/search', function(){
    return view('searchtrips');
});
Route::get('/searchtss', function(){
    return view('searchtss');
});
Route::get('/profile', function(){
    return view('profile');
});
Route::get('/chat', function(){
    return view('chat');
});


require __DIR__.'/auth.php';
require __DIR__.'/api.php';
