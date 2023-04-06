<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'birthdate',
        'email',
        'password',
    ];

    public function pokemonPreferences()
    {
        return $this->hasMany(UserPokemon::class);
    }

    public function favoritePokemons()
    {
        return $this->pokemonPreferences()->where('action', 'favorite')->get();
    }

    public function likedPokemons()
    {
        return $this->pokemonPreferences()->where('action', 'like')->get();
    }

    public function hatedPokemons()
    {
        return $this->pokemonPreferences()->where('action', 'hate')->get();
    }

    public function removePokemon($name)
    {
        // Remove the Pokemon from the user's likes
        if ($this->likedPokemons()->where('pokemon', $name)->count()) {
            $this->likedPokemons()->where('pokemon', $name)->first()->delete();
        }

        // Remove the Pokemon from the user's hates
        if ($this->hatedPokemons()->where('pokemon', $name)->count()) {
            $this->hatedPokemons()->where('pokemon', $name)->first()->delete();
        }

        // Remove the Pokemon from the user's favorites
        if ($this->favoritePokemons()->where('pokemon', $name)->count()) {
            $this->favoritePokemons()->where('pokemon', $name)->first()->delete();
        }
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
