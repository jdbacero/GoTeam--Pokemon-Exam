<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    //
    protected $model = User::class;
    public function index()
    {
        $users = User::with('pokemonPreferences')->get();

        return response()->json($users);
    }

    // Currently logged-in user's preference pokemon.
    public function auth_user_pokemon()
    {
        $user = Auth::user();
        $userWithPokemon = User::with(['pokemonPreferences.pokemon'])->find($user->id);

        return $userWithPokemon;
    }
}
