<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Habitat Model - ZooSphere
 * Represents wildlife habitats (Forest, Desert, Ocean, Arctic, Savannah)
 */
class Habitat extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'climate',
        'region',
        'icon',
    ];

    /**
     * Get all animals belonging to this habitat
     * One habitat hasMany animals
     */
    public function animals()
    {
        return $this->hasMany(Animal::class);
    }
}
