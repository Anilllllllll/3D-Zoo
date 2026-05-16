<?php

namespace Database\Seeders;

use App\Models\Animal;
use Illuminate\Database\Seeder;

class DesertAnimalSeeder extends Seeder
{
    public function run(): void
    {
        $animals = [
            [
                'name' => 'Dromedary Camel', 'species' => 'Dromedary Camel', 'scientific_name' => 'Camelus dromedarius',
                'category' => 'Mammal', 'habitat_id' => 2, 'diet' => 'Herbivore', 'lifespan' => '40-50 years',
                'conservation_status' => 'Domesticated',
                'description' => 'The dromedary camel, also known as the Arabian camel, is perfectly adapted to desert life. With a single hump storing fat reserves, broad feet for walking on sand, and the ability to go weeks without water, it is the ultimate desert survivor.',
                'image' => '/images/animals/camel-1.jpg',
                'gallery' => json_encode(['/images/animals/camel-1.jpg', '/images/animals/camel-2.jpg']),
                'fun_facts' => json_encode(['Camels can drink 200 liters of water in 3 minutes.', 'Their humps store fat, not water.', 'They can close their nostrils to keep out sand.']),
                'weight' => '600 kg', 'height' => '1.85 m', 'speed' => '65 km/h',
            ],
            [
                'name' => 'Fennec Fox', 'species' => 'Fennec Fox', 'scientific_name' => 'Vulpes zerda',
                'category' => 'Mammal', 'habitat_id' => 2, 'diet' => 'Omnivore', 'lifespan' => '10-14 years',
                'conservation_status' => 'Least Concern',
                'description' => 'The fennec fox is the smallest fox in the world, famous for its enormous bat-like ears. Native to the Sahara Desert, its oversized ears help dissipate heat and detect prey moving underground.',
                'image' => '/images/animals/fennec-fox-1.jpg',
                'gallery' => json_encode(['/images/animals/fennec-fox-1.jpg', '/images/animals/fennec-fox-2.jpg']),
                'fun_facts' => json_encode(['Their ears can be 15 cm long — half their body length!', 'They can go indefinitely without drinking water.', 'Fennec foxes purr like cats when happy.']),
                'weight' => '1.5 kg', 'height' => '0.2 m', 'speed' => '40 km/h',
            ],
            [
                'name' => 'Sidewinder Rattlesnake', 'species' => 'Sidewinder', 'scientific_name' => 'Crotalus cerastes',
                'category' => 'Reptile', 'habitat_id' => 2, 'diet' => 'Carnivore', 'lifespan' => '20-30 years',
                'conservation_status' => 'Least Concern',
                'description' => 'The sidewinder rattlesnake is a venomous pit viper famous for its unique sideways locomotion across hot desert sands. This specialized movement minimizes contact with the scorching ground and provides excellent traction on loose sand.',
                'image' => '/images/animals/rattlesnake-1.jpg',
                'gallery' => json_encode(['/images/animals/rattlesnake-1.jpg', '/images/animals/rattlesnake-2.jpg']),
                'fun_facts' => json_encode(['They move sideways to reduce contact with hot sand.', 'Their rattle gains a new segment each time they shed.', 'They have heat-sensing pits to detect warm-blooded prey in the dark.']),
                'weight' => '0.3 kg', 'height' => '0.8 m (length)', 'speed' => '29 km/h',
            ],
            [
                'name' => 'Emperor Scorpion', 'species' => 'Emperor Scorpion', 'scientific_name' => 'Pandinus imperator',
                'category' => 'Invertebrate', 'habitat_id' => 2, 'diet' => 'Carnivore', 'lifespan' => '6-8 years',
                'conservation_status' => 'Least Concern',
                'description' => 'The emperor scorpion is one of the largest scorpions in the world, reaching up to 20 cm in length. Despite its fearsome appearance, its venom is relatively mild. It glows a brilliant blue-green under ultraviolet light.',
                'image' => '/images/animals/scorpion-1.jpg',
                'gallery' => json_encode(['/images/animals/scorpion-1.jpg', '/images/animals/scorpion-2.jpg']),
                'fun_facts' => json_encode(['Scorpions glow under UV light.', 'They can survive for a year without food.', 'Scorpions have been around for over 400 million years.']),
                'weight' => '0.03 kg', 'height' => '0.2 m (length)', 'speed' => '19 km/h',
            ],
            [
                'name' => 'Meerkat', 'species' => 'Meerkat', 'scientific_name' => 'Suricata suricatta',
                'category' => 'Mammal', 'habitat_id' => 2, 'diet' => 'Omnivore', 'lifespan' => '12-14 years',
                'conservation_status' => 'Least Concern',
                'description' => 'Meerkats are highly social mongooses that live in groups called "mobs" in the deserts of southern Africa. Famous for their upright sentinel posture, they take turns standing guard while others forage for food.',
                'image' => '/images/animals/meerkat-1.jpg',
                'gallery' => json_encode(['/images/animals/meerkat-1.jpg', '/images/animals/meerkat-2.jpg']),
                'fun_facts' => json_encode(['Meerkats are immune to certain venoms, including scorpion stings.', 'They teach their pups how to eat scorpions by removing the stinger first.', 'A mob can have up to 50 members.']),
                'weight' => '0.73 kg', 'height' => '0.3 m', 'speed' => '32 km/h',
            ],
            [
                'name' => 'Arabian Oryx', 'species' => 'Arabian Oryx', 'scientific_name' => 'Oryx leucoryx',
                'category' => 'Mammal', 'habitat_id' => 2, 'diet' => 'Herbivore', 'lifespan' => '20 years',
                'conservation_status' => 'Vulnerable',
                'description' => 'The Arabian oryx is a majestic antelope that was once extinct in the wild. Thanks to successful breeding programs, it has been reintroduced to the Arabian Peninsula. Its white coat reflects sunlight to stay cool.',
                'image' => '/images/animals/arabian-oryx-1.jpg',
                'gallery' => json_encode(['/images/animals/arabian-oryx-1.jpg', '/images/animals/arabian-oryx-2.jpg']),
                'fun_facts' => json_encode(['They were extinct in the wild by 1972, then successfully reintroduced.', 'They may be the origin of the unicorn legend.', 'They can detect rainfall from 50 miles away.']),
                'weight' => '70 kg', 'height' => '1.0 m', 'speed' => '60 km/h',
            ],
            [
                'name' => 'Gila Monster', 'species' => 'Gila Monster', 'scientific_name' => 'Heloderma suspectum',
                'category' => 'Reptile', 'habitat_id' => 2, 'diet' => 'Carnivore', 'lifespan' => '20-30 years',
                'conservation_status' => 'Near Threatened',
                'description' => 'The Gila monster is one of only a few venomous lizards in the world. Found in the American Southwest, it has striking black and orange bead-like scales. Despite its fearsome reputation, it is slow-moving and rarely encounters humans.',
                'image' => '/images/animals/gila-monster-1.jpg',
                'gallery' => json_encode(['/images/animals/gila-monster-1.jpg', '/images/animals/gila-monster-2.jpg']),
                'fun_facts' => json_encode(['Their venom has led to a diabetes medication.', 'They can eat a third of their body weight in one meal.', 'They store fat in their thick tails.']),
                'weight' => '0.35 kg', 'height' => '0.5 m (length)', 'speed' => '2.4 km/h',
            ],
            [
                'name' => 'Greater Roadrunner', 'species' => 'Greater Roadrunner', 'scientific_name' => 'Geococcyx californianus',
                'category' => 'Bird', 'habitat_id' => 2, 'diet' => 'Omnivore', 'lifespan' => '7-8 years',
                'conservation_status' => 'Least Concern',
                'description' => 'The greater roadrunner is an iconic desert bird of the American Southwest. A member of the cuckoo family, it prefers running to flying and can sprint fast enough to catch and kill rattlesnakes.',
                'image' => '/images/animals/roadrunner-1.jpg',
                'gallery' => json_encode(['/images/animals/roadrunner-1.jpg', '/images/animals/roadrunner-2.jpg']),
                'fun_facts' => json_encode(['They can run up to 26 mph.', 'They kill rattlesnakes by bashing them against rocks.', 'They sunbathe to warm up — they spread their wings and expose dark skin patches.']),
                'weight' => '0.34 kg', 'height' => '0.3 m', 'speed' => '42 km/h',
            ],
            [
                'name' => 'Desert Tortoise', 'species' => 'Mojave Desert Tortoise', 'scientific_name' => 'Gopherus agassizii',
                'category' => 'Reptile', 'habitat_id' => 2, 'diet' => 'Herbivore', 'lifespan' => '80-100 years',
                'conservation_status' => 'Vulnerable',
                'description' => 'The desert tortoise is a resilient reptile that can survive in the harshest desert conditions. They spend up to 95% of their lives in underground burrows to escape extreme heat, and can store water in their bladder for months.',
                'image' => '/images/animals/desert-tortoise-1.jpg',
                'gallery' => json_encode(['/images/animals/desert-tortoise-1.jpg', '/images/animals/desert-tortoise-2.jpg']),
                'fun_facts' => json_encode(['They can live over 100 years.', 'They spend 95% of their life underground.', 'They can store up to a quart of water in their bladder.']),
                'weight' => '5 kg', 'height' => '0.15 m', 'speed' => '0.5 km/h',
            ],
            [
                'name' => 'Sand Cat', 'species' => 'Sand Cat', 'scientific_name' => 'Felis margarita',
                'category' => 'Mammal', 'habitat_id' => 2, 'diet' => 'Carnivore', 'lifespan' => '13 years',
                'conservation_status' => 'Least Concern',
                'description' => 'The sand cat is the only cat species living primarily in true deserts. With fur-covered paws that act as natural snowshoes on sand, and ears set low on its head to stay out of sandstorms, it is perfectly adapted to desert life.',
                'image' => '/images/animals/sand-cat-1.jpg',
                'gallery' => json_encode(['/images/animals/sand-cat-1.jpg', '/images/animals/sand-cat-2.jpg']),
                'fun_facts' => json_encode(['Their furry paws leave no footprints in the sand.', 'They can survive without drinking water, getting moisture from prey.', 'They bark like dogs when seeking a mate.']),
                'weight' => '3 kg', 'height' => '0.25 m', 'speed' => '40 km/h',
            ],
        ];

        foreach ($animals as $animal) {
            Animal::create($animal);
        }
    }
}
