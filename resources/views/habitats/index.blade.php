@extends('layouts.app')
@section('title', 'Habitats')
@section('content')
<section class="py-12 px-4">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-12 reveal">
            <h1 class="section-title">🌍 Wildlife Habitats</h1>
            <p class="section-subtitle">Explore diverse ecosystems from lush forests to frozen tundras</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($habitats as $habitat)
                <a href="{{ route('habitats.show', $habitat) }}" class="habitat-card h-80 reveal" style="transition-delay: {{ $loop->index * 0.1 }}s">
                    <img src="{{ $habitat->image }}" alt="{{ $habitat->name }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 hover:scale-110">
                    <div class="relative z-20 h-full flex flex-col justify-end p-8">
                        <span class="text-5xl mb-3">{{ $habitat->icon }}</span>
                        <h3 class="text-2xl font-bold text-white mb-1">{{ $habitat->name }}</h3>
                        <p class="text-gray-300 text-sm mb-2">{{ Str::limit($habitat->description, 100) }}</p>
                        <div class="flex items-center gap-4 text-sm text-gray-400">
                            <span>🦁 {{ $habitat->animals_count }} Animals</span>
                            <span>🌡️ {{ $habitat->climate }}</span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endsection
