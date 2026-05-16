<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizResult;
use Illuminate\Http\Request;

/**
 * QuizController - ZooSphere
 * Handles wildlife quiz flow, scoring, and results
 */
class QuizController extends Controller
{
    /**
     * Display the quiz page with questions
     */
    public function index()
    {
        $quizzes = Quiz::inRandomOrder()->limit(10)->get();
        return view('quiz.index', compact('quizzes'));
    }

    /**
     * Submit quiz answers and calculate score
     */
    public function submit(Request $request)
    {
        $answers = $request->input('answers', []);
        $score = 0;
        $total = count($answers);
        $results = [];

        foreach ($answers as $quizId => $answer) {
            $quiz = Quiz::find($quizId);
            if ($quiz) {
                $isCorrect = $quiz->correct_answer === $answer;
                if ($isCorrect) {
                    $score++;
                }
                $results[] = [
                    'question' => $quiz->question,
                    'your_answer' => $answer,
                    'correct_answer' => $quiz->correct_answer,
                    'is_correct' => $isCorrect,
                ];
            }
        }

        $percentage = $total > 0 ? round(($score / $total) * 100) : 0;

        // Save result if user is authenticated
        if (auth()->check()) {
            QuizResult::create([
                'user_id' => auth()->id(),
                'score' => $score,
                'total' => $total,
                'percentage' => $percentage,
            ]);
        }

        return view('quiz.result', compact('score', 'total', 'percentage', 'results'));
    }
}
