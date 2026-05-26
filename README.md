# 🌿 ZooSphere — Virtual Zoo Interactive Wildlife Exploration Platform

A full-stack Laravel MVC project that provides an immersive online virtual zoo experience where users can explore wildlife, view animal profiles, navigate habitats, take quizzes, save favorites, chat with an AI assistant, book virtual tours, and access educational content.

---

<img width="1910" height="1100" alt="image" src="https://github.com/user-attachments/assets/1bc9a509-2298-46cc-b43a-cf4a32d5d63c" />


<img width="1918" height="1035" alt="image" src="https://github.com/user-attachments/assets/e4cbbb3f-fe86-4c7c-9ec3-362d7e01462c" />



## 🚀 Features

### Core Modules
- **🦁 Animal Directory** — Browse 10+ animals with detailed profiles, galleries, fun facts, and conservation status
- **🌍 Habitats** — Explore 5 different ecosystems (Forest, Desert, Ocean, Arctic, Savannah)
- **🗺️ Interactive Zoo Map** — Click through zoo zones to discover animals
- **🧠 Wildlife Quiz** — Test knowledge with multiple-choice questions and earn certificates
- **❤️ Favorites** — Save and manage favorite animals (AJAX-powered)
- **⚙️ Admin Dashboard** — Full CRUD management for animals, habitats, quizzes, and users

### Innovation Features
- **🤖 AI Animal Chatbot** — Ask questions about any animal and get intelligent responses
- **🕶️ 3D Virtual Zoo Experience** — Immersive 3D environment to explore the zoo
- **📰 Conservation News** — Stay updated with wildlife conservation articles

### Extra Features
- **🔊 Animal Audio Experience** — Authentic animal sounds accompanying profiles
- **🎮 Kids Zone** — Interactive Animal Puzzle Challenge and Animal-Habitat matching game
- **🔐 Authentication** — User registration, login, logout with role-based access (admin/user)
- **📱 Responsive Design** — Mobile-friendly with dark jungle/nature theme
- **✨ Glassmorphism UI** — Modern glass-effect cards, smooth animations, gradient effects

---

## 🛠️ Tech Stack

| Technology | Usage |
|------------|-------|
| **Laravel 12** | PHP MVC Framework |
| **PHP 8.2+** | Backend Language |
| **MySQL (XAMPP)** | Relational Database |
| **Blade** | Templating Engine |
| **Tailwind CSS 3** | Styling Framework |
| **Alpine.js** | Frontend Interactivity |
| **JavaScript** | Client-side Logic |
| **Vite** | Asset Bundling |

---

## 📦 Installation

### Prerequisites
- PHP 8.2+
- Composer 2.x
- Node.js 18+ & npm
- Git
- XAMPP (for MySQL and Apache)

### Setup Steps

```bash
# 1. Navigate to project directory
cd "MVC Zoo"

# 2. Install PHP dependencies
composer install

# 3. Install Node dependencies
npm install

# 4. Copy environment file (if needed)
cp .env.example .env

# 5. Generate application key
php artisan key:generate

# 6. Setup MySQL database
# Start Apache and MySQL in XAMPP Control Panel
# Create a new database named `zoosphere` in phpMyAdmin

# 7. Run migrations and seed data
php artisan migrate --seed

# 8. Build frontend assets
npm run build

# 9. Start the development server
php artisan serve
```

Visit: **http://localhost:8000**

---

## 👤 Demo Accounts

| Role | Email | Password |
|------|-------|----------|
| **Admin** | admin@zoosphere.com | password |
| **User** | user@zoosphere.com | password |

---

## 📂 Project Structure

```
MVC Zoo/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── HomeController.php
│   │   │   ├── AnimalController.php
│   │   │   ├── HabitatController.php
│   │   │   ├── QuizController.php
│   │   │   ├── FavoriteController.php
│   │   │   ├── AdminController.php
│   │   │   ├── ZooMapController.php
│   │   │   ├── KidsZoneController.php
│   │   │   ├── ChatbotController.php
│   │   │   ├── Zoo3DController.php
│   │   │   └── NewsController.php
│   │   └── Middleware/
│   │       └── AdminMiddleware.php
│   └── Models/
│       ├── User.php
│       ├── Animal.php
│       ├── Habitat.php
│       ├── Quiz.php
│       ├── QuizResult.php
│       └── Favorite.php
├── database/
│   ├── migrations/
│   └── seeders/
│       ├── UserSeeder.php
│       ├── HabitatSeeder.php
│       ├── AnimalSeeder.php
│       ├── QuizSeeder.php
│       └── DatabaseSeeder.php
├── resources/
│   ├── css/app.css
│   ├── js/app.js
│   └── views/
│       ├── layouts/app.blade.php
│       ├── partials/
│       ├── animals/
│       ├── habitats/
│       ├── quiz/
│       ├── favorites/
│       ├── admin/
│       └── ...
├── routes/web.php
└── public/
    ├── images/
    └── sounds/
```

---

## 🗃️ Database Schema

| Table | Description |
|-------|-------------|
| `users` | User accounts with roles (admin/user) |
| `habitats` | Wildlife habitats (Forest, Desert, Ocean, Arctic, Savannah) |
| `animals` | Animal profiles with comprehensive data |
| `quizzes` | Multiple-choice quiz questions |
| `quiz_results` | User quiz scores and attempts |
| `favorites` | User-Animal pivot table |

### Eloquent Relationships
- **Habitat** hasMany **Animals**
- **Animal** belongsTo **Habitat**
- **User** belongsToMany **Animals** (through favorites)
- **User** hasMany **QuizResults**

---

## 🎨 Design Theme
<img width="1789" height="1021" alt="image" src="https://github.com/user-attachments/assets/d8fe25dd-e554-479e-9866-76be68e34124" />
<img width="1919" height="1098" alt="image" src="https://github.com/user-attachments/assets/25d61796-296f-496c-894c-8ff52ee0b5ff" />



- **Color Palette**: Dark jungle greens, earth tones, emerald accents
- **Style**: Glassmorphism cards with backdrop blur
- **Typography**: Outfit (Google Fonts)
- **Animations**: Scroll reveals, counter animations, hover effects, floating elements
- **Responsive**: Mobile-first design with Tailwind CSS

---

## 📝 License

This is an academic project created for educational purposes.

---

**Built with ❤️ for Wildlife Conservation — ZooSphere © 2024**
