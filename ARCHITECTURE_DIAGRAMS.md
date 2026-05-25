# ZooSphere - Architecture & System Design

## 🏗️ COMPLETE SYSTEM ARCHITECTURE

```
┌────────────────────────────────────────────────────────────────────────────┐
│                          PRESENTATION LAYER (Views)                        │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐  │
│  │  Quiz View   │  │ Favorites    │  │ Kids Zone    │  │ Chatbot      │  │
│  │ .blade.php   │  │ View          │  │ View         │  │ View         │  │
│  └──────┬───────┘  └──────┬───────┘  └──────┬───────┘  └──────┬───────┘  │
└─────────┼──────────────────┼──────────────────┼──────────────────┼─────────┘
          │                  │                  │                  │
          │ HTML/Forms       │ AJAX Requests    │ Blade Data       │ Messages
          │                  │                  │                  │
┌─────────▼──────────────────▼──────────────────▼──────────────────▼─────────┐
│                      APPLICATION LAYER (Controllers)                       │
│  ┌────────────────────────┐  ┌───────────────────────────┐               │
│  │   QuizController       │  │   FavoriteController      │               │
│  │ • index()              │  │ • index()                 │               │
│  │ • submit()             │  │ • toggle()                │               │
│  └────────┬───────────────┘  └─────────┬─────────────────┘               │
│           │                            │                                  │
│  ┌────────┼────────────────┐  ┌────────┼────────────────┐               │
│  │   KidsZoneController   │  │ ChatbotController      │               │
│  │ • index()              │  │ • index()              │               │
│  │ (hardcoded games)      │  │ • ask()                │               │
│  │                        │  │ • generateResponse()   │               │
│  └────────┬───────────────┘  └────────┬────────────────┘               │
└───────────┼────────────────────────────┼──────────────────────────────────┘
            │                            │
            │ Eloquent Queries           │ Model Methods
            │                            │
┌───────────▼────────────────────────────▼──────────────────────────────────┐
│                      BUSINESS LOGIC LAYER (Models)                        │
│  ┌──────────────────┐  ┌──────────────────┐  ┌──────────────────┐       │
│  │  Quiz Model      │  │ QuizResult Model │  │  Favorite Model  │       │
│  │ • find()         │  │ • create()       │  │ • relationships  │       │
│  │ • inRandomOrder()│  │ • belongsTo      │  │ • user()         │       │
│  │ • relationships  │  │                  │  │ • animal()       │       │
│  └────────┬─────────┘  └────────┬─────────┘  └────────┬─────────┘       │
│           │                     │                     │                  │
│  ┌────────┼─────────────────────┼─────────────────────┼────────┐       │
│  │              User Model (for relationships)          │       │       │
│  │              • favorites() → hasMany(Favorite)       │       │       │
│  │              • quizResults() → hasMany(QuizResult)   │       │       │
│  └────────────────────────────────────────────────────┘       │       │
│           │                     │                     │                  │
│           │                     │                  quizzes data          │
│           │                     │                     │                  │
│           │              ┌──────▼──────┐              │                  │
│           │              │ Animal Model │              │                  │
│           │              │ • habitats() │              │                  │
│           │              │ • relationship│              │                  │
│           │              └──────┬───────┘              │                  │
│           │                     │                      │                  │
└───────────┼─────────────────────┼──────────────────────┼──────────────────┘
            │                     │                      │
            │ SQL Queries         │ CRUD Operations      │
            │                     │                      │
┌───────────▼─────────────────────▼──────────────────────▼──────────────────┐
│                        DATABASE LAYER (MySQL)                              │
│  ┌─────────────────┐  ┌──────────────────┐  ┌───────────────────┐       │
│  │  quizzes table  │  │ quiz_results     │  │ favorites table   │       │
│  │ ───────────────│  │ ─────────────────│  │ ─────────────────│       │
│  │ id (PK)         │  │ id (PK)          │  │ id (PK)           │       │
│  │ question        │  │ user_id (FK)     │  │ user_id (FK)      │       │
│  │ options (JSON)  │  │ score            │  │ animal_id (FK)    │       │
│  │ correct_answer  │  │ total            │  │ timestamps        │       │
│  │ difficulty      │  │ percentage       │  │                   │       │
│  │ category        │  │ timestamps       │  │ [UNIQUE:          │       │
│  │ timestamps      │  │                  │  │  user_id,         │       │
│  │                 │  │                  │  │  animal_id]       │       │
│  └─────────────────┘  └──────────────────┘  └───────────────────┘       │
│                           │                                                │
│  ┌─────────────────┐  ┌───┴────────────────┐  ┌───────────────────┐    │
│  │  animals table  │  │   users table      │  │  habitats table   │    │
│  │ ───────────────│  │ ──────────────────│  │ ──────────────────│    │
│  │ id (PK)         │  │ id (PK)            │  │ id (PK)           │    │
│  │ name            │  │ name               │  │ name              │    │
│  │ scientific_name │  │ email (UNIQUE)     │  │ description       │    │
│  │ species         │  │ password           │  │                   │    │
│  │ habitat_id (FK) │  │ role               │  │                   │    │
│  │ diet            │  │ timestamps         │  │                   │    │
│  │ lifespan        │  │                    │  │                   │    │
│  │ conservation    │  │                    │  │                   │    │
│  │ fun_facts (JSON)│  │                    │  │                   │    │
│  │ timestamps      │  │                    │  │                   │    │
│  └─────────────────┘  └────────────────────┘  └───────────────────┘    │
└────────────────────────────────────────────────────────────────────────────┘
```

