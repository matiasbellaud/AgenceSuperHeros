<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\HeroController;
use App\Http\Controllers\API\UserController;

// Route::apiresource('heros', HeroController::class);
Route::post('/post/getHeroesByUser', [HeroController::class, 'getHeroesByUser']);
Route::post('/post/createHero', [HeroController::class, 'store']);
Route::post('/post/deleteHeroById', [HeroController::class, 'deleteHeroById']);

Route::post('/post/register', [UserController::class, 'register']);
Route::post('/post/login', [UserController::class, 'login']);

// Route::get('/vehicles/showName/{t}', [VehicleController::class, 'showName']);
