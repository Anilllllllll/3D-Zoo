<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Favorite Model - ZooSphere
 * Pivot model for user-animal favorites relationship
 */
class Favorite extends Model
{
    protected $fillable = [
        'user_id',
        'animal_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }
}
