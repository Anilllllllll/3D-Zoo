@extends('layouts.app')
@section('title', $animal->name)
@section('content')

{{-- Hero Image --}}
<section class="relative h-[50vh] md:h-[60vh] overflow-hidden">
    <img src="{{ $animal->image }}" alt="{{ $animal->name }}" class="w-full h-full object-cover object-center">
    <div class="absolute inset-0 bg-gradient-to-t from-[#0a1f0a] via-[#0a1f0a]/20 to-transparent"></div>
    <div class="absolute bottom-0 left-0 right-0 p-8 max-w-7xl mx-auto">
        <div class="flex items-end justify-between">
            <div>
                @php
                    $statusClass = match(strtolower($animal->conservation_status)) {
                        'endangered' => 'badge-endangered',
                        'vulnerable' => 'badge-vulnerable',
                        'least concern' => 'badge-least-concern',
                        'near threatened' => 'badge-near-threatened',
                        default => 'badge-vulnerable'
                    };
                @endphp
                <span class="{{ $statusClass }} mb-3 inline-block">{{ $animal->conservation_status }}</span>
                <h1 class="text-4xl md:text-6xl font-black text-white mb-2">{{ $animal->name }}</h1>
                <p class="text-xl text-gray-300 italic">{{ $animal->scientific_name }}</p>
            </div>
            <div class="hidden md:flex items-center gap-3">
                {{-- Favorite Button --}}
                @auth
                    <button id="favoriteBtn" onclick="toggleFavorite({{ $animal->id }})"
                            class="glass-card p-4 hover:bg-red-500/20 transition-all {{ $isFavorited ? 'bg-red-500/20 ring-2 ring-red-400' : '' }}">
                        <span class="text-2xl" id="favIcon">{{ $isFavorited ? '❤️' : '🤍' }}</span>
                    </button>
                @endauth

                {{-- Sound Button --}}
                <button onclick="playAnimalSound()" class="glass-card p-4 hover:bg-zoo-400/20 transition-all">
                    <span class="text-2xl">🔊</span>
                </button>
            </div>
        </div>
    </div>
</section>

