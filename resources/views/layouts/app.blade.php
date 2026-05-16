<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="ZooSphere - An immersive online virtual zoo platform where you can explore wildlife, view animal profiles, take quizzes, and enjoy educational experiences.">

    <title>{{ config('app.name', 'ZooSphere') }} — @yield('title', 'Virtual Zoo')</title>

    <!-- Google Fonts: Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="min-h-screen flex flex-col">
    {{-- Navigation --}}
    @include('partials.navbar')

    {{-- Flash Messages --}}
    @if(session('success'))
        <div id="flash-message" class="fixed top-20 right-4 z-50 bg-zoo-600/90 text-white px-6 py-3 rounded-xl backdrop-blur-md border border-zoo-400/30 shadow-2xl animate-slide-up">
            <div class="flex items-center gap-3">
                <span class="text-xl">✅</span>
                <span>{{ session('success') }}</span>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white/60 hover:text-white">&times;</button>
            </div>
        </div>
    @endif

    {{-- Main Content --}}
    <main class="flex-1">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('partials.footer')

    {{-- Scroll Reveal Script --}}
    <script>
        // Auto-hide flash messages
        setTimeout(() => {
            const flash = document.getElementById('flash-message');
            if (flash) flash.style.opacity = '0';
            setTimeout(() => flash?.remove(), 500);
        }, 4000);

        // Scroll reveal animation
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('revealed');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
    </script>

    @stack('scripts')
</body>
</html>
