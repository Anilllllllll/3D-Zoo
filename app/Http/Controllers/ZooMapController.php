<?php

namespace App\Http\Controllers;

use App\Models\Animal;

/**
 * ZooMapController - ZooSphere
 * Handles the interactive virtual zoo map page
 */
class ZooMapController extends Controller
{
    /**
     * Display the interactive zoo map
     */
    public function index()
    {
        $zones = [
            [
                'name' => 'Safari Zone',
                'slug' => 'safari',
                'icon' => '🦁',
                'description' => 'Experience the wild savannah animals up close',
                'color' => '#D4A853',
                'animals' => Animal::whereIn('category', ['Mammal'])->whereIn('habitat_id', [5])->get(),
            ],
            [
                'name' => 'Bird House',
                'slug' => 'bird-house',
                'icon' => '🦅',
                'description' => 'Discover magnificent birds from around the world',
                'color' => '#5B9BD5',
                'animals' => Animal::where('category', 'Bird')->get(),
            ],
            [
                'name' => 'Aquarium',
                'slug' => 'aquarium',
                'icon' => '🐬',
                'description' => 'Dive into the underwater world of marine life',
                'color' => '#00BCD4',
                'animals' => Animal::where('habitat_id', 3)->get(),
            ],
            [
                'name' => 'Reptile Zone',
                'slug' => 'reptile',
                'icon' => '🐊',
                'description' => 'Meet ancient reptilian creatures',
                'color' => '#4CAF50',
                'animals' => Animal::where('category', 'Reptile')->get(),
            ],
            [
                'name' => 'Jungle Trail',
                'slug' => 'jungle',
                'icon' => '🐅',
                'description' => 'Trek through dense forest habitats',
                'color' => '#2E7D32',
                'animals' => Animal::where('habitat_id', 1)->get(),
            ],
            [
                'name' => 'Arctic Exhibit',
                'slug' => 'arctic',
                'icon' => '🐧',
                'description' => 'Explore the frozen world of arctic animals',
                'color' => '#B3E5FC',
                'animals' => Animal::where('habitat_id', 4)->get(),
            ],
        ];

        return view('zoo-map', compact('zones'));
    }
}
