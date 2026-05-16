<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ZooSphere') }} — @yield('title', 'Authentication')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col items-center justify-center px-4 py-12">
    {{-- Logo --}}
    <a href="{{ route('home') }}" class="flex items-center gap-2 mb-8 group">
        <span class="text-4xl group-hover:animate-bounce-slow">🌿</span>
        <span class="text-3xl font-bold gradient-text">ZooSphere</span>
    </a>

    {{-- Auth Form Card --}}
    <div class="glass-card p-8 w-full max-w-md">
        {{ $slot }}
    </div>

    {{-- Back to Home --}}
    <a href="{{ route('home') }}" class="mt-6 text-gray-400 hover:text-zoo-400 transition-colors text-sm">
        ← Back to Home
    </a>
</body>
</html>
