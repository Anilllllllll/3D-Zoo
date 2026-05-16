<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Habitat;
use App\Models\User;

/**
 * HomeController - ZooSphere
 * Handles the main landing page with featured content and statistics
 */
class HomeController extends Controller
{
    /**
     * Display the homepage with featured animals, habitats, and stats
     */
    public function index()
    {
        $featuredAnimals = Animal::with('habitat')
            ->orderBy('views_count', 'desc')
            ->limit(6)
            ->get();

        $habitats = Habitat::withCount('animals')->get();

        $stats = [
            'animals' => Animal::count(),
            'habitats' => Habitat::count(),
            'users' => User::count(),
            'species' => Animal::distinct('species')->count(),
        ];

        return view('home', compact('featuredAnimals', 'habitats', 'stats'));
    }
}
