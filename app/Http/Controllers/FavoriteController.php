<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;

/**
 * FavoriteController - ZooSphere
 * Handles user's favorite animals list
 */
class FavoriteController extends Controller
{
    /**
     * Display user's favorites page
     */
    public function index()
    {
        $favorites = auth()->user()->favorites()->with('habitat')->get();
        return view('favorites.index', compact('favorites'));
    }

    /**
     * Toggle favorite status for an animal (AJAX)
     */
    public function toggle(Request $request)
    {
        $request->validate([
            'animal_id' => 'required|exists:animals,id',
        ]);

        $user = auth()->user();
        $animalId = $request->animal_id;

        $existing = Favorite::where('user_id', $user->id)
            ->where('animal_id', $animalId)
            ->first();

        if ($existing) {
            $existing->delete();
            $status = 'removed';
        } else {
            Favorite::create([
                'user_id' => $user->id,
                'animal_id' => $animalId,
            ]);
            $status = 'added';
        }

        return response()->json([
            'status' => $status,
            'message' => $status === 'added' ? 'Added to favorites!' : 'Removed from favorites!',
        ]);
    }
}