{{-- Animal Details --}}
<section class="py-12 px-4 -mt-8 relative z-10">
    <div class="max-w-7xl mx-auto">
        {{-- Info Cards Grid --}}
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4 mb-12 reveal">
            <div class="glass-card p-4 text-center">
                <span class="text-2xl block mb-1">📋</span>
                <p class="text-xs text-gray-400">Category</p>
                <p class="text-white font-semibold text-sm">{{ $animal->category }}</p>
            </div>
            <div class="glass-card p-4 text-center">
                <span class="text-2xl block mb-1">🌍</span>
                <p class="text-xs text-gray-400">Habitat</p>
                <p class="text-white font-semibold text-sm">{{ $animal->habitat->name }}</p>
            </div>
            <div class="glass-card p-4 text-center">
                <span class="text-2xl block mb-1">🍽️</span>
                <p class="text-xs text-gray-400">Diet</p>
                <p class="text-white font-semibold text-sm">{{ $animal->diet }}</p>
            </div>
            <div class="glass-card p-4 text-center">
                <span class="text-2xl block mb-1">⏳</span>
                <p class="text-xs text-gray-400">Lifespan</p>
                <p class="text-white font-semibold text-sm">{{ $animal->lifespan }}</p>
            </div>
            <div class="glass-card p-4 text-center">
                <span class="text-2xl block mb-1">⚖️</span>
                <p class="text-xs text-gray-400">Weight</p>
                <p class="text-white font-semibold text-sm">{{ $animal->weight ?? 'N/A' }}</p>
            </div>
            <div class="glass-card p-4 text-center">
                <span class="text-2xl block mb-1">📏</span>
                <p class="text-xs text-gray-400">Height</p>
                <p class="text-white font-semibold text-sm">{{ $animal->height ?? 'N/A' }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Description --}}
            <div class="lg:col-span-2 space-y-8">
                <div class="glass-card p-8 reveal">
                    <h2 class="text-2xl font-bold text-white mb-4">About {{ $animal->name }}</h2>
                    <p class="text-gray-300 leading-relaxed">{{ $animal->description }}</p>
                </div>

                {{-- Fun Facts --}}
                @php
                    $funFacts = $animal->fun_facts;
                    if (is_string($funFacts)) $funFacts = json_decode($funFacts, true);
                @endphp
                @if($funFacts && is_array($funFacts) && count($funFacts) > 0)
                    <div class="glass-card p-8 reveal">
                        <h2 class="text-2xl font-bold text-white mb-4">🌟 Fun Facts</h2>
                        <ul class="space-y-3">
                            @foreach($funFacts as $fact)
                                <li class="flex items-start gap-3 text-gray-300">
                                    <span class="text-zoo-400 mt-1 font-bold">✓</span>
                                    <span>{{ $fact }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Gallery --}}
                @php
                    $gallery = $animal->gallery;
                    if (is_string($gallery)) $gallery = json_decode($gallery, true);
                @endphp
                @if($gallery && is_array($gallery) && count($gallery) > 0)
                    <div class="glass-card p-8 reveal">
                        <h2 class="text-2xl font-bold text-white mb-4">📸 Gallery</h2>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach($gallery as $image)
                                <img src="{{ $image }}" alt="{{ $animal->name }}" onclick="openHologram(this.src)" class="rounded-xl w-full h-40 object-cover hover:scale-105 transition-transform duration-300 cursor-pointer shadow-lg hover:shadow-zoo-400/50" loading="lazy">
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            {{-- Sidebar --}}
            <div class="space-y-6">
                {{-- Quick Stats --}}
                <div class="glass-card p-6 reveal">
                    <h3 class="text-lg font-bold text-white mb-4">📊 Quick Facts</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center py-2 border-b border-white/10">
                            <span class="text-gray-400">Species</span>
                            <span class="text-white font-medium">{{ $animal->species }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-white/10">
                            <span class="text-gray-400">Speed</span>
                            <span class="text-white font-medium">{{ $animal->speed ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-white/10">
                            <span class="text-gray-400">Views</span>
                            <span class="text-white font-medium">{{ number_format($animal->views_count) }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2">
                            <span class="text-gray-400">Conservation</span>
                            <span class="{{ $statusClass }}">{{ $animal->conservation_status }}</span>
                        </div>
                    </div>
                </div>

                {{-- Mobile Buttons --}}
                <div class="md:hidden flex gap-3">
                    @auth
                        <button id="favoriteBtnMobile" onclick="toggleFavorite({{ $animal->id }})"
                                class="glass-card p-4 flex-1 text-center {{ $isFavorited ? 'bg-red-500/20 ring-2 ring-red-400' : '' }}">
                            <span id="favIconMobile">{{ $isFavorited ? '❤️ Favorited' : '🤍 Add Favorite' }}</span>
                        </button>
                    @endauth
                    <button onclick="playAnimalSound()" class="glass-card p-4 flex-1 text-center">🔊 Play Sound</button>
                </div>

                {{-- Habitat Link --}}
                <a href="{{ route('habitats.show', $animal->habitat) }}" class="glass-card p-6 block reveal hover:ring-2 hover:ring-zoo-400/50">
                    <h3 class="text-lg font-bold text-white mb-2">{{ $animal->habitat->icon }} {{ $animal->habitat->name }} Habitat</h3>
                    <p class="text-gray-400 text-sm">{{ Str::limit($animal->habitat->description, 100) }}</p>
                    <span class="text-zoo-400 text-sm mt-2 inline-block">Explore habitat →</span>
                </a>

                {{-- Ask AI --}}
                <a href="{{ route('chatbot') }}?ask={{ urlencode($animal->name) }}" class="glass-card p-6 block reveal hover:ring-2 hover:ring-zoo-400/50">
                    <h3 class="text-lg font-bold text-white mb-2">🤖 Ask AI About {{ $animal->name }}</h3>
                    <p class="text-gray-400 text-sm">Chat with our AI to learn more interesting facts</p>
                    <span class="text-zoo-400 text-sm mt-2 inline-block">Start chat →</span>
                </a>
            </div>
        </div>

        {{-- Related Animals --}}
        @if($relatedAnimals->count() > 0)
            <div class="mt-16 reveal">
                <h2 class="section-title text-center mb-8">Related Animals</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($relatedAnimals as $related)
                        <a href="{{ route('animals.show', $related) }}" class="animal-card">
                            <div class="overflow-hidden h-44">
                                <img src="{{ $related->image }}" alt="{{ $related->name }}" class="card-image" loading="lazy">
                            </div>
                            <div class="p-4">
                                <h3 class="text-lg font-bold text-white">{{ $related->name }}</h3>
                                <p class="text-gray-400 text-sm">{{ $related->species }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>

{{-- 3D Hologram Modal --}}
<div id="hologramModal" class="fixed inset-0 z-50 hidden opacity-0 transition-opacity duration-500 bg-black/90 backdrop-blur-xl flex items-center justify-center" style="perspective: 1500px;">

    {{-- Close button: fixed to top-right corner of the viewport, always above everything --}}
    <button onclick="closeHologram()"
            style="position:fixed; top:1.25rem; right:1.5rem; z-index:9999; line-height:1;"
            class="w-10 h-10 flex items-center justify-center rounded-full bg-white/10 hover:bg-white/25 text-white text-2xl font-light transition-all backdrop-blur-sm border border-white/20 shadow-lg">
        &times;
    </button>

    <div class="absolute inset-0 pointer-events-none hologram-environment">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-zoo-400/20 via-transparent to-transparent opacity-50"></div>
        <div class="absolute bottom-0 w-full h-1/3 bg-gradient-to-t from-zoo-500/10 to-transparent"></div>
    </div>

    {{-- Container: padding keeps image away from edges & close button --}}
    <div id="hologramContainer"
         class="relative preserve-3d transition-transform duration-100 ease-out cursor-move"
         style="width: min(90vw, 800px); max-height: 80vh; margin-top: 3rem;">

        <div class="hologram-glow absolute inset-0 -inset-x-8 -inset-y-8 bg-zoo-400/20 blur-3xl rounded-[3rem] opacity-0 transition-opacity duration-500 pointer-events-none"></div>

        <div class="hologram-card relative rounded-2xl overflow-hidden shadow-[0_0_50px_rgba(74,222,128,0.3)] ring-1 ring-white/10">
            <img id="hologramImage" src="" alt="Hologram Projection"
                 style="display:block; width:100%; max-height:75vh; object-fit:contain;"
                 class="relative z-10 rounded-xl">

            {{-- Holographic overlay effects --}}
            <div class="absolute inset-0 z-20 pointer-events-none bg-gradient-to-b from-transparent via-zoo-400/10 to-transparent scanline-anim"></div>
            <div class="absolute inset-0 z-20 pointer-events-none opacity-50"
                 style="background-image:url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI0IiBoZWlnaHQ9IjQiPgo8cmVjdCB3aWR0aD0iNCIgaGVpZ2h0PSI0IiBmaWxsPSIjMDAwIiBmaWxsLW9wYWNpdHk9IjAuMSIvPgo8L3N2Zz4=')"></div>
            <div class="absolute -inset-[100%] z-30 pointer-events-none bg-gradient-to-tr from-transparent via-white/5 to-transparent hologram-glare transform rotate-45 transition-transform duration-500"></div>
        </div>
    </div>

    <div class="absolute bottom-6 left-0 right-0 text-center pointer-events-none animate-pulse text-zoo-400/80 tracking-[0.3em] text-sm uppercase font-light">
        [ Drag to rotate &nbsp;✦&nbsp; 3D Projection ]
    </div>
</div>

<style>
    .preserve-3d { transform-style: preserve-3d; }
    
    @keyframes scanline {
        0% { transform: translateY(-100%); }
        100% { transform: translateY(100%); }
    }
    .scanline-anim {
        height: 20%;
        animation: scanline 4s linear infinite;
    }

    .hologram-card {
        transform-style: preserve-3d;
        /* Simulated RGB split / Chromatic aberration for hologram feel */
        text-shadow: 2px 0px 5px rgba(255,0,0,0.5), -2px 0px 5px rgba(0,255,255,0.5);
    }

    .hologram-environment {
        background-image: 
            linear-gradient(rgba(34, 197, 94, 0.05) 1px, transparent 1px),
            linear-gradient(90deg, rgba(34, 197, 94, 0.05) 1px, transparent 1px);
        background-size: 40px 40px;
        transform: perspective(500px) rotateX(60deg) translateY(-100px) translateZ(-200px);
        transform-origin: bottom;
    }
</style>

{{-- Web Speech API Audio Tour --}}
<script>
    // Pass animal data to JavaScript safely
    window.animalData = {
        name: @json($animal->name),
        habitat: @json($animal->habitat->name),
        description: @json(Str::limit($animal->description, 150)),
        funFacts: @json(is_string($animal->fun_facts) ? json_decode($animal->fun_facts) : $animal->fun_facts)
    };
</script>

@endsection

@push('scripts')
<script>
    function playAnimalSound() {
        if (!('speechSynthesis' in window)) {
            alert('🔇 Sorry, your browser does not support the Audio Tour feature.');
            return;
        }

        // Stop any currently playing audio
        window.speechSynthesis.cancel();

        // Create the script for the virtual tour guide
        let facts = window.animalData.funFacts;
        let randomFact = (facts && facts.length > 0) ? facts[Math.floor(Math.random() * facts.length)] : window.animalData.description;
        
        let script = `Welcome to the ${window.animalData.habitat} habitat. You are looking at the ${window.animalData.name}. ${randomFact}`;

        let utterance = new SpeechSynthesisUtterance(script);
        utterance.rate = 0.95; // Slightly slower for a more natural guide voice
        utterance.pitch = 1.0;
        
        // Try to find a good English voice
        let voices = window.speechSynthesis.getVoices();
        let enVoice = voices.find(v => v.lang.includes('en-GB') || v.lang.includes('en-US'));
        if (enVoice) utterance.voice = enVoice;

        window.speechSynthesis.speak(utterance);
        
        // Add a visual cue to the button
        const btn = document.querySelector('button[onclick="playAnimalSound()"]');
        if(btn) {
            btn.classList.add('ring-2', 'ring-zoo-400', 'animate-pulse');
            utterance.onend = () => btn.classList.remove('ring-2', 'ring-zoo-400', 'animate-pulse');
        }
    }

    function toggleFavorite(animalId) {
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
            const icons = document.querySelectorAll('#favIcon, #favIconMobile');
            const btns = document.querySelectorAll('#favoriteBtn, #favoriteBtnMobile');

            icons.forEach(icon => {
                icon.textContent = data.status === 'added' ? '❤️' : '🤍';
            });
            btns.forEach(btn => {
                btn.classList.toggle('bg-red-500/20', data.status === 'added');
                btn.classList.toggle('ring-2', data.status === 'added');
                btn.classList.toggle('ring-red-400', data.status === 'added');
            });
        })
        .catch(() => {
            window.location.href = '{{ route("login") }}';
        });
    }

    // ----------------------------------------
    // Hologram 3D Viewer Logic
    // ----------------------------------------
    const modal = document.getElementById('hologramModal');
    const container = document.getElementById('hologramContainer');
    const image = document.getElementById('hologramImage');
    const glow = document.querySelector('.hologram-glow');
    const glare = document.querySelector('.hologram-glare');
    
    let isDragging = false;
    let startX = 0, startY = 0;
    let currentRotateX = 0, currentRotateY = 0;

    function openHologram(src) {
        image.src = src;
        modal.classList.remove('hidden');
        // Small delay to allow display:block to apply before animating opacity
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            modal.classList.add('opacity-100');
            glow.classList.remove('opacity-0');
            glow.classList.add('opacity-100');
        }, 10);
        
        // Reset rotation
        currentRotateX = 0;
        currentRotateY = 0;
        updateTransform();
    }

    function closeHologram() {
        modal.classList.remove('opacity-100');
        modal.classList.add('opacity-0');
        glow.classList.remove('opacity-100');
        glow.classList.add('opacity-0');
        
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 500); // match transition duration
    }

    // Mouse movement tracking for 3D tilt
    modal.addEventListener('mousemove', (e) => {
        if (!isDragging && modal.classList.contains('opacity-100')) {
            // Hover tilt effect (subtle)
            const xAxis = (window.innerWidth / 2 - e.pageX) / 40;
            const yAxis = (window.innerHeight / 2 - e.pageY) / 40;
            
            container.style.transition = 'transform 0.1s ease-out';
            container.style.transform = `rotateY(${xAxis}deg) rotateX(${yAxis}deg)`;
            
            // Move glare
            glare.style.transform = `rotate(45deg) translate(${xAxis * 10}px, ${yAxis * 10}px)`;
        }
    });

    modal.addEventListener('mouseleave', () => {
        if (!isDragging) {
            container.style.transition = 'transform 0.5s ease-out';
            container.style.transform = `rotateY(0deg) rotateX(0deg)`;
            glare.style.transform = `rotate(45deg) translate(0px, 0px)`;
        }
    });

    // Drag to rotate (Desktop & Touch)
    modal.addEventListener('mousedown', dragStart);
    modal.addEventListener('touchstart', (e) => dragStart(e.touches[0]));

    window.addEventListener('mousemove', dragMove);
    window.addEventListener('touchmove', (e) => dragMove(e.touches[0]), {passive: false});

    window.addEventListener('mouseup', dragEnd);
    window.addEventListener('touchend', dragEnd);

    function dragStart(e) {
        if (e.target.tagName === 'BUTTON') return;
        isDragging = true;
        startX = e.pageX;
        startY = e.pageY;
        container.style.transition = 'none'; // remove transition for smooth dragging
    }

    function dragMove(e) {
        if (!isDragging) return;
        
        const deltaX = e.pageX - startX;
        const deltaY = e.pageY - startY;
        
        // Adjust sensitivity here
        currentRotateY += deltaX * 0.3;
        currentRotateX -= deltaY * 0.3;
        
        // Limit X rotation to avoid flipping upside down
        currentRotateX = Math.max(-60, Math.min(60, currentRotateX));
        
        updateTransform();
        
        startX = e.pageX;
        startY = e.pageY;
    }

    function dragEnd() {
        isDragging = false;
        // Optional: animate back to center or stay at rotated angle. 
        // We'll let it stay at the rotated angle for a cool effect.
        container.style.transition = 'transform 0.3s ease-out';
    }

    function updateTransform() {
        container.style.transform = `rotateX(${currentRotateX}deg) rotateY(${currentRotateY}deg)`;
    }
</script>
@endpush
