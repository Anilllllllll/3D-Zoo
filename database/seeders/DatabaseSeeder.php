<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * DatabaseSeeder - ZooSphere
 * Orchestrates all seeders in the correct order
 */
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            HabitatSeeder::class,
            AnimalSeeder::class,
            OceanAnimalSeeder::class,
            ArcticAnimalSeeder::class,
            SavannahAnimalSeeder::class,
            QuizSeeder::class,
        ]);
    }
}
