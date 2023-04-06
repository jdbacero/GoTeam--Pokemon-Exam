<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserPokemon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;
use Inertia\Response;

class PokemonController extends Controller
{
    /**
     * The model to use in this controller.
     *
     * @var string
     */
    protected $model = UserPokemon::class;
    //
    public function list()
    {
        return Inertia::render('Pokemon/List');
    }
    public function store(Request $request)
    {
        $user = Auth::user();

        $validatedData = $request->validate([
            'pokemon' => 'required|string',
            'action' => 'required|string|in:like,hate,favorite',
        ]);

        // dd($validatedData);
        $pokemon = $validatedData['pokemon'];
        $action = $validatedData['action'];

        $existingPokemon = $user->pokemonPreferences()->where('pokemon', $pokemon)->first();

        if ($user->pokemonPreferences()->where('action', $action)->count() >= 3) {
            return response()->json(['message' => 'Cannot add more than 3 ' . $action . 'd pokemon'], 400);
        }
        if ($action == 'favorite' && $user->pokemonPreferences()->where('action', $action)->count() > 0) {
            return response()->json(['message' => 'You already have a favorite pokemon.'], 400);
        }

        if ($existingPokemon) {
            if ($existingPokemon->action === $action) {
                return response()->json(['message' => 'You have already ' . $action . 'd this pokemon.']);
            }

            $existingPokemon->action = $action;
            $existingPokemon->save();

            return response()->json(['message' => 'Pokemon ' . $pokemon . ' is now ' . $action . 'd.'], 201);
        }

        // Check if Pokemon already exists in another action
        $existingAction = $user->pokemonPreferences()->where('pokemon', $pokemon)
            ->whereIn('action', array_diff(['like', 'hate'], [$action]))
            ->first();

        if ($existingAction) {
            // If Pokemon already exists in another action, remove it
            $existingAction->delete();
        }

        // Create or update Pokemon preference
        $user->pokemonPreferences()->updateOrCreate(
            ['pokemon' => $pokemon],
            ['action' => $action]
        );

        // $user->pokemonPreferences()->create($validatedData);

        return response()->json(['message' => 'Pokemon ' . $action .  ' successfully'], 201);
    }

    // Get all pokemon. Being done in Controller instead of vue services to avoid CORS errors.
    public function getPokemons()
    {
        $url = "https://pokeapi.co/api/v2/pokemon/?limit=10000";
        $response = Http::get($url);
        if ($response->successful()) {
            return $response->json();
        } else {
            return null;
        }
    }

    public function remove($name)
    {
        // dd($name);
        $user = Auth::user();

        // Remove the Pokemon from the user's likes/hates/favorites
        $user->removePokemon($name);

        return response()->json(['message' => 'Pokemon deleted successfully.'], 201);
    }
}
