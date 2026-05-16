<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Animal Model - ZooSphere
 * Represents individual animal profiles in the virtual zoo
 */
class Animal extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'species',
        'scientific_name',
        'category',
        'habitat_id',
        'diet',
        'lifespan',
        'conservation_status',
        'description',
        'image',
        'gallery',
        'sound',
        'fun_facts',
        'weight',
        'height',
        'speed',
        'views_count',
    ];

    /**
     * Cast JSON fields to arrays
     */
    protected function casts(): array
    {
        return [
            'gallery' => 'array',
            'fun_facts' => 'array',
        ];
    }

    /**
     * Get the habitat this animal belongs to
     * Animal belongsTo Habitat
     */
    public function habitat()
    {
        return $this->belongsTo(Habitat::class);
    }

    /**
     * Get users who favorited this animal
     */
    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }

    /**
     * Get related animals (same habitat, excluding self)
     */
    public function relatedAnimals($limit = 4)
    {
        return self::where('habitat_id', $this->habitat_id)
            ->where('id', '!=', $this->id)
            ->limit($limit)
            ->get();
    }
}
