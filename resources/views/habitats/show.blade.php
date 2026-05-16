@extends('layouts.app')
@section('title', $habitat->name . ' Habitat')
@section('content')
{{-- Habitat Hero --}}
<section class="relative h-[40vh] overflow-hidden">
    <img src="{{ $habitat->image }}" alt="{{ $habitat->name }}" class="w-full h-full object-cover">
    <div class="absolute inset-0 bg-gradient-to-t from-jungle via-jungle/60 to-transparent"></div>
    <div class="absolute bottom-0 left-0 right-0 p-8 max-w-7xl mx-auto">
        <span class="text-5xl mb-2 block">{{ $habitat->icon }}</span>
        <h1 class="text-4xl md:text-5xl font-black text-white">{{ $habitat->name }} Habitat</h1>
        <p class="text-gray-300 mt-2">{{ $habitat->climate }} · {{ $habitat->region }}</p>
    </div>
</section>

<section class="py-12 px-4">
    <div class="max-w-7xl mx-auto">
        {{-- Description --}}
        <div class="glass-card p-8 mb-12 reveal">
            <p class="text-gray-300 text-lg leading-relaxed">{{ $habitat->description }}</p>
        </div>

        {{-- Animals in this habitat --}}
        <h2 class="section-title mb-8 reveal">Animals in {{ $habitat->name }}</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($habitat->animals as $animal)
                <a href="{{ route('animals.show', $animal) }}" class="animal-card reveal">
                    <div class="overflow-hidden h-52">
                        <img src="{{ $animal->image }}" alt="{{ $animal->name }}" class="card-image" loading="lazy">
                    </div>
                    <div class="p-5">
                        <h3 class="text-lg font-bold text-white">{{ $animal->name }}</h3>
                        <p class="text-gray-400 text-sm italic">{{ $animal->scientific_name }}</p>
                        <div class="flex items-center gap-3 mt-2 text-xs text-gray-500">
                            <span>🍽️ {{ $animal->diet }}</span>
                            <span>⏳ {{ $animal->lifespan }}</span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-400">No animals found in this habitat yet.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