---

## 📍 DATA FLOW SEQUENCE DIAGRAMS

### Quiz Flow - Complete Sequence

```
User                Browser              Controller           Model          Database
 │                    │                      │                 │               │
 ├───(Click Quiz)────►│                      │                 │               │
 │                    ├──(GET /quiz)────────►│                 │               │
 │                    │                      ├─(load quizzes)─►│               │
 │                    │                      │                 ├─(SQL query)──►│
 │                    │                      │                 │◄─(10 random) ─┤
 │                    │                      │◄──(Quiz objs)───┤               │
 │                    │◄─(render view)───────┤                 │               │
 │◄─(HTML with Qs)───┤                      │                 │               │
 │                    │                      │                 │               │
 ├─(Select Answers)──►│                      │                 │               │
 ├─(Submit Form)─────►│                      │                 │               │
 │                    ├─(POST /quiz/submit)─►│                 │               │
 │                    │                      ├─(Calculate)─────┤               │
 │                    │                      ├─(Save Result)──────────────────►│
 │                    │                      │                 ├─(INSERT)─────►│
 │                    │                      │                 │◄─(OK)─────────┤
 │                    │                      │                 │               │
 │                    │◄─(Results page)──────┤                 │               │
 │◄─(Show Results)───┤                      │                 │               │
 │                    │                      │                 │               │
```

### Favorites Flow - Complete Sequence

```
User                Browser              Controller           Model          Database
 │                    │                      │                 │               │
 ├───(Click Heart)───►│                      │                 │               │
 │                    ├──(AJAX POST)────────►│                 │               │
 │                    │  /favorites/toggle   ├─(Check exists)─►│               │
 │                    │  {animal_id: 5}      │                 ├─(SQL query)──►│
 │                    │                      │                 │◄─(Found/Not) ─┤
 │                    │  IF EXISTS:          │                 │               │
 │                    │  ┌───────────────────┤─(Delete)───────►│               │
 │                    │  │                   │                 ├─(DELETE)─────►│
 │                    │  │                   │                 │◄─(OK)─────────┤
 │                    │  │
 │                    │  IF NOT EXISTS:      │                 │               │
 │                    │  ├───────────────────┤─(Create)───────►│               │
 │                    │  │                   │                 ├─(INSERT)─────►│
 │                    │  │                   │                 │◄─(OK)─────────┤
 │                    │  └───────────────────┤                 │               │
 │                    │◄─(JSON Response)────┤                 │               │
 │◄─(Heart toggles)──┤  {status: added}     │                 │               │
 │  (no reload)       │                      │                 │               │
```

### Chatbot Flow - Complete Sequence

```
User                Browser              Controller           Model          Database
 │                    │                      │                 │               │
 ├──(Type message)───►│                      │                 │               │
 ├─(Send message)────►│                      │                 │               │
 │                    ├─(AJAX POST)─────────►│                 │               │
 │                    │  /chatbot/ask        ├─(Validate)      │               │
 │                    │  {message: "..."}    ├─(searchAnimal)─►│               │
 │                    │                      │                 ├─(SQL query)──►│
 │                    │                      │                 │◄─(All animals)┤
 │                    │                      │◄─(Animal found) ─┤               │
 │                    │                      ├─(matchKeywords) │               │
 │                    │                      ├─(generateResponse)             │
 │                    │                      │                 │               │
 │                    │◄─(JSON Response)────┤                 │               │
 │◄─(Chatbot answer)──┤  {response: "..."}   │                 │               │
 │                    │                      │                 │               │
```

