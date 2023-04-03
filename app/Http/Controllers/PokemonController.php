<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PokemonController extends Controller
{
    //
    public function list()
    {
        return Inertia::render('Pokemon/List');
    }
}
