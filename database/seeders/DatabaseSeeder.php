<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        $users = User::get();

        foreach ($users as $user) {
            \App\Models\UserPokemon::factory(3)->create([
                'user_id' => $user->id,
                'action' => 'like'
            ]);
            \App\Models\UserPokemon::factory(3)->create([
                'user_id' => $user->id,
                'action' => 'hate'
            ]);
            \App\Models\UserPokemon::factory(1)->create([
                'user_id' => $user->id,
                'action' => 'favorite'
            ]);
        }
    }
}
