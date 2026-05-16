@extends('layouts.app')
@section('title', 'Kids Zone')
@section('content')
<section class="py-12 px-4">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-12 reveal">
            <h1 class="section-title">🎮 Kids Zone</h1>
            <p class="section-subtitle">Fun games and activities for young wildlife explorers!</p>
        </div>

        {{-- Guess the Animal Game --}}
        <div class="glass-card p-8 mb-12 reveal">
            <h2 class="text-2xl font-bold text-white mb-6 text-center">🔮 Guess the Animal</h2>
            <p class="text-gray-400 text-center mb-8">Read the hint and try to guess which animal it is!</p>

            <div id="guessGame" class="text-center">
                <div class="glass-card p-8 max-w-lg mx-auto mb-6 bg-zoo-800/50">
                    <p class="text-gray-300 text-lg italic mb-4" id="hintText">Loading hint...</p>
                    <div id="guessImageContainer" class="hidden mb-4">
                        <img id="guessImage" src="" alt="Animal" class="w-48 h-48 object-cover rounded-2xl mx-auto">
                    </div>
                    <p class="text-5xl mb-4" id="animalEmoji">❓</p>
                </div>

                <div class="flex flex-wrap justify-center gap-3 mb-6" id="guessOptions"></div>

                <div id="guessResult" class="hidden mb-4">
                    <p id="resultText" class="text-xl font-bold"></p>
                </div>

                <button onclick="nextAnimal()" class="btn-primary" id="nextBtn">Next Animal →</button>
                <p class="text-gray-500 text-sm mt-4">
                    Score: <span id="guessScore" class="text-zoo-400 font-bold">0</span> /
                    <span id="guessTotal" class="text-white">0</span>
                </p>
            </div>
        </div>

        {{-- Animal Matching Game --}}
        <div class="glass-card p-8 mb-12 reveal">
            <h2 class="text-2xl font-bold text-white mb-6 text-center">🧩 Match Animal to Habitat</h2>
            <p class="text-gray-400 text-center mb-8">Drag each animal emoji to its correct habitat!</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <h3 class="text-lg font-semibold text-white mb-4">Animals</h3>
                    <div class="space-y-3" id="matchingAnimals">
                        @foreach($matchingPairs as $pair)
                            <div class="glass-card p-3 flex items-center gap-3 cursor-pointer matching-animal" data-match="{{ $pair['match'] }}" onclick="selectAnimalForMatch(this)">
                                <span class="text-2xl">{{ $pair['emoji'] }}</span>
                                <span class="text-white">{{ $pair['animal'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-white mb-4">Habitats</h3>
                    <div class="space-y-3" id="matchingHabitats">
                        @foreach(['Forest', 'Desert', 'Ocean', 'Arctic', 'Savannah'] as $hab)
                            <div class="glass-card p-3 text-center cursor-pointer matching-habitat border-2 border-transparent" data-habitat="{{ $hab }}" onclick="matchToHabitat(this)">
                                <span class="text-white">{{ $hab }}</span>
                                <div class="matched-items text-xs text-zoo-400 mt-1"></div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="text-center mt-6">
                <p id="matchScore" class="text-gray-400"></p>
            </div>
        </div>

        {{-- Puzzle Section --}}
        <div class="glass-card p-8 text-center reveal">
            <span class="text-6xl block mb-4">🧩</span>
            <h2 class="text-2xl font-bold text-white mb-3">Animal Puzzle Challenge</h2>
            <p class="text-gray-400 mb-6">Solve wildlife picture puzzles and test your observation skills!</p>
            <div id="puzzleContainer" class="max-w-md mx-auto">
                <div class="flex justify-between items-center mb-4">
                    <p class="text-zoo-400 font-bold" id="puzzleTargetName">Loading...</p>
                    <button onclick="shufflePuzzle()" class="btn-secondary py-2 px-4 text-sm hover:ring-2 ring-zoo-400 transition-all">🔀 Shuffle</button>
                </div>
                
                <div id="puzzleBoard" class="relative w-full bg-zoo-900 rounded-xl overflow-hidden border-4 border-zoo-800 shadow-2xl mx-auto mb-4" style="aspect-ratio: 1/1; min-height: 300px;">
                    <!-- Tiles will be injected here by JS -->
                </div>

                <div id="puzzleWinMessage" class="hidden bg-green-500/20 border border-green-500 rounded-xl p-4 mb-4 transform transition-all duration-300">
                    <p class="text-green-400 font-bold text-xl">🎉 Puzzle Solved!</p>
                    <p class="text-gray-300 text-sm mt-1">Great job! You fixed the picture.</p>
                </div>
                
                <button onclick="nextPuzzle()" class="btn-primary w-full shadow-lg hover:shadow-zoo-400/50">Next Puzzle →</button>
            </div>
            
            <style>
                #puzzleBoard {
                    display: grid;
                    grid-template-columns: repeat(3, 1fr);
                    grid-template-rows: repeat(3, 1fr);
                    gap: 2px;
                    background-color: #1f2937;
                }
                .puzzle-tile {
                    width: 100%;
                    height: 100%;
                    background-size: 300% 300%;
                    cursor: pointer;
                    transition: transform 0.15s ease-in-out;
                    box-shadow: inset 0 0 10px rgba(0,0,0,0.5);
                }
                .puzzle-tile:hover {
                    opacity: 0.9;
                    transform: scale(0.96);
                    z-index: 10;
                }
                .puzzle-tile.empty {
                    background: rgba(0,0,0,0.5) !important;
                    box-shadow: inset 0 0 20px rgba(0,0,0,0.8);
                    cursor: default;
                }
                .puzzle-tile.empty:hover { transform: none; }
            </style>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    // ===== Guess the Animal Game =====
    const animals = @json($gameAnimals);
    let currentIndex = 0;
    let score = 0;
    let total = 0;

    function shuffleArray(arr) {
        for (let i = arr.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [arr[i], arr[j]] = [arr[j], arr[i]];
        }
        return arr;
    }

    function loadAnimal() {
        if (currentIndex >= animals.length) {
            currentIndex = 0;
            shuffleArray(animals);
        }
        const animal = animals[currentIndex];
        document.getElementById('hintText').textContent = animal.hint;
        document.getElementById('animalEmoji').textContent = '❓';
        document.getElementById('guessImageContainer').classList.add('hidden');
        document.getElementById('guessResult').classList.add('hidden');

        // Generate options
        const options = [animal.name];
        while (options.length < 4) {
            const randomAnimal = animals[Math.floor(Math.random() * animals.length)].name;
            if (!options.includes(randomAnimal)) options.push(randomAnimal);
        }
        shuffleArray(options);

        const optionsHtml = options.map(opt =>
            `<button onclick="guessAnswer('${opt}', '${animal.name}')" class="btn-secondary px-6 py-3 hover:ring-2 hover:ring-zoo-400">${opt}</button>`
        ).join('');
        document.getElementById('guessOptions').innerHTML = optionsHtml;
    }

    function guessAnswer(selected, correct) {
        total++;
        const result = document.getElementById('guessResult');
        const resultText = document.getElementById('resultText');
        const animal = animals[currentIndex];

        result.classList.remove('hidden');
        document.getElementById('animalEmoji').textContent = animal.emoji;
        document.getElementById('guessImage').src = animal.image;
        document.getElementById('guessImageContainer').classList.remove('hidden');

        // Disable options
        document.querySelectorAll('#guessOptions button').forEach(btn => btn.disabled = true);

        if (selected === correct) {
            score++;
            resultText.textContent = '✅ Correct! It\'s the ' + correct + '!';
            resultText.className = 'text-xl font-bold text-green-400';
        } else {
            resultText.textContent = '❌ Wrong! It was the ' + correct + '!';
            resultText.className = 'text-xl font-bold text-red-400';
        }

        document.getElementById('guessScore').textContent = score;
        document.getElementById('guessTotal').textContent = total;
    }

    function nextAnimal() {
        currentIndex++;
        loadAnimal();
    }

    // Initialize
    shuffleArray(animals);
    loadAnimal();

    // ===== Matching Game =====
    let selectedAnimal = null;
    let matchedCount = 0;

    function selectAnimalForMatch(el) {
        document.querySelectorAll('.matching-animal').forEach(a => a.classList.remove('ring-2', 'ring-zoo-400'));
        el.classList.add('ring-2', 'ring-zoo-400');
        selectedAnimal = el;
    }

    function matchToHabitat(el) {
        if (!selectedAnimal) return;

        const animalMatch = selectedAnimal.dataset.match;
        const habitat = el.dataset.habitat;

        if (animalMatch === habitat) {
            matchedCount++;
            const name = selectedAnimal.textContent.trim();
            el.querySelector('.matched-items').textContent += (el.querySelector('.matched-items').textContent ? ', ' : '') + name;
            selectedAnimal.style.opacity = '0.3';
            selectedAnimal.style.pointerEvents = 'none';
            el.style.borderColor = '#22c55e';
            el.style.backgroundColor = 'rgba(34, 197, 94, 0.1)';
            setTimeout(() => {
                el.style.borderColor = 'transparent';
                el.style.backgroundColor = 'transparent';
            }, 1000);
            document.getElementById('matchScore').textContent = `✅ ${matchedCount} matched!`;
        } else {
            el.style.borderColor = '#ef4444';
            el.style.backgroundColor = 'rgba(239, 68, 68, 0.1)';
            setTimeout(() => {
                el.style.borderColor = 'transparent';
                el.style.backgroundColor = 'transparent';
            }, 500);
            document.getElementById('matchScore').textContent = `❌ Try again! ${selectedAnimal.textContent.trim()} doesn't live in ${habitat}`;
        }
        selectedAnimal.classList.remove('ring-2', 'ring-zoo-400');
        selectedAnimal = null;
    }

    // ===== Puzzle Game =====
    const puzzleBoard = document.getElementById('puzzleBoard');
    let puzzleSize = 3;
    let tiles = [];
    let currentPuzzleAnimal = null;
    let isPuzzleSolved = false;

    function initPuzzle() {
        currentPuzzleAnimal = animals[Math.floor(Math.random() * animals.length)];
        document.getElementById('puzzleTargetName').textContent = 'Target: ' + currentPuzzleAnimal.name;
        document.getElementById('puzzleWinMessage').classList.add('hidden');
        isPuzzleSolved = false;
        
        createPuzzleBoard();
        shufflePuzzle();
    }

    function createPuzzleBoard() {
        puzzleBoard.innerHTML = '';
        tiles = [];
        
        for (let i = 0; i < puzzleSize * puzzleSize; i++) {
            const tile = document.createElement('div');
            tile.className = 'puzzle-tile';
            tile.dataset.index = i;
            
            if (i === puzzleSize * puzzleSize - 1) {
                tile.classList.add('empty');
            } else {
                tile.style.backgroundImage = `url('${currentPuzzleAnimal.image}')`;
                const row = Math.floor(i / puzzleSize);
                const col = i % puzzleSize;
                const bgPosX = (col / (puzzleSize - 1)) * 100;
                const bgPosY = (row / (puzzleSize - 1)) * 100;
                tile.style.backgroundPosition = `${bgPosX}% ${bgPosY}%`;
            }
            
            tile.onclick = () => moveTile(i);
            puzzleBoard.appendChild(tile);
            tiles.push(i);
        }
    }

    function renderPuzzle() {
        const DOMTiles = puzzleBoard.querySelectorAll('.puzzle-tile');
        tiles.forEach((correctIndex) => {
            const tileEl = Array.from(DOMTiles).find(el => parseInt(el.dataset.index) === correctIndex);
            puzzleBoard.appendChild(tileEl);
        });
        checkWinCondition();
    }

    function moveTile(clickedActualIndex) {
        if (isPuzzleSolved) return;
        
        const currentIndex = tiles.indexOf(clickedActualIndex);
        const emptyIndex = tiles.indexOf(puzzleSize * puzzleSize - 1);
        
        const row = Math.floor(currentIndex / puzzleSize);
        const col = currentIndex % puzzleSize;
        const emptyRow = Math.floor(emptyIndex / puzzleSize);
        const emptyCol = emptyIndex % puzzleSize;
        
        const isAdjacent = Math.abs(row - emptyRow) + Math.abs(col - emptyCol) === 1;
        
        if (isAdjacent) {
            [tiles[currentIndex], tiles[emptyIndex]] = [tiles[emptyIndex], tiles[currentIndex]];
            renderPuzzle();
        }
    }

    function shufflePuzzle() {
        if (!currentPuzzleAnimal) return;
        isPuzzleSolved = false;
        document.getElementById('puzzleWinMessage').classList.add('hidden');
        
        // Reset empty tile style if it was previously solved
        const emptyTileDOM = puzzleBoard.querySelector('[data-index="8"]');
        if(emptyTileDOM) {
            emptyTileDOM.classList.add('empty');
            emptyTileDOM.style.backgroundImage = 'none';
        }

        // Random valid moves for solvability
        for (let i = 0; i < 100; i++) {
            const emptyIndex = tiles.indexOf(puzzleSize * puzzleSize - 1);
            const row = Math.floor(emptyIndex / puzzleSize);
            const col = emptyIndex % puzzleSize;
            
            let possibleMoves = [];
            if (row > 0) possibleMoves.push(emptyIndex - puzzleSize);
            if (row < puzzleSize - 1) possibleMoves.push(emptyIndex + puzzleSize);
            if (col > 0) possibleMoves.push(emptyIndex - 1);
            if (col < puzzleSize - 1) possibleMoves.push(emptyIndex + 1);
            
            const randomMove = possibleMoves[Math.floor(Math.random() * possibleMoves.length)];
            [tiles[emptyIndex], tiles[randomMove]] = [tiles[randomMove], tiles[emptyIndex]];
        }
        
        // Just in case it randomly shuffled into a solved state (rare but possible)
        let isSolved = true;
        for (let i = 0; i < tiles.length; i++) { if (tiles[i] !== i) isSolved = false; }
        if (isSolved) shufflePuzzle(); 
        else renderPuzzle();
    }

    function checkWinCondition() {
        // Skip checking if it's the very first render before shuffling
        if (tiles.length === 0) return;

        let isWin = true;
        for (let i = 0; i < tiles.length; i++) {
            if (tiles[i] !== i) {
                isWin = false;
                break;
            }
        }
        
        if (isWin && document.getElementById('puzzleBoard').innerHTML !== '') {
            isPuzzleSolved = true;
            document.getElementById('puzzleWinMessage').classList.remove('hidden');
            
            const emptyTile = puzzleBoard.querySelector('.empty');
            if(emptyTile) {
                emptyTile.style.backgroundImage = `url('${currentPuzzleAnimal.image}')`;
                emptyTile.style.backgroundPosition = '100% 100%';
                emptyTile.classList.remove('empty');
            }
        }
    }

    function nextPuzzle() {
        initPuzzle();
    }

    // Init puzzle on load
    document.addEventListener('DOMContentLoaded', () => {
        setTimeout(initPuzzle, 300);
    });
</script>
@endpush
