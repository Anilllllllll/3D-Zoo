<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Habitat;
use App\Models\Quiz;
use App\Models\User;
use App\Models\Booking;
use Illuminate\Http\Request;

/**
 * AdminController - ZooSphere
 * Admin dashboard and CRUD management for all modules
 */
class AdminController extends Controller
{
    /**
     * Admin dashboard with statistics
     */
    public function dashboard()
    {
        $stats = [
            'total_animals' => Animal::count(),
            'total_users' => User::count(),
            'total_habitats' => Habitat::count(),
            'total_quizzes' => Quiz::count(),
            'total_bookings' => Booking::count(),
        ];

        $mostViewed = Animal::orderBy('views_count', 'desc')->limit(5)->get();
        $recentUsers = User::latest()->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'mostViewed', 'recentUsers'));
    }

    // ===================== ANIMAL MANAGEMENT =====================

    /**
     * List all animals for admin
     */
    public function animals()
    {
        $animals = Animal::with('habitat')->orderBy('name')->get();
        return view('admin.animals.index', compact('animals'));
    }

    /**
     * Show create animal form
     */
    public function createAnimal()
    {
        $habitats = Habitat::all();
        return view('admin.animals.create', compact('habitats'));
    }

    /**
     * Store a new animal
     */
    public function storeAnimal(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'species' => 'required|string|max:255',
            'scientific_name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'habitat_id' => 'required|exists:habitats,id',
            'diet' => 'required|string|max:255',
            'lifespan' => 'required|string|max:255',
            'conservation_status' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|string',
            'weight' => 'nullable|string',
            'height' => 'nullable|string',
            'speed' => 'nullable|string',
        ]);

        // Handle fun_facts as array
        if ($request->has('fun_facts')) {
            $validated['fun_facts'] = json_encode(array_filter(explode("\n", $request->fun_facts)));
        }

        Animal::create($validated);

        return redirect()->route('admin.animals')->with('success', 'Animal created successfully!');
    }

    /**
     * Show edit animal form
     */
    public function editAnimal(Animal $animal)
    {
        $habitats = Habitat::all();
        return view('admin.animals.edit', compact('animal', 'habitats'));
    }

    /**
     * Update an animal
     */
    public function updateAnimal(Request $request, Animal $animal)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'species' => 'required|string|max:255',
            'scientific_name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'habitat_id' => 'required|exists:habitats,id',
            'diet' => 'required|string|max:255',
            'lifespan' => 'required|string|max:255',
            'conservation_status' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|string',
            'weight' => 'nullable|string',
            'height' => 'nullable|string',
            'speed' => 'nullable|string',
        ]);

        if ($request->has('fun_facts')) {
            $validated['fun_facts'] = json_encode(array_filter(explode("\n", $request->fun_facts)));
        }

        $animal->update($validated);

        return redirect()->route('admin.animals')->with('success', 'Animal updated successfully!');
    }

    /**
     * Delete an animal
     */
    public function deleteAnimal(Animal $animal)
    {
        $animal->delete();
        return redirect()->route('admin.animals')->with('success', 'Animal deleted successfully!');
    }

    // ===================== HABITAT MANAGEMENT =====================

    public function habitats()
    {
        $habitats = Habitat::withCount('animals')->get();
        return view('admin.habitats.index', compact('habitats'));
    }

    public function createHabitat()
    {
        return view('admin.habitats.create');
    }

    public function storeHabitat(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:habitats,slug',
            'description' => 'required|string',
            'image' => 'nullable|string',
            'climate' => 'nullable|string',
            'region' => 'nullable|string',
            'icon' => 'nullable|string',
        ]);

        Habitat::create($validated);
        return redirect()->route('admin.habitats')->with('success', 'Habitat created successfully!');
    }

    public function editHabitat(Habitat $habitat)
    {
        return view('admin.habitats.edit', compact('habitat'));
    }

    public function updateHabitat(Request $request, Habitat $habitat)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:habitats,slug,' . $habitat->id,
            'description' => 'required|string',
            'image' => 'nullable|string',
            'climate' => 'nullable|string',
            'region' => 'nullable|string',
            'icon' => 'nullable|string',
        ]);

        $habitat->update($validated);
        return redirect()->route('admin.habitats')->with('success', 'Habitat updated successfully!');
    }

    public function deleteHabitat(Habitat $habitat)
    {
        $habitat->delete();
        return redirect()->route('admin.habitats')->with('success', 'Habitat deleted successfully!');
    }

    // ===================== QUIZ MANAGEMENT =====================

    public function quizzes()
    {
        $quizzes = Quiz::all();
        return view('admin.quizzes.index', compact('quizzes'));
    }

    public function createQuiz()
    {
        return view('admin.quizzes.create');
    }

    public function storeQuiz(Request $request)
    {
        $validated = $request->validate([
            'question' => 'required|string',
            'option_1' => 'required|string',
            'option_2' => 'required|string',
            'option_3' => 'required|string',
            'option_4' => 'required|string',
            'correct_answer' => 'required|string',
            'difficulty' => 'required|in:easy,medium,hard',
            'category' => 'nullable|string',
        ]);

        Quiz::create([
            'question' => $validated['question'],
            'options' => json_encode([
                $validated['option_1'],
                $validated['option_2'],
                $validated['option_3'],
                $validated['option_4'],
            ]),
            'correct_answer' => $validated['correct_answer'],
            'difficulty' => $validated['difficulty'],
            'category' => $validated['category'] ?? null,
        ]);

        return redirect()->route('admin.quizzes')->with('success', 'Quiz question created successfully!');
    }

    public function editQuiz(Quiz $quiz)
    {
        return view('admin.quizzes.edit', compact('quiz'));
    }

    public function updateQuiz(Request $request, Quiz $quiz)
    {
        $validated = $request->validate([
            'question' => 'required|string',
            'option_1' => 'required|string',
            'option_2' => 'required|string',
            'option_3' => 'required|string',
            'option_4' => 'required|string',
            'correct_answer' => 'required|string',
            'difficulty' => 'required|in:easy,medium,hard',
            'category' => 'nullable|string',
        ]);

        $quiz->update([
            'question' => $validated['question'],
            'options' => json_encode([
                $validated['option_1'],
                $validated['option_2'],
                $validated['option_3'],
                $validated['option_4'],
            ]),
            'correct_answer' => $validated['correct_answer'],
            'difficulty' => $validated['difficulty'],
            'category' => $validated['category'] ?? null,
        ]);

        return redirect()->route('admin.quizzes')->with('success', 'Quiz question updated successfully!');
    }

    public function deleteQuiz(Quiz $quiz)
    {
        $quiz->delete();
        return redirect()->route('admin.quizzes')->with('success', 'Quiz question deleted successfully!');
    }

    // ===================== USER MANAGEMENT =====================

    public function users()
    {
        $users = User::latest()->get();
        return view('admin.users', compact('users'));
    }
}
