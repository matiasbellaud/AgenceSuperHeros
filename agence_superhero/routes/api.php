<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\HeroController;

Route::apiresource('heros', HeroController::class);
Route::post('/post/getHeroesByUser', [HeroController::class, 'getHeroesByUser']);

// Route::get('/vehicles/showName/{t}', [VehicleController::class, 'showName']);
