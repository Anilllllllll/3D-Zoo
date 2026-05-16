<?php

namespace Database\Seeders;

use App\Models\Animal;
use Illuminate\Database\Seeder;

/**
 * AnimalSeeder - ZooSphere
 * Seeds 10 demo animals with comprehensive profile data
 */
class AnimalSeeder extends Seeder
{
    public function run(): void
    {
        $animals = [
            [
                'name' => 'Lion',
                'species' => 'African Lion',
                'scientific_name' => 'Panthera leo',
                'category' => 'Mammal',
                'habitat_id' => 5, // Savannah
                'diet' => 'Carnivore',
                'lifespan' => '10-14 years',
                'conservation_status' => 'Vulnerable',
                'description' => 'The lion is a large cat of the genus Panthera native to Africa and India. It is the second-largest living cat after the tiger. Lions are social animals, forming groups called prides. Male lions are distinguished by their majestic manes, which protect their necks during fights.',
                'image' => 'https://images.unsplash.com/photo-1546182990-dffeafbe841d?w=800',
                'gallery' => json_encode([
                    'https://images.unsplash.com/photo-1546182990-dffeafbe841d?w=600',
                    'https://images.unsplash.com/photo-1614027164847-1b28cfe1df60?w=600',
                    'https://images.unsplash.com/photo-1517649763962-0c623066013b?w=600',
                ]),
                'sound' => '/sounds/lion.mp3',
                'fun_facts' => json_encode([
                    'A lion\'s roar can be heard from 5 miles away!',
                    'Lions sleep up to 20 hours a day.',
                    'Female lions do 90% of the hunting.',
                    'A group of lions is called a pride.',
                    'Lions are the only cats that live in groups.',
                ]),
                'weight' => '190 kg',
                'height' => '1.2 m',
                'speed' => '80 km/h',
            ],
            [
                'name' => 'Tiger',
                'species' => 'Bengal Tiger',
                'scientific_name' => 'Panthera tigris',
                'category' => 'Mammal',
                'habitat_id' => 1, // Forest
                'diet' => 'Carnivore',
                'lifespan' => '10-15 years',
                'conservation_status' => 'Endangered',
                'description' => 'The tiger is the largest living cat species and a member of the genus Panthera. It is most recognizable for its dark vertical stripes on orange fur with a white underside. Tigers are solitary hunters and primarily hunt ungulates such as deer and wild boar.',
                'image' => '/images/animals/tiger_1.png',
                'gallery' => json_encode([
                    '/images/animals/tiger_1.png',
                    '/images/animals/tiger_2.png',
                ]),
                'sound' => '/sounds/tiger.mp3',
                'fun_facts' => json_encode([
                    'No two tigers have the same stripes — they\'re like fingerprints!',
                    'Tigers are excellent swimmers and love water.',
                    'A tiger\'s night vision is 6 times better than a human\'s.',
                    'Tigers can leap forward up to 30 feet in a single jump.',
                ]),
                'weight' => '220 kg',
                'height' => '1.1 m',
                'speed' => '65 km/h',
            ],
            [
                'name' => 'Elephant',
                'species' => 'African Elephant',
                'scientific_name' => 'Loxodonta africana',
                'category' => 'Mammal',
                'habitat_id' => 5, // Savannah
                'diet' => 'Herbivore',
                'lifespan' => '60-70 years',
                'conservation_status' => 'Vulnerable',
                'description' => 'The African elephant is the largest living terrestrial animal. These gentle giants are known for their intelligence, complex social structures, and remarkable memory. They play a crucial role in their ecosystem by creating water holes and clearing paths through dense vegetation.',
                'image' => 'https://images.unsplash.com/photo-1557050543-4d5f4e07ef46?w=800',
                'gallery' => json_encode([
                    'https://images.unsplash.com/photo-1557050543-4d5f4e07ef46?w=600',
                    'https://images.unsplash.com/photo-1564760055775-d63b17a55c44?w=600',
                ]),
                'sound' => '/sounds/elephant.mp3',
                'fun_facts' => json_encode([
                    'Elephants are the only animals that can\'t jump!',
                    'An elephant\'s trunk has over 40,000 muscles.',
                    'Elephants can recognize themselves in mirrors.',
                    'They mourn their dead and have funeral-like rituals.',
                    'Baby elephants suck their trunks like human babies suck their thumbs.',
                ]),
                'weight' => '6000 kg',
                'height' => '3.3 m',
                'speed' => '40 km/h',
            ],
            [
                'name' => 'Giant Panda',
                'species' => 'Giant Panda',
                'scientific_name' => 'Ailuropoda melanoleuca',
                'category' => 'Mammal',
                'habitat_id' => 1, // Forest
                'diet' => 'Herbivore',
                'lifespan' => '20-30 years',
                'conservation_status' => 'Vulnerable',
                'description' => 'The giant panda is a bear species endemic to China. Recognized by its bold black-and-white coat and rotund body, the panda is adored worldwide. Despite being classified as a carnivore, the panda\'s diet is overwhelmingly herbivorous, consisting almost exclusively of bamboo.',
                'image' => 'https://images.unsplash.com/photo-1564349683136-77e08dba1ef7?w=800',
                'gallery' => json_encode([
                    'https://images.unsplash.com/photo-1564349683136-77e08dba1ef7?w=600',
                    'https://images.unsplash.com/photo-1527118732049-c88155f2107c?w=600',
                ]),
                'sound' => '/sounds/panda.mp3',
                'fun_facts' => json_encode([
                    'Pandas spend 12 hours a day eating bamboo!',
                    'A newborn panda is about the size of a stick of butter.',
                    'Pandas have a special "thumb" — an extended wrist bone.',
                    'They can poop up to 40 times a day!',
                ]),
                'weight' => '100 kg',
                'height' => '0.9 m',
                'speed' => '32 km/h',
            ],
            [
                'name' => 'Emperor Penguin',
                'species' => 'Emperor Penguin',
                'scientific_name' => 'Aptenodytes forsteri',
                'category' => 'Bird',
                'habitat_id' => 4, // Arctic
                'diet' => 'Carnivore',
                'lifespan' => '15-20 years',
                'conservation_status' => 'Near Threatened',
                'description' => 'The emperor penguin is the tallest and heaviest of all living penguin species and is endemic to Antarctica. They are remarkable for their breeding cycle and their ability to survive the harsh Antarctic winter, with males incubating eggs during the coldest months.',
                'image' => 'https://images.unsplash.com/photo-1598439210625-5067c578f3f6?w=800',
                'gallery' => json_encode([
                    'https://images.unsplash.com/photo-1551986782-d0169b3f8fa7?w=600',
                    'https://images.unsplash.com/photo-1598439210625-5067c578f3f6?w=600',
                ]),
                'sound' => '/sounds/penguin.mp3',
                'fun_facts' => json_encode([
                    'Emperor penguins can dive to depths of over 500 meters!',
                    'Males incubate the egg for 65-75 days without eating.',
                    'They huddle together for warmth in temperatures of -60°C.',
                    'Penguins can drink salt water — their glands filter out the salt.',
                ]),
                'weight' => '23 kg',
                'height' => '1.1 m',
                'speed' => '12 km/h (swimming)',
            ],
            [
                'name' => 'Giraffe',
                'species' => 'Northern Giraffe',
                'scientific_name' => 'Giraffa camelopardalis',
                'category' => 'Mammal',
                'habitat_id' => 5, // Savannah
                'diet' => 'Herbivore',
                'lifespan' => '25 years',
                'conservation_status' => 'Vulnerable',
                'description' => 'The giraffe is the tallest living terrestrial animal and the largest ruminant on Earth. Its extreme height allows it to eat leaves and shoots that other herbivores cannot reach. Each giraffe has a unique coat pattern, much like human fingerprints.',
                'image' => 'https://images.unsplash.com/photo-1547721064-da6cfb341d50?w=800',
                'gallery' => json_encode([
                    'https://images.unsplash.com/photo-1547721064-da6cfb341d50?w=600',
                ]),
                'sound' => '/sounds/giraffe.mp3',
                'fun_facts' => json_encode([
                    'Giraffes only need 5-30 minutes of sleep per day!',
                    'A giraffe\'s tongue is about 20 inches long and purple-black.',
                    'Baby giraffes can stand within 30 minutes of birth.',
                    'Their heart weighs about 11 kg — the biggest of any land animal.',
                ]),
                'weight' => '1200 kg',
                'height' => '5.5 m',
                'speed' => '60 km/h',
            ],
            [
                'name' => 'Saltwater Crocodile',
                'species' => 'Saltwater Crocodile',
                'scientific_name' => 'Crocodylus porosus',
                'category' => 'Reptile',
                'habitat_id' => 3, // Ocean (coastal)
                'diet' => 'Carnivore',
                'lifespan' => '70 years',
                'conservation_status' => 'Least Concern',
                'description' => 'The saltwater crocodile is the largest living reptile and crocodilian known to science. These ancient predators have existed for over 200 million years and are apex predators in their habitat. They are found in coastal and brackish waters.',
                'image' => '/images/crocodile.png',
                'gallery' => json_encode([
                    'https://images.unsplash.com/photo-1574068468710-abbf5ba5bb55?w=600',
                ]),
                'sound' => '/sounds/crocodile.mp3',
                'fun_facts' => json_encode([
                    'Crocodiles have the strongest bite of any animal — 3,700 PSI!',
                    'They can hold their breath underwater for over an hour.',
                    'Crocodiles swallow stones to help digest food.',
                    'They have been around since the time of dinosaurs.',
                ]),
                'weight' => '450 kg',
                'height' => '0.5 m',
                'speed' => '24 km/h (water)',
            ],
            [
                'name' => 'Zebra',
                'species' => 'Plains Zebra',
                'scientific_name' => 'Equus quagga',
                'category' => 'Mammal',
                'habitat_id' => 5, // Savannah
                'diet' => 'Herbivore',
                'lifespan' => '25 years',
                'conservation_status' => 'Near Threatened',
                'description' => 'Zebras are African equines with their distinctive black-and-white striped coats. Each zebra has a unique pattern of stripes, which may serve as camouflage, a social signal, or protection against flies. They are highly social animals living in herds.',
                'image' => 'https://images.unsplash.com/photo-1534567153574-2b12153a87f0?w=800',
                'gallery' => json_encode([
                    'https://images.unsplash.com/photo-1534567153574-2b12153a87f0?w=600',
                ]),
                'sound' => '/sounds/zebra.mp3',
                'fun_facts' => json_encode([
                    'No two zebras have the same stripe pattern!',
                    'Zebras sleep standing up.',
                    'A group of zebras is called a "dazzle".',
                    'Their stripes may confuse flies, reducing insect bites.',
                ]),
                'weight' => '350 kg',
                'height' => '1.4 m',
                'speed' => '65 km/h',
            ],
            [
                'name' => 'Dolphin',
                'species' => 'Bottlenose Dolphin',
                'scientific_name' => 'Tursiops truncatus',
                'category' => 'Mammal',
                'habitat_id' => 3, // Ocean
                'diet' => 'Carnivore',
                'lifespan' => '40-50 years',
                'conservation_status' => 'Least Concern',
                'description' => 'Bottlenose dolphins are among the most intelligent creatures on Earth. Known for their curved mouths that give them a permanent "smile," these sociable marine mammals live in complex social groups and communicate using a variety of clicks, whistles, and body language.',
                'image' => 'https://images.unsplash.com/photo-1607153333879-c174d265f1d2?w=800',
                'gallery' => json_encode([
                    'https://images.unsplash.com/photo-1607153333879-c174d265f1d2?w=600',
                ]),
                'sound' => '/sounds/dolphin.mp3',
                'fun_facts' => json_encode([
                    'Dolphins sleep with one eye open!',
                    'They can swim up to 20 miles per hour.',
                    'Dolphins call each other by unique signature whistles.',
                    'They have been known to help humans and other animals in distress.',
                ]),
                'weight' => '200 kg',
                'height' => '1.2 m',
                'speed' => '35 km/h',
            ],
            [
                'name' => 'Great Horned Owl',
                'species' => 'Great Horned Owl',
                'scientific_name' => 'Bubo virginianus',
                'category' => 'Bird',
                'habitat_id' => 1, // Forest
                'diet' => 'Carnivore',
                'lifespan' => '13 years',
                'conservation_status' => 'Least Concern',
                'description' => 'The great horned owl is a large owl native to the Americas. It is an extremely adaptable bird with a vast range and is the most widely distributed true owl in the Americas. Known for their distinctive ear tufts and deep hooting call, they are fierce nocturnal predators.',
                'image' => 'https://images.unsplash.com/photo-1543549790-8b5f4a028cfb?w=800',
                'gallery' => json_encode([
                    'https://images.unsplash.com/photo-1543549790-8b5f4a028cfb?w=600',
                ]),
                'sound' => '/sounds/owl.mp3',
                'fun_facts' => json_encode([
                    'Owls can rotate their heads 270 degrees!',
                    'Their flight is nearly silent due to special feather edges.',
                    'Owls can see prey from 100 meters away in near darkness.',
                    'A group of owls is called a "parliament".',
                ]),
                'weight' => '1.4 kg',
                'height' => '0.55 m',
                'speed' => '64 km/h',
            ],
        ];

        foreach ($animals as $animal) {
            Animal::create($animal);
        }
    }
}
