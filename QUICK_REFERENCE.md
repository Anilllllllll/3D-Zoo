# ZooSphere - Quick Reference Cheat Sheet

## 📌 FEATURE OVERVIEW

### Quiz Feature

- **URL**: `/quiz`
- **Routes**: `GET /quiz` → index, `POST /quiz/submit` → submit
- **Models**: `Quiz`, `QuizResult`
- **Tables**: `quizzes`, `quiz_results`
- **Main Logic**: Load 10 random questions, submit answers, calculate score, save result

### Favorites Feature

- **URL**: `/favorites`
- **Routes**: `GET /favorites` → index, `POST /favorites/toggle` → toggle
- **Models**: `Favorite`, `User`, `Animal`
- **Tables**: `favorites`
- **Main Logic**: Toggle favorite status via AJAX, prevent duplicates with unique constraint

### Kids Zone

- **URL**: `/kids-zone`
- **Routes**: `GET /kids-zone` → index
- **Controller**: `KidsZoneController`
- **Data**: Hardcoded arrays (gameAnimals, matchingPairs)
- **Games**: Guess the Animal, Habitat Matching

### Chatbot

- **URL**: `/chatbot`
- **Routes**: `GET /chatbot` → index, `POST /chatbot/ask` → ask
- **Controller**: `ChatbotController`
- **Model**: Uses `Animal` model for knowledge base
- **Logic**: Keyword matching + context-aware responses

---

## 🔄 REQUEST FLOWS

### Quiz Flow

```
GET /quiz → QuizController::index() → Load 10 random quizzes → Render quiz.index view
                                              ↓
                                         Query: Quiz::inRandomOrder()->limit(10)->get()

POST /quiz/submit → QuizController::submit() → Validate & calculate → Save QuizResult → Return result view
                                                       ↓
                                            Create: QuizResult::create([...])
```

### Favorites Flow

```
GET /favorites → FavoriteController::index() → Load user's favorites with animals → Render favorites view
                                                     ↓
                                            Query: auth()->user()->favorites()->with('animal')->get()

POST /favorites/toggle → FavoriteController::toggle() → Check if exists → Add or Remove → Return JSON
                                                              ↓
                                        if exists: $favorite->delete() else: Favorite::create([...])
```

### Chatbot Flow

```
POST /chatbot/ask → ChatbotController::ask() → validateMessage() → generateResponse()
                                                                          ↓
                                            1. Find animal in message (str_contains)
                                            2. Identify question type (diet/habitat/etc.)
                                            3. Return context-aware response → JSON
```

---

## 💾 DATABASE SCHEMA (SIMPLIFIED)

### quizzes

```
id (bigint PK) | question (text) | options (json) | correct_answer | difficulty | category
```

### quiz_results

```
id (bigint PK) | user_id (FK) | score (int) | total (int) | percentage (int) | timestamps
```

### favorites

```
id (bigint PK) | user_id (FK) | animal_id (FK) | timestamps
[UNIQUE: user_id + animal_id]
```

---

## 🔗 KEY RELATIONSHIPS

**User → QuizResult** (One-to-Many)

- User has many quiz results
- Query: `$user->quizResults;`

**User → Favorite → Animal** (Many-to-Many through Favorite)

- User has many favorite animals
- Query: `$user->favorites()->with('animal')->get();`

**Quiz** (Standalone)

- No direct relationships, just questions in database

---

## 📝 CRITICAL CODE SNIPPETS

### Quiz Scoring Logic

```php
foreach ($answers as $quizId => $answer) {
    $quiz = Quiz::find($quizId);
    if ($quiz && $quiz->correct_answer === $answer) {
        $score++;
    }
}
$percentage = round(($score / count($answers)) * 100);
```

### Favorites Toggle Logic

```php
$existing = Favorite::where('user_id', $user->id)
    ->where('animal_id', $animalId)->first();

if ($existing) {
    $existing->delete();  // Remove
} else {
    Favorite::create([...]);  // Add
}
```

### Chatbot Matching Logic

```php
foreach ($animals as $animal) {
    if (str_contains($message, strtolower($animal->name)) ||
        str_contains($message, strtolower($animal->species))) {
        $matchedAnimal = $animal;
        break;
    }
}
```

---

## ✅ VALIDATION RULES

### Quiz Submit

- answers array required
- Each answer exists in options

### Favorites Toggle

- animal_id required
- animal_id must exist in animals table

### Chatbot Ask

- message required
- message max 500 characters

---

## 🔒 SECURITY FEATURES