---

## 🔐 AUTHENTICATION & MIDDLEWARE FLOW

```
User Request
    │
    ├─► Is route protected? (middleware 'auth')
    │   │
    │   ├─► YES → Is user logged in?
    │   │    │
    │   │    ├─► YES → Continue to controller
    │   │    │
    │   │    └─► NO → Redirect to /login
    │   │
    │   └─► NO → Continue to controller
    │
    └─► Execute Controller Action
```

**Protected Routes (require auth):**

- `GET /quiz` ✅
- `POST /quiz/submit` ✅
- `GET /favorites` ✅
- `POST /favorites/toggle` ✅

**Public Routes:**

- `GET /chatbot` ✅
- `POST /chatbot/ask` ✅
- `GET /kids-zone` ✅

---

## 💾 DATABASE RELATIONSHIP DIAGRAM

```
┌─────────────┐
│   Users     │
├─────────────┤
│ id (PK)     │◄─────────────────┐
│ name        │                  │ (1 to Many)
│ email       │                  │
│ password    │                  │
│ role        │                  │
└─────────────┘                  │
      ▲                          │
      │                     ┌────┴──────────┐
      │                     │  QuizResults  │
      │ (Many to Many)      ├───────────────┤
      │                     │ id (PK)       │
      │                     │ user_id (FK)──┘
      │                     │ score         │
      │                     │ total         │
      │                     │ percentage    │
      │                     │ timestamps    │
      │                     └───────────────┘
      │
      │              ┌──────────────┐
      │              │  Favorites   │
      │              ├──────────────┤
      │ (Many to Many)│ id (PK)      │
      └──────────────┤ user_id (FK)─┘
                     │ animal_id (FK)──┐
                     │ timestamps   │  │
                     │              │  │ (1 to Many)
                     │ [UNIQUE]     │  │
                     └──────────────┘  │
                                       │
                                  ┌────▼─────────┐
                                  │   Animals    │
                                  ├──────────────┤
                                  │ id (PK)      │
                                  │ name         │
                                  │ species      │
                                  │ habitat_id──┐│
                                  │ diet         ││
                                  │ lifespan     ││
                                  │ conservation ││
                                  │ fun_facts    ││
                                  │ timestamps   ││
                                  └──────────────┘│
                                          │       │
                                          │   ┌───▼────────┐
                                          │   │ Habitats   │
                                          │   ├────────────┤
                                          └──►│ id (PK)    │
                                              │ name       │
                                              │ description│
                                              └────────────┘

Legend:
─── One-to-One Relationship
─▶ One-to-Many Relationship
◄─► Many-to-Many Relationship (through Pivot)
(FK) Foreign Key
(PK) Primary Key
```

---

## 🔄 REQUEST LIFECYCLE

```
1. USER ACTION
   └─ Clicks button/submits form/sends message

2. BROWSER HANDLES
   └─ Creates HTTP Request (GET/POST with data)

3. ROUTING LAYER
   └─ web.php matches URL to Controller action
      └─ Checks middleware (auth, admin, etc.)

4. CONTROLLER ACTION EXECUTES
   └─ Receives Request object
   └─ Validates input
   └─ Calls Model methods
   └─ Passes data to View OR returns JSON

5. MODEL LAYER
   └─ Executes Eloquent queries
   └─ Returns data collection/object

6. VIEW RENDERING (or JSON Response)
   └─ If View: Blade template renders HTML with data
   └─ If JSON: Returns JSON response for AJAX

7. RESPONSE SENT TO BROWSER
   └─ HTTP Response (200, 302, 400, 500, etc.)

8. BROWSER DISPLAYS RESULT
   └─ Shows page OR updates DOM with AJAX response
```

---

## 📊 QUIZ SCORING ALGORITHM

```
START
  │
  ├─► Load user answers: {quiz_id: "answer_value", ...}
  │
  ├─► Initialize: score = 0, total = count(answers)
  │
  ├─► FOR EACH answer in answers:
  │    │
  │    ├─► Fetch Quiz record from database
  │    │
  │    ├─► Compare: quiz->correct_answer === user_answer
  │    │
  │    ├─► IF MATCH:
  │    │    └─► score++
  │    │
  │    └─► Store result: {question, your_answer, correct_answer, is_correct}
  │
  ├─► Calculate percentage = (score / total) * 100
  │
  ├─► IF user is authenticated:
  │    └─► Save QuizResult(user_id, score, total, percentage)
  │
  ├─► Return results to view
  │
  └─► END
```

