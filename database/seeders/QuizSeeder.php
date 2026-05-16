<?php

namespace Database\Seeders;

use App\Models\Quiz;
use Illuminate\Database\Seeder;

/**
 * QuizSeeder - ZooSphere
 * Seeds 15 wildlife quiz questions across different difficulties
 */
class QuizSeeder extends Seeder
{
    public function run(): void
    {
        $quizzes = [
            [
                'question' => 'What is the fastest land animal?',
                'options' => json_encode(['Lion', 'Cheetah', 'Horse', 'Gazelle']),
                'correct_answer' => 'Cheetah',
                'difficulty' => 'easy',
                'category' => 'Mammals',
            ],
            [
                'question' => 'Which animal is known as the "King of the Jungle"?',
                'options' => json_encode(['Tiger', 'Lion', 'Gorilla', 'Elephant']),
                'correct_answer' => 'Lion',
                'difficulty' => 'easy',
                'category' => 'Mammals',
            ],
            [
                'question' => 'How many hearts does an octopus have?',
                'options' => json_encode(['1', '2', '3', '4']),
                'correct_answer' => '3',
                'difficulty' => 'medium',
                'category' => 'Marine',
            ],
            [
                'question' => 'What is the largest living reptile?',
                'options' => json_encode(['Komodo Dragon', 'Saltwater Crocodile', 'Green Anaconda', 'Leatherback Turtle']),
                'correct_answer' => 'Saltwater Crocodile',
                'difficulty' => 'medium',
                'category' => 'Reptiles',
            ],
            [
                'question' => 'Which bird can fly backwards?',
                'options' => json_encode(['Eagle', 'Hummingbird', 'Parrot', 'Penguin']),
                'correct_answer' => 'Hummingbird',
                'difficulty' => 'easy',
                'category' => 'Birds',
            ],
            [
                'question' => 'What is the scientific name of the Bengal Tiger?',
                'options' => json_encode(['Panthera tigris', 'Panthera leo', 'Panthera pardus', 'Panthera onca']),
                'correct_answer' => 'Panthera tigris',
                'difficulty' => 'hard',
                'category' => 'Mammals',
            ],
            [
                'question' => 'How long can an Emperor Penguin hold its breath underwater?',
                'options' => json_encode(['5 minutes', '10 minutes', '20 minutes', '30 minutes']),
                'correct_answer' => '20 minutes',
                'difficulty' => 'hard',
                'category' => 'Birds',
            ],
            [
                'question' => 'What do pandas primarily eat?',
                'options' => json_encode(['Fish', 'Bamboo', 'Berries', 'Insects']),
                'correct_answer' => 'Bamboo',
                'difficulty' => 'easy',
                'category' => 'Mammals',
            ],
            [
                'question' => 'Which animal has the longest lifespan?',
                'options' => json_encode(['Elephant', 'Galápagos Tortoise', 'Blue Whale', 'Parrot']),
                'correct_answer' => 'Galápagos Tortoise',
                'difficulty' => 'medium',
                'category' => 'Reptiles',
            ],
            [
                'question' => 'What is a group of lions called?',
                'options' => json_encode(['Pack', 'Herd', 'Pride', 'Flock']),
                'correct_answer' => 'Pride',
                'difficulty' => 'easy',
                'category' => 'Mammals',
            ],
            [
                'question' => 'Which animal can change its color to blend with surroundings?',
                'options' => json_encode(['Gecko', 'Chameleon', 'Iguana', 'Frog']),
                'correct_answer' => 'Chameleon',
                'difficulty' => 'easy',
                'category' => 'Reptiles',
            ],
            [
                'question' => 'How many species of dolphins are there approximately?',
                'options' => json_encode(['10', '20', '40', '80']),
                'correct_answer' => '40',
                'difficulty' => 'hard',
                'category' => 'Marine',
            ],
            [
                'question' => 'What is the tallest animal in the world?',
                'options' => json_encode(['Elephant', 'Giraffe', 'Ostrich', 'Camel']),
                'correct_answer' => 'Giraffe',
                'difficulty' => 'easy',
                'category' => 'Mammals',
            ],
            [
                'question' => 'Which owl species has distinctive ear tufts?',
                'options' => json_encode(['Barn Owl', 'Snowy Owl', 'Great Horned Owl', 'Burrowing Owl']),
                'correct_answer' => 'Great Horned Owl',
                'difficulty' => 'medium',
                'category' => 'Birds',
            ],
            [
                'question' => 'What is the conservation status of the Bengal Tiger?',
                'options' => json_encode(['Least Concern', 'Vulnerable', 'Endangered', 'Critically Endangered']),
                'correct_answer' => 'Endangered',
                'difficulty' => 'medium',
                'category' => 'Mammals',
            ],
        ];

        foreach ($quizzes as $quiz) {
            Quiz::create($quiz);
        }
    }
}
