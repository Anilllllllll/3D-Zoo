<?php

namespace Database\Seeders;

use App\Models\Habitat;
use Illuminate\Database\Seeder;

/**
 * HabitatSeeder - ZooSphere
 * Seeds 5 wildlife habitats with descriptions and metadata
 */
class HabitatSeeder extends Seeder
{
    public function run(): void
    {
        $habitats = [
            [
                'name' => 'Forest',
                'slug' => 'forest',
                'description' => 'Dense, lush forests teeming with biodiversity. From tropical rainforests to temperate woodlands, these habitats are home to some of the most diverse ecosystems on Earth, harboring countless species of mammals, birds, reptiles, and insects.',
                'image' => 'https://images.unsplash.com/photo-1448375240586-882707db888b?w=800',
                'climate' => 'Tropical to Temperate',
                'region' => 'Global',
                'icon' => '🌲',
            ],
            [
                'name' => 'Desert',
                'slug' => 'desert',
                'description' => 'Vast, arid landscapes where only the toughest creatures survive. Deserts cover about one-third of the Earth\'s land surface, featuring extreme temperatures and unique adaptations that make their inhabitants truly remarkable survivors.',
                'image' => 'https://images.unsplash.com/photo-1509316785289-025f5b846b35?w=800',
                'climate' => 'Arid and Hot',
                'region' => 'Africa, Asia, Americas',
                'icon' => '🏜️',
            ],
            [
                'name' => 'Ocean',
                'slug' => 'ocean',
                'description' => 'The vast blue realm covering over 70% of our planet. Oceans are home to the largest animals ever known to exist, from magnificent whales to playful dolphins, and from colorful coral reefs to the mysterious deep-sea creatures.',
                'image' => 'https://images.unsplash.com/photo-1518837695005-2083093ee35b?w=800',
                'climate' => 'Marine',
                'region' => 'Global Oceans',
                'icon' => '🌊',
            ],
            [
                'name' => 'Arctic',
                'slug' => 'arctic',
                'description' => 'The frozen frontier at the top of the world. The Arctic is a harsh yet beautiful environment where polar bears roam, penguins waddle, and seals bask on ice floes. These cold-adapted species have evolved incredible survival strategies.',
                'image' => 'https://images.unsplash.com/photo-1551415923-a2297c7fda79?w=800',
                'climate' => 'Polar and Cold',
                'region' => 'Arctic and Antarctic',
                'icon' => '❄️',
            ],
            [
                'name' => 'Savannah',
                'slug' => 'savannah',
                'description' => 'Expansive grasslands stretching to the horizon. The African savannah is the stage for nature\'s greatest spectacles — the Great Migration, lion prides on the hunt, and herds of elephants silhouetted against stunning sunsets.',
                'image' => 'https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?w=800',
                'climate' => 'Tropical Grassland',
                'region' => 'Africa, South America',
                'icon' => '🌾',
            ],
        ];

        foreach ($habitats as $habitat) {
            Habitat::create($habitat);
        }
    }
}
