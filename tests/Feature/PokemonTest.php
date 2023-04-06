<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\User;
use Tests\TestCase;

class PokemonTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_liking_a_pokemon(): void
    {
        $user = User::factory()->create();

        $user->pokemonPreferences()->create(['pokemon' => 'Bulbasaur', 'user_id' => $user->id, 'action' => 'like']);

        $this->assertDatabaseHas('user_pokemon', [
            'pokemon' => 'Bulbasaur',
            'user_id' => $user->id,
            'action' => 'like'
        ]);
    }
    public function test_hating_a_pokemon(): void
    {
        $user = User::factory()->create();

        $user->pokemonPreferences()->create(['pokemon' => 'Bulbasaur', 'user_id' => $user->id, 'action' => 'hate']);

        $this->assertDatabaseHas('user_pokemon', [
            'pokemon' => 'Bulbasaur',
            'user_id' => $user->id,
            'action' => 'hate'
        ]);
    }

    public function test_favorite_a_pokemon(): void
    {
        $user = User::factory()->create();

        $user->pokemonPreferences()->create(['pokemon' => 'Bulbasaur', 'user_id' => $user->id, 'action' => 'favorite']);

        $this->assertDatabaseHas('user_pokemon', [
            'pokemon' => 'Bulbasaur',
            'user_id' => $user->id,
            'action' => 'favorite'
        ]);
    }

    public function test_having_more_than_three_likes(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $user->pokemonPreferences()->create(['pokemon' => 'Bulbasaur', 'user_id' => $user->id, 'action' => 'like']);
        $user->pokemonPreferences()->create(['pokemon' => 'Charmander', 'user_id' => $user->id, 'action' => 'like']);
        $user->pokemonPreferences()->create(['pokemon' => 'Ivysaur', 'user_id' => $user->id, 'action' => 'like']);

        $response = $this->post('/api/users/pokemon/preference', ['pokemon' => "Charizard", "action" => 'like']);
        $response->assertStatus(400);
    }

    public function test_having_more_than_three_hates(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $user->pokemonPreferences()->create(['pokemon' => 'Bulbasaur', 'user_id' => $user->id, 'action' => 'hate']);
        $user->pokemonPreferences()->create(['pokemon' => 'Charmander', 'user_id' => $user->id, 'action' => 'hate']);
        $user->pokemonPreferences()->create(['pokemon' => 'Ivysaur', 'user_id' => $user->id, 'action' => 'hate']);

        $response = $this->post('/api/users/pokemon/preference', ['pokemon' => "Charizard", "action" => 'hate']);
        $response->assertStatus(400);
    }

    public function test_having_more_than_one_favorite(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $user->pokemonPreferences()->create(['pokemon' => 'Bulbasaur', 'user_id' => $user->id, 'action' => 'favorite']);
        $response = $this->post('/api/users/pokemon/preference', ['pokemon' => "Charizard", "action" => 'favorite']);
        $response->assertStatus(400);
    }
}
