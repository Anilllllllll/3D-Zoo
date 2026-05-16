<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Habitat;
use Illuminate\Http\Request;

/**
 * AnimalController - ZooSphere
 * Full CRUD for animal management + public directory and detail pages
 */
class AnimalController extends Controller
{
    /**
     * Display the animal directory with search and filter
     */
    public function index(Request $request)
    {
        $query = Animal::with('habitat');

        // Search filter
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('species', 'like', '%' . $request->search . '%');
        }

        // Habitat filter
        if ($request->has('habitat') && $request->habitat) {
            $query->where('habitat_id', $request->habitat);
        }

        // Category filter
        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }

        // Diet filter
        if ($request->has('diet') && $request->diet) {
            $query->where('diet', $request->diet);
        }

        $animals = $query->orderBy('name')->paginate(12);
        $habitats = Habitat::all();
        $categories = Animal::distinct()->pluck('category');
        $diets = Animal::distinct()->pluck('diet');

        return view('animals.index', compact('animals', 'habitats', 'categories', 'diets'));
    }

    /**
     * Display individual animal profile page
     */
    public function show(Animal $animal)
    {
        // Increment views count
        $animal->increment('views_count');
        $animal->load('habitat');

        $relatedAnimals = $animal->relatedAnimals(4);

        // Check if current user has favorited this animal
        $isFavorited = false;
        if (auth()->check()) {
            $isFavorited = auth()->user()->favorites()->where('animal_id', $animal->id)->exists();
        }

        return view('animals.show', compact('animal', 'relatedAnimals', 'isFavorited'));
    }
}
