@extends('layouts.app')
@section('title', 'My Favorites')
@section('content')
<section class="py-12 px-4">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-12 reveal">
            <h1 class="section-title">❤️ My Favorite Animals</h1>
            <p class="section-subtitle">Your personal collection of amazing wildlife</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($favorites as $animal)
                <div class="animal-card reveal relative">
                    <button onclick="removeFavorite({{ $animal->id }}, this)" class="absolute top-3 right-3 z-20 bg-red-500/80 text-white w-8 h-8 rounded-full flex items-center justify-center hover:bg-red-600 transition-colors text-sm">×</button>
                    <a href="{{ route('animals.show', $animal) }}">
                        <div class="overflow-hidden h-52">
                            <img src="{{ $animal->image }}" alt="{{ $animal->name }}" class="card-image" loading="lazy">
                        </div>
                        <div class="p-5">
                            <h3 class="text-lg font-bold text-white">{{ $animal->name }}</h3>
                            <p class="text-gray-400 text-sm italic">{{ $animal->scientific_name }}</p>
                            <div class="flex items-center gap-3 mt-2 text-xs text-gray-500">
                                <span>🌍 {{ $animal->habitat->name }}</span>
                                <span>🍽️ {{ $animal->diet }}</span>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-span-full text-center py-20">
                    <span class="text-7xl block mb-4">💚</span>
                    <h3 class="text-xl text-gray-400 mb-4">No favorites yet!</h3>
                    <p class="text-gray-500 mb-6">Start exploring and add animals you love to your collection.</p>
                    <a href="{{ route('animals.index') }}" class="btn-primary">🦁 Explore Animals</a>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    function removeFavorite(animalId, btn) {
        fetch('{{ route("favorites.toggle") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ animal_id: animalId })
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'removed') {
                btn.closest('.animal-card').style.opacity = '0';
                btn.closest('.animal-card').style.transform = 'scale(0.8)';
                setTimeout(() => btn.closest('.animal-card').remove(), 300);
            }
        });
    }
</script>
@endpush