1. **Auth Middleware**: `/quiz`, `/favorites`, `/quiz/submit` require authentication
2. **Input Validation**: All user inputs validated
3. **CSRF Protection**: Form requests protected with @csrf
4. **Cascade Delete**: User deletion removes all related records
5. **Unique Constraint**: Prevents duplicate favorites
6. **Parameterized Queries**: Eloquent prevents SQL injection

---

## 🚀 PERFORMANCE TIPS

1. **Eager Loading**: `with('animal')` prevents N+1 queries
2. **Randomization**: `inRandomOrder()` fine for small datasets
3. **JSON Storage**: options stored as JSON for flexibility
4. **AJAX**: Favorites toggle avoids page reload
5. **Indexing**: user_id and animal_id indexed for fast queries

---

## ⚠️ COMMON ISSUES & SOLUTIONS

**Issue**: User can add same favorite multiple times
**Solution**: Unique constraint + toggle check

```php
$table->unique(['user_id', 'animal_id']);
if ($existing) { $existing->delete(); }
```

**Issue**: Quiz questions always in same order
**Solution**: Use inRandomOrder()

```php
Quiz::inRandomOrder()->limit(10)->get();
```

**Issue**: Favorites not loading with animals
**Solution**: Use eager loading

```php
->with('animal', 'habitat')
```

**Issue**: Chatbot doesn't find animal
**Solution**: Check message contains animal name/species

```php
str_contains(strtolower($message), strtolower($animal->name))
```

---

## 📊 INTERVIEW CHECKLIST

**Before Interview, Review:**

- [ ] Quiz scoring algorithm
- [ ] Favorites unique constraint
- [ ] Kids Zone games structure
- [ ] Chatbot keyword matching
- [ ] Database relationships (User→QuizResult, User→Animal through Favorite)
- [ ] Authentication middleware
- [ ] AJAX toggle flow
- [ ] Foreign key cascade deletes
- [ ] Eloquent ORM basics
- [ ] JSON data type usage

**Prepare Examples:**

- [ ] How to explain each feature in 30 seconds
- [ ] How to fix a bug in quiz scoring
- [ ] How to add category filter to quiz
- [ ] How to prevent duplicate favorites
- [ ] How to scale Kids Zone to database

---

## 🎓 SAMPLE ANSWERS (30-SECOND VERSION)

**Q: Explain the Quiz feature**
A: Users take a 10-question random quiz. Each question has 4 multiple-choice options stored as JSON. On submission, the controller loops through answers, compares with correct_answer field, calculates score and percentage. If authenticated, the result is saved to quiz_results table with user_id, score, total, and percentage.

**Q: How does favorites work?**
A: It's a many-to-many relationship between users and animals. A unique constraint prevents duplicates. The toggle endpoint checks if the favorite exists—if yes, delete it; if no, create it. AJAX handles this without page reload, returning JSON status.

**Q: What happens if a user is deleted?**
A: Cascade delete removes all their quiz_results and favorites due to foreign key constraints with ON DELETE CASCADE. This maintains database integrity.

**Q: How does the chatbot answer questions?**
A: It uses keyword matching on the user's message. First, it searches for animal names/species in the message. Then it identifies the question type (diet, habitat, lifespan, etc.) by looking for keywords. Finally, it returns a context-aware response pulling data from the animals table, or a generic response if no animal matched.

---

## 📱 FILE LOCATIONS

```
Controllers:
- app/Http/Controllers/QuizController.php
- app/Http/Controllers/FavoriteController.php
- app/Http/Controllers/KidsZoneController.php
- app/Http/Controllers/ChatbotController.php

Models:
- app/Models/Quiz.php
- app/Models/QuizResult.php
- app/Models/Favorite.php

Migrations:
- database/migrations/2024_01_01_000004_create_quizzes_table.php
- database/migrations/2024_01_01_000005_create_quiz_results_table.php
- database/migrations/2024_01_01_000006_create_favorites_table.php

Views:
- resources/views/quiz/index.blade.php
- resources/views/quiz/result.blade.php
- resources/views/favorites/index.blade.php
- resources/views/chatbot.blade.php
- resources/views/kids-zone.blade.php

Routes:
- routes/web.php
```

---

## 🏆 WINNING ANSWERS FORMULA

1. **Start with the big picture**: "This feature does X..."
2. **Explain the data flow**: "User does Y, which triggers Z in controller..."
3. **Show database interaction**: "Then we query/save to the ABC table..."
4. **Mention security/validation**: "We ensure data integrity by..."
5. **Optional: Optimization tips**: "For scalability, we could..."

---

**Last Updated**: May 25, 2026
**Created for Interview Preparation**: ZooSphere Group Project
