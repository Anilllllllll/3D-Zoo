<?php

namespace App\Http\Controllers;

use App\Models\Habitat;

/**
 * HabitatController - ZooSphere
 * Displays habitat pages with their associated animals
 */
class HabitatController extends Controller
{
    /**
     * Display all habitats
     */
    public function index()
    {
        $habitats = Habitat::withCount('animals')->get();
        return view('habitats.index', compact('habitats'));
    }

    /**
     * Display a specific habitat with its animals
     */
    public function show(Habitat $habitat)
    {
        $habitat->load('animals');
        return view('habitats.show', compact('habitat'));
    }
}
