<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AnimalController;
use App\Http\Controllers\HabitatController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ZooMapController;
use App\Http\Controllers\KidsZoneController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Zoo3DController;

/*
|--------------------------------------------------------------------------
| Web Routes - ZooSphere
|--------------------------------------------------------------------------
| Public routes, authenticated routes, and admin routes
*/

// ============ PUBLIC ROUTES ============

Route::get('/', [HomeController::class, 'index'])->name('home');

// Animal directory (public)
Route::get('/animals', [AnimalController::class, 'index'])->name('animals.index');
Route::get('/animals/{animal}', [AnimalController::class, 'show'])->name('animals.show');

// Habitats (public)
Route::get('/habitats', [HabitatController::class, 'index'])->name('habitats.index');
Route::get('/habitats/{habitat}', [HabitatController::class, 'show'])->name('habitats.show');

// Interactive Zoo Map (public)
Route::get('/zoo-map', [ZooMapController::class, 'index'])->name('zoo-map');

// 3D Virtual Zoo Experience
Route::get('/3d-zoo', [Zoo3DController::class, 'index'])->name('3d-zoo');

// Kids Zone (public)
Route::get('/kids-zone', [KidsZoneController::class, 'index'])->name('kids-zone');

// Conservation News (public)
Route::get('/news', [NewsController::class, 'index'])->name('news');

// Chatbot (public page, AJAX endpoint)
Route::get('/chatbot', [ChatbotController::class, 'index'])->name('chatbot');
Route::post('/chatbot/ask', [ChatbotController::class, 'ask'])->name('chatbot.ask');

// ============ AUTHENTICATED ROUTES ============

Route::middleware('auth')->group(function () {
    // Profile (from Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Favorites
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/toggle', [FavoriteController::class, 'toggle'])->name('favorites.toggle');

    // Quiz
    Route::get('/quiz', [QuizController::class, 'index'])->name('quiz.index');
    Route::post('/quiz/submit', [QuizController::class, 'submit'])->name('quiz.submit');

    // Bookings removed
});

// ============ ADMIN ROUTES ============

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Animals CRUD
    Route::get('/animals', [AdminController::class, 'animals'])->name('admin.animals');
    Route::get('/animals/create', [AdminController::class, 'createAnimal'])->name('admin.animals.create');
    Route::post('/animals', [AdminController::class, 'storeAnimal'])->name('admin.animals.store');
    Route::get('/animals/{animal}/edit', [AdminController::class, 'editAnimal'])->name('admin.animals.edit');
    Route::put('/animals/{animal}', [AdminController::class, 'updateAnimal'])->name('admin.animals.update');
    Route::delete('/animals/{animal}', [AdminController::class, 'deleteAnimal'])->name('admin.animals.delete');

    // Habitats CRUD
    Route::get('/habitats', [AdminController::class, 'habitats'])->name('admin.habitats');
    Route::get('/habitats/create', [AdminController::class, 'createHabitat'])->name('admin.habitats.create');
    Route::post('/habitats', [AdminController::class, 'storeHabitat'])->name('admin.habitats.store');
    Route::get('/habitats/{habitat}/edit', [AdminController::class, 'editHabitat'])->name('admin.habitats.edit');
    Route::put('/habitats/{habitat}', [AdminController::class, 'updateHabitat'])->name('admin.habitats.update');
    Route::delete('/habitats/{habitat}', [AdminController::class, 'deleteHabitat'])->name('admin.habitats.delete');

    // Quizzes CRUD
    Route::get('/quizzes', [AdminController::class, 'quizzes'])->name('admin.quizzes');
    Route::get('/quizzes/create', [AdminController::class, 'createQuiz'])->name('admin.quizzes.create');
    Route::post('/quizzes', [AdminController::class, 'storeQuiz'])->name('admin.quizzes.store');
    Route::get('/quizzes/{quiz}/edit', [AdminController::class, 'editQuiz'])->name('admin.quizzes.edit');
    Route::put('/quizzes/{quiz}', [AdminController::class, 'updateQuiz'])->name('admin.quizzes.update');
    Route::delete('/quizzes/{quiz}', [AdminController::class, 'deleteQuiz'])->name('admin.quizzes.delete');

    // Users
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
});

require __DIR__.'/auth.php';
