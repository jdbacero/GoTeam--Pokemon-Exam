<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPokemon extends Model
{
    use HasFactory;
    protected $fillable = [
        'pokemon',
        'action',
    ];
    public function user()
    {
        return $this->belongsToMany(User::class);
    }
}
