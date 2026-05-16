@extends('layouts.app')

@section('title', 'Welcome to ZooSphere')

@section('content')

{{-- Hero Section --}}
<section class="relative min-h-[90vh] flex items-center justify-center overflow-hidden particles-bg">
    {{-- Background Image with Overlay --}}
    <div class="absolute inset-0">
        <div class="absolute inset-0 w-full h-full opacity-40 bg-center bg-cover bg-no-repeat" style="background-image: url('https://images.unsplash.com/photo-1474511320723-9a56873571b7?w=1920');"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-jungle/50 via-jungle/70 to-jungle"></div>
    </div>

    {{-- Highlighted Wildlife Emojis - naturally scattered --}}
    <div class="absolute inset-0 z-[1] pointer-events-none hidden lg:block">
        <div class="absolute text-7xl animate-float" style="top: 8%; left: 4%; animation-delay: 0s; animation-duration: 6s; filter: drop-shadow(0 0 18px rgba(74,222,128,0.35));">🦁</div>
        <div class="absolute text-6xl animate-float" style="top: 6%; right: 12%; animation-delay: 1.2s; animation-duration: 7.5s; filter: drop-shadow(0 0 18px rgba(74,222,128,0.35));">🐘</div>
        <div class="absolute text-6xl animate-float" style="top: 35%; left: 8%; animation-delay: 2s; animation-duration: 7s; filter: drop-shadow(0 0 18px rgba(74,222,128,0.35));">🦒</div>
        <div class="absolute text-7xl animate-float" style="top: 28%; right: 5%; animation-delay: 0.6s; animation-duration: 6.5s; filter: drop-shadow(0 0 18px rgba(74,222,128,0.35));">🐬</div>
        <div class="absolute text-6xl animate-float" style="top: 58%; left: 3%; animation-delay: 1.5s; animation-duration: 5.5s; filter: drop-shadow(0 0 18px rgba(74,222,128,0.35));">🐧</div>
        <div class="absolute text-6xl animate-float" style="top: 52%; right: 10%; animation-delay: 2.8s; animation-duration: 8s; filter: drop-shadow(0 0 18px rgba(74,222,128,0.35));">🐅</div>
        <div class="absolute text-6xl animate-float" style="top: 80%; left: 10%; animation-delay: 0.8s; animation-duration: 8s; filter: drop-shadow(0 0 18px rgba(74,222,128,0.35));">🐻</div>
        <div class="absolute text-7xl animate-float" style="top: 75%; right: 4%; animation-delay: 1.8s; animation-duration: 6s; filter: drop-shadow(0 0 18px rgba(74,222,128,0.35));">🦜</div>
    </div>

    {{-- Hero Content --}}
    <div class="relative z-10 text-center max-w-5xl mx-auto px-4">
        <div class="animate-fade-in">
            <span class="text-7xl md:text-8xl mb-6 block animate-float">🌿</span>
            <h1 class="text-5xl md:text-7xl lg:text-8xl font-black mb-6 leading-tight">
                <span class="gradient-text">ZooSphere</span>
            </h1>
            <p class="text-xl md:text-2xl text-gray-300 mb-4 font-light">Virtual Zoo — Interactive Wildlife Exploration Platform</p>
            <p class="text-gray-400 max-w-2xl mx-auto mb-10 leading-relaxed">
                Embark on an immersive journey through the animal kingdom. Explore wildlife, discover habitats,
                take quizzes, and learn about conservation — all from your screen.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 flex-wrap">
                <a href="{{ route('animals.index') }}" class="btn-primary text-lg px-8 py-4 pulse-ring">
                    🦁 Explore Animals
                </a>
                <a href="{{ route('3d-zoo') }}" class="btn-primary text-lg px-8 py-4" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); box-shadow: 0 0 20px rgba(16, 185, 129, 0.4);">
                    🌐 3D Virtual Zoo
                </a>
                <a href="{{ route('zoo-map') }}" class="btn-secondary text-lg px-8 py-4">
                    🗺️ 2D Map
                </a>
            </div>
        </div>
    </div>

    {{-- Scroll indicator --}}
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce">
        <svg class="w-6 h-6 text-zoo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
        </svg>
    </div>
</section>

{{-- Statistics Section --}}
<section class="py-16 px-4">
    <div class="max-w-6xl mx-auto">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div class="stat-card reveal">
                <span class="text-4xl mb-3 block">🦁</span>
                <div class="text-3xl md:text-4xl font-bold gradient-text counter-value" data-target="{{ $stats['animals'] }}">0</div>
                <p class="text-gray-400 mt-1">Animals</p>
            </div>
            <div class="stat-card reveal" style="transition-delay: 0.1s">
                <span class="text-4xl mb-3 block">🌍</span>
                <div class="text-3xl md:text-4xl font-bold gradient-text counter-value" data-target="{{ $stats['habitats'] }}">0</div>
                <p class="text-gray-400 mt-1">Habitats</p>
            </div>
            <div class="stat-card reveal" style="transition-delay: 0.2s">
                <span class="text-4xl mb-3 block">🧬</span>
                <div class="text-3xl md:text-4xl font-bold gradient-text counter-value" data-target="{{ $stats['species'] }}">0</div>
                <p class="text-gray-400 mt-1">Species</p>
            </div>
            <div class="stat-card reveal" style="transition-delay: 0.3s">
                <span class="text-4xl mb-3 block">👥</span>
                <div class="text-3xl md:text-4xl font-bold gradient-text counter-value" data-target="{{ $stats['users'] }}">0</div>
                <p class="text-gray-400 mt-1">Explorers</p>
            </div>
        </div>
    </div>
</section>

