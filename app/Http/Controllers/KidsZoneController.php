<?php

namespace App\Http\Controllers;

/**
 * KidsZoneController - ZooSphere
 * Educational games and interactive content for kids
 */
class KidsZoneController extends Controller
{
    /**
     * Display the kids zone with games
     */
    public function index()
    {
        // Animal data for "Guess the Animal" game
        $gameAnimals = [
            ['name' => 'Lion', 'emoji' => '🦁', 'hint' => 'I am the king of the jungle with a majestic mane', 'image' => 'https://images.unsplash.com/photo-1546182990-dffeafbe841d?w=400'],
            ['name' => 'Elephant', 'emoji' => '🐘', 'hint' => 'I am the largest land animal with a long trunk', 'image' => 'https://images.unsplash.com/photo-1557050543-4d5f4e07ef46?w=400'],
            ['name' => 'Penguin', 'emoji' => '🐧', 'hint' => 'I waddle on ice and swim in freezing waters', 'image' => 'https://images.unsplash.com/photo-1551986782-d0169b3f8fa7?w=400'],
            ['name' => 'Tiger', 'emoji' => '🐅', 'hint' => 'I have distinctive orange and black stripes', 'image' => 'https://images.unsplash.com/photo-1561731216-c3a4d4b6d164?w=400'],
            ['name' => 'Dolphin', 'emoji' => '🐬', 'hint' => 'I am an intelligent marine mammal known for jumping', 'image' => 'https://images.unsplash.com/photo-1607153333879-c174d265f1d2?w=400'],
            ['name' => 'Giraffe', 'emoji' => '🦒', 'hint' => 'I am the tallest animal, I love eating leaves from trees', 'image' => 'https://images.unsplash.com/photo-1547721064-da6cfb341d50?w=400'],
            ['name' => 'Owl', 'emoji' => '🦉', 'hint' => 'I can rotate my head 270 degrees and hunt at night', 'image' => 'https://images.unsplash.com/photo-1543549790-8b5f4a028cfb?w=400'],
            ['name' => 'Panda', 'emoji' => '🐼', 'hint' => 'I am black and white and love eating bamboo', 'image' => 'https://images.unsplash.com/photo-1564349683136-77e08dba1ef7?w=400'],
        ];

        // Animal matching game pairs
        $matchingPairs = [
            ['animal' => 'Lion', 'emoji' => '🦁', 'match' => 'Savannah'],
            ['animal' => 'Penguin', 'emoji' => '🐧', 'match' => 'Arctic'],
            ['animal' => 'Dolphin', 'emoji' => '🐬', 'match' => 'Ocean'],
            ['animal' => 'Tiger', 'emoji' => '🐅', 'match' => 'Forest'],
            ['animal' => 'Camel', 'emoji' => '🐫', 'match' => 'Desert'],
            ['animal' => 'Panda', 'emoji' => '🐼', 'match' => 'Forest'],
        ];

        return view('kids-zone', compact('gameAnimals', 'matchingPairs'));
    }
}
