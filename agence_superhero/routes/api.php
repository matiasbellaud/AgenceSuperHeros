<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\CityController;
use App\Http\Controllers\API\GadgetController;
use App\Http\Controllers\API\HerosCityController;
use App\Http\Controllers\API\HerosGadgetController;
use App\Http\Controllers\API\HerosPowerController;
use App\Http\Controllers\API\HerosTeamController;
use App\Http\Controllers\API\PlanetController;
use App\Http\Controllers\API\PowerController;
use App\Http\Controllers\API\SuperPowerController;
use App\Http\Controllers\API\TeamController;
use App\Http\Controllers\API\VehicleController;

Route::apiresource('cities', CityController::class);
Route::apiresource('gadgets', GadgetController::class);
Route::apiresource('heros_cities', HerosCityController::class);
Route::apiresource('heros_gadgets', HerosGadgetController::class);
Route::apiresource('heros_powers', HerosPowerController::class);
Route::apiresource('heros_teams', HerosTeamController::class);
Route::apiresource('planets', PlanetController::class);
Route::apiresource('powers', PowerController::class);
Route::apiresource('super_powers', SuperPowerController::class);
Route::apiresource('teams', TeamController::class);
Route::apiresource('vehicles', VehicleController::class);

// use App\Http\Controllers\API\FilmController;
// use App\Http\Controllers\API\CategoryController;

// Route::apiresource('categories', CategoryController::class);
// Route::apiresource('films', FilmController::class);

// // Route::get('/categorie/coucou/{t}', [CategorieCont::class, 'coucou']);
