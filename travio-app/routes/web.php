<?php

use App\Http\Controllers\RenderController;
use Illuminate\Support\Facades\Route;

Route::get('/', [RenderController::class, 'index']);
