@extends('layouts.app')
@section('title', 'Interactive Zoo Map')
@section('content')
<section class="py-12 px-4">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-12 reveal">
            <h1 class="section-title">🗺️ Interactive Zoo Map</h1>
            <p class="section-subtitle">Click on any zone to explore the animals within</p>
        </div>

        {{-- Zoo Map Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($zones as $zone)
                <div class="zoo-zone reveal" style="transition-delay: {{ $loop->index * 0.1 }}s" onclick="toggleZone('{{ $zone['slug'] }}')" id="zone-{{ $zone['slug'] }}">
                    <div class="text-center mb-4">
                        <span class="text-5xl block mb-2">{{ $zone['icon'] }}</span>
                        <h3 class="text-xl font-bold text-white">{{ $zone['name'] }}</h3>
                        <p class="text-gray-400 text-sm">{{ $zone['description'] }}</p>
                        <div class="w-16 h-1 mx-auto mt-3 rounded-full" style="background: {{ $zone['color'] }}"></div>
                    </div>

                    {{-- Animals in this zone --}}
                    <div id="animals-{{ $zone['slug'] }}" class="hidden mt-6 space-y-3 border-t border-white/10 pt-4">
                        @forelse($zone['animals'] as $animal)
                            <a href="{{ route('animals.show', $animal) }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-white/5 transition-colors">
                                <img src="{{ $animal->image }}" alt="{{ $animal->name }}" class="w-12 h-12 rounded-lg object-cover">
                                <div>
                                    <p class="text-white font-medium text-sm">{{ $animal->name }}</p>
                                    <p class="text-gray-400 text-xs">{{ $animal->species }}</p>
                                </div>
                            </a>
                        @empty
                            <p class="text-gray-500 text-center text-sm py-4">No animals registered in this zone yet.</p>
                        @endforelse
                    </div>

                    <div class="text-center mt-4">
                        <span class="text-zoo-400 text-sm" id="toggle-text-{{ $zone['slug'] }}">Click to explore →</span>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Virtual Tour Link --}}
        <div class="mt-16 glass-card p-12 text-center reveal">
            <span class="text-6xl block mb-4 animate-pulse">🌐</span>
            <h2 class="text-2xl font-bold text-white mb-3">ZooSphere 3D Experience</h2>
            <p class="text-gray-400 max-w-lg mx-auto mb-6">Experience our zoo like never before with an immersive 360-degree 3D virtual tour. Walk through habitats, meet animals up close, and explore biomes with an interactive day/night cycle and weather effects.</p>
            <a href="{{ route('3d-zoo') }}" class="btn-primary inline-flex items-center gap-2 px-8 py-3 text-lg" style="box-shadow: 0 0 20px rgba(74, 222, 128, 0.4);">
                <span>Launch 3D Zoo</span>
                <span class="text-xl">🚀</span>
            </a>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    function toggleZone(slug) {
        const animalsDiv = document.getElementById('animals-' + slug);
        const toggleText = document.getElementById('toggle-text-' + slug);

        if (animalsDiv.classList.contains('hidden')) {
            // Close all other zones first
            document.querySelectorAll('[id^="animals-"]').forEach(el => el.classList.add('hidden'));
            document.querySelectorAll('[id^="toggle-text-"]').forEach(el => el.textContent = 'Click to explore →');

            animalsDiv.classList.remove('hidden');
            toggleText.textContent = 'Click to close ×';
        } else {
            animalsDiv.classList.add('hidden');
            toggleText.textContent = 'Click to explore →';
        }
    }
</script>
@endpush
