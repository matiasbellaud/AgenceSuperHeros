<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\CityController;
use App\Http\Controllers\API\GadgetController;
use App\Http\Controllers\API\HeroController;
use App\Http\Controllers\API\HerosCityController;
use App\Http\Controllers\API\HerosGadgetController;
use App\Http\Controllers\API\HerosPowerController;
use App\Http\Controllers\API\HerosTeamController;
use App\Http\Controllers\API\PlanetController;
use App\Http\Controllers\API\PowerController;
use App\Http\Controllers\API\SuperPowerController;
use App\Http\Controllers\API\TeamController;
use App\Http\Controllers\API\VehicleController;
use App\Http\Controllers\API\UserController;

Route::apiresource('users', UserController::class);
Route::apiresource('heros', HeroController::class);
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

Route::get('/vehicles/showName/{t}', [VehicleController::class, 'showName']);