{{-- Featured Animals --}}
<section class="py-16 px-4">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-12 reveal">
            <h2 class="section-title">🌟 Featured Animals</h2>
            <p class="section-subtitle">Meet the stars of our virtual zoo collection</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($featuredAnimals as $animal)
                <a href="{{ route('animals.show', $animal) }}" class="animal-card reveal" style="transition-delay: {{ $loop->index * 0.1 }}s">
                    <div class="overflow-hidden h-56">
                        <img src="{{ $animal->image }}" alt="{{ $animal->name }}" class="card-image" loading="lazy">
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-xl font-bold text-white">{{ $animal->name }}</h3>
                            @php
                                $statusClass = match(strtolower($animal->conservation_status)) {
                                    'endangered' => 'badge-endangered',
                                    'vulnerable' => 'badge-vulnerable',
                                    'least concern' => 'badge-least-concern',
                                    'near threatened' => 'badge-near-threatened',
                                    default => 'badge-vulnerable'
                                };
                            @endphp
                            <span class="{{ $statusClass }}">{{ $animal->conservation_status }}</span>
                        </div>
                        <p class="text-gray-400 text-sm italic mb-3">{{ $animal->scientific_name }}</p>
                        <div class="flex items-center gap-4 text-xs text-gray-500">
                            <span>🌍 {{ $animal->habitat->name }}</span>
                            <span>🍽️ {{ $animal->diet }}</span>
                            <span>👁️ {{ $animal->views_count }}</span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="text-center mt-10 reveal">
            <a href="{{ route('animals.index') }}" class="btn-primary">View All Animals →</a>
        </div>
    </div>
</section>

{{-- Explore by Habitat --}}
<section class="py-16 px-4 bg-jungle-dark/50">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-12 reveal">
            <h2 class="section-title">🌍 Explore by Habitat</h2>
            <p class="section-subtitle">Journey through diverse ecosystems and meet the animals that call them home</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
            @foreach($habitats as $habitat)
                <a href="{{ route('habitats.show', $habitat) }}" class="habitat-card h-64 reveal" style="transition-delay: {{ $loop->index * 0.1 }}s">
                    <img src="{{ $habitat->image }}" alt="{{ $habitat->name }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 hover:scale-110">
                    <div class="relative z-20 h-full flex flex-col justify-end p-6">
                        <span class="text-3xl mb-2">{{ $habitat->icon }}</span>
                        <h3 class="text-xl font-bold text-white">{{ $habitat->name }}</h3>
                        <p class="text-gray-300 text-sm">{{ $habitat->animals_count }} animals</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- Quick Access Features --}}
<section class="py-16 px-4">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-12 reveal">
            <h2 class="section-title">✨ Discover More</h2>
            <p class="section-subtitle">Exciting features to enhance your zoo experience</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <a href="{{ route('quiz.index') }}" class="glass-card p-8 text-center reveal hover:ring-2 hover:ring-zoo-400/50">
                <span class="text-5xl mb-4 block">🧠</span>
                <h3 class="text-lg font-bold text-white mb-2">Wildlife Quiz</h3>
                <p class="text-gray-400 text-sm">Test your knowledge about the animal kingdom</p>
            </a>

            <a href="{{ route('chatbot') }}" class="glass-card p-8 text-center reveal hover:ring-2 hover:ring-zoo-400/50" style="transition-delay: 0.1s">
                <span class="text-5xl mb-4 block">🤖</span>
                <h3 class="text-lg font-bold text-white mb-2">AI Chatbot</h3>
                <p class="text-gray-400 text-sm">Ask questions about any animal and get instant answers</p>
            </a>


            <a href="{{ route('kids-zone') }}" class="glass-card p-8 text-center reveal hover:ring-2 hover:ring-zoo-400/50" style="transition-delay: 0.3s">
                <span class="text-5xl mb-4 block">🎮</span>
                <h3 class="text-lg font-bold text-white mb-2">Kids Zone</h3>
                <p class="text-gray-400 text-sm">Fun games and activities for young wildlife lovers</p>
            </a>
        </div>
    </div>
</section>

{{-- Conservation CTA --}}
<section class="py-20 px-4">
    <div class="max-w-4xl mx-auto text-center reveal">
        <div class="glass-card p-12 bg-gradient-to-br from-zoo-900/50 to-emerald-900/30">
            <span class="text-6xl mb-6 block">🌱</span>
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Protect Wildlife, Protect Our Future</h2>
            <p class="text-gray-300 max-w-2xl mx-auto mb-8 leading-relaxed">
                Every species plays a vital role in our ecosystem. Learn about conservation efforts,
                understand why biodiversity matters, and join the movement to protect our planet's incredible wildlife.
            </p>
            <a href="{{ route('news') }}" class="btn-primary text-lg px-8 py-4">
                📰 Read Conservation News
            </a>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    // Counter animation
    function animateCounters() {
        document.querySelectorAll('.counter-value').forEach(counter => {
            const target = parseInt(counter.getAttribute('data-target'));
            const duration = 2000;
            const start = performance.now();

            function update(currentTime) {
                const elapsed = currentTime - start;
                const progress = Math.min(elapsed / duration, 1);
                const eased = 1 - Math.pow(1 - progress, 3); // ease-out cubic
                counter.textContent = Math.floor(eased * target);

                if (progress < 1) {
                    requestAnimationFrame(update);
                } else {
                    counter.textContent = target;
                }
            }

            // Start counter when visible
            const counterObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        requestAnimationFrame(update);
                        counterObserver.unobserve(entry.target);
                    }
                });
            });
            counterObserver.observe(counter);
        });
    }

    document.addEventListener('DOMContentLoaded', animateCounters);
</script>
@endpush