---

## 🎮 KIDS ZONE DATA STRUCTURE

```
gameAnimals (Array of Objects)
├─ [0] {name: "Lion", emoji: "🦁", hint: "...", image: "url"}
├─ [1] {name: "Elephant", emoji: "🐘", hint: "...", image: "url"}
├─ [2] {name: "Penguin", emoji: "🐧", hint: "...", image: "url"}
├─ [3] {name: "Tiger", emoji: "🐅", hint: "...", image: "url"}
├─ [4] {name: "Dolphin", emoji: "🐬", hint: "...", image: "url"}
├─ [5] {name: "Giraffe", emoji: "🦒", hint: "...", image: "url"}
├─ [6] {name: "Owl", emoji: "🦉", hint: "...", image: "url"}
└─ [7] {name: "Panda", emoji: "🐼", hint: "...", image: "url"}

matchingPairs (Array of Objects)
├─ [0] {animal: "Lion", emoji: "🦁", match: "Savannah"}
├─ [1] {animal: "Penguin", emoji: "🐧", match: "Arctic"}
├─ [2] {animal: "Dolphin", emoji: "🐬", match: "Ocean"}
├─ [3] {animal: "Tiger", emoji: "🐅", match: "Forest"}
├─ [4] {animal: "Camel", emoji: "🐫", match: "Desert"}
└─ [5] {animal: "Panda", emoji: "🐼", match: "Forest"}
```

---

## 🤖 CHATBOT RESPONSE DECISION TREE

```
User Message
    │
    ├─► Search for animal in message (str_contains)
    │
    ├─► Identify question type by keywords:
    │   │
    │   ├─► "eat", "diet", "food" → DIET QUESTION
    │   │   └─► If animal found: Show diet info
    │   │   └─► Else: Show general diet info
    │   │
    │   ├─► "live", "habitat", "where", "home" → HABITAT QUESTION
    │   │   └─► If animal found: Show specific habitat
    │   │   └─► Else: Show all habitats
    │   │
    │   ├─► "long", "lifespan", "age", "old" → LIFESPAN QUESTION
    │   │   └─► If animal found: Show specific lifespan
    │   │   └─► Else: Show general lifespan info
    │   │
    │   ├─► "endangered", "conservation", "extinct", "status" → CONSERVATION QUESTION
    │   │   └─► If animal found: Show conservation status
    │   │   └─► Else: Show general conservation message
    │   │
    │   ├─► "fact", "interesting", "fun", "cool", "tell me" → FUN FACTS
    │   │   └─► If animal found: Show random fact about animal
    │   │   └─► Else: Show generic fun fact
    │   │
    │   └─► NO MATCH → DEFAULT RESPONSE
    │       └─► Show generic help message
    │
    └─► Return JSON response
```

---

## ⚡ PERFORMANCE CONSIDERATIONS

### Current Optimizations

- ✅ Eager loading with `with()` (prevents N+1 queries)
- ✅ JSON storage for quiz options (flexible, atomic)
- ✅ AJAX for favorites (no page reloads)
- ✅ Unique constraints (database-level enforcement)
- ✅ Foreign key indexing (fast joins)

### Potential Improvements

- ⚠️ `inRandomOrder()` slow for large datasets → use offset-based randomization
- ⚠️ Hardcoded Kids Zone data → move to database for scalability
- ⚠️ Animal search in loop → use full-text search or database LIKE queries
- ⚠️ No caching → add Redis for frequently accessed data
- ⚠️ No pagination for favorites → add pagination for large lists

---

## 🔒 SECURITY LAYERS

```
Request
  │
  ├─► CSRF Token Check (@csrf in forms)
  │   └─► Validates POST/PUT/DELETE requests
  │
  ├─► Authentication Middleware (auth)
  │   └─► Checks if user is logged in
  │
  ├─► Input Validation
  │   └─► Validates animal_id exists, message max 500 chars, etc.
  │
  ├─► Eloquent Query Bindings
  │   └─► Prevents SQL injection
  │
  ├─► Cascade Delete Constraints
  │   └─► Automatically removes related records
  │
  └─► Authorization (implicit)
       └─► Can only see/modify own data (auth()->id())
```

---

**Last Updated**: May 25, 2026
