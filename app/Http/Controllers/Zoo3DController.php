<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Habitat;

class Zoo3DController extends Controller
{
    public function index()
    {
        $animals = Animal::with('habitat')->get();
        $habitats = Habitat::withCount('animals')->get();

        return view('zoo3d', compact('animals', 'habitats'));
    }
}
