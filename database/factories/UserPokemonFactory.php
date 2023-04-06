<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserPokemon>
 */
class UserPokemonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Get all user IDs
        $userIds = User::pluck('id')->toArray();

        return [
            'pokemon' => $this->randomPokemon(),
            'user_id' => $this->faker->randomElement($userIds),
            'action' => $this->faker->randomElement(['like', 'hate', 'favorite'])
        ];
    }

    public function randomPokemon(): string
    {
        $rand = mt_rand(1, 1015);
        $response = Http::get('https://pokeapi.co/api/v2/pokemon/' . $rand);
        return $response->json()['name'];
    }
}
