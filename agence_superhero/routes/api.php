<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\FilmController;
use App\Http\Controllers\API\CategoryController;

Route::apiresource('categories', CategoryController::class);
Route::apiresource('films', FilmController::class);

// Route::get('/categorie/coucou/{t}', [CategorieCont::class, 'coucou']);
