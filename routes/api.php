<?php

use App\Http\Controllers\PokemonController;
use App\Http\Controllers\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    // Get all pokemons thru pokeAPI, through controller to avoid CORS. 
    Route::get('/pokemon/', [PokemonController::class, 'getPokemons']);

    // Get all users with their pokemon preferences
    Route::get('/users/pokemon-preferences', [UsersController::class, 'index']);

    // Like/Fav/Hate pokemon
    Route::post('/users/pokemon/preference', [PokemonController::class, 'store']);

    //Remove specific
    Route::delete('/users/pokemon/{name}', [PokemonController::class, 'remove']);
});
