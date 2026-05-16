<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ZooSphere — 3D Virtual Zoo Experience</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { overflow: hidden; background: #000; font-family: 'Outfit', sans-serif; }

        /* Loading Screen */
        #loading-screen {
            position: fixed; inset: 0; z-index: 10000;
            background: linear-gradient(135deg, #052e16 0%, #0a1f0a 50%, #061206 100%);
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            transition: opacity 1s ease;
        }
        #loading-screen.hidden { opacity: 0; pointer-events: none; }
        #loading-screen h1 {
            font-size: 4rem; font-weight: 900; margin-bottom: 0.5rem;
            background: linear-gradient(135deg, #4ade80, #10b981, #22c55e);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }
        #loading-screen p { color: #86efac; font-size: 1.2rem; margin-bottom: 2rem; }
        .loading-bar-bg {
            width: 300px; height: 6px; background: rgba(255,255,255,0.1); border-radius: 99px; overflow: hidden;
        }
        .loading-bar-fill {
            height: 100%; width: 0%; background: linear-gradient(90deg, #22c55e, #10b981, #4ade80);
            border-radius: 99px; transition: width 0.3s ease;
        }
        #loading-text { color: #6b7280; font-size: 0.875rem; margin-top: 1rem; }

        /* Canvas */
        #zoo-canvas { display: block; width: 100vw; height: 100vh; }

        /* HUD */
        #hud {
            position: fixed; top: 0; left: 0; right: 0; z-index: 100;
            padding: 16px 24px;
            background: linear-gradient(180deg, rgba(0,0,0,0.7) 0%, transparent 100%);
            display: flex; align-items: center; justify-content: space-between;
            pointer-events: none;
        }
        #hud > * { pointer-events: auto; }
        .hud-logo {
            display: flex; align-items: center; gap: 8px; text-decoration: none;
        }
        .hud-logo span:first-child { font-size: 1.5rem; }
        .hud-logo span:last-child {
            font-size: 1.25rem; font-weight: 800;
            background: linear-gradient(135deg, #4ade80, #10b981);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }
        .hud-controls { display: flex; gap: 8px; align-items: center; }
        .hud-btn {
            background: rgba(255,255,255,0.08); backdrop-filter: blur(12px);
            border: 1px solid rgba(255,255,255,0.12); border-radius: 12px;
            color: #e5e7eb; padding: 8px 16px; font-size: 0.8rem; font-weight: 500;
            cursor: pointer; transition: all 0.3s; font-family: 'Outfit', sans-serif;
            display: flex; align-items: center; gap: 6px;
        }
        .hud-btn:hover { background: rgba(34,197,94,0.2); border-color: rgba(34,197,94,0.4); color: #4ade80; }
        .hud-btn.active { background: rgba(34,197,94,0.25); border-color: #22c55e; color: #4ade80; }

        /* Info Panel */
        #info-panel {
            position: fixed; bottom: 24px; left: 50%; transform: translateX(-50%);
            z-index: 200; min-width: 400px; max-width: 600px;
            background: rgba(10,31,10,0.92); backdrop-filter: blur(20px);
            border: 1px solid rgba(34,197,94,0.25); border-radius: 20px;
            padding: 24px; opacity: 0; pointer-events: none;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            transform: translateX(-50%) translateY(20px);
            box-shadow: 0 25px 50px rgba(0,0,0,0.5), 0 0 80px rgba(34,197,94,0.08);
        }
        #info-panel.visible {
            opacity: 1; pointer-events: auto; transform: translateX(-50%) translateY(0);
        }
        .panel-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; }
        .panel-title { font-size: 1.5rem; font-weight: 800; color: #fff; }
        .panel-close {
            background: rgba(255,255,255,0.1); border: none; color: #9ca3af;
            width: 32px; height: 32px; border-radius: 8px; cursor: pointer; font-size: 1.2rem;
            display: flex; align-items: center; justify-content: center; transition: all 0.3s;
        }
        .panel-close:hover { background: rgba(239,68,68,0.2); color: #ef4444; }
        .panel-species { color: #86efac; font-size: 0.85rem; font-style: italic; margin-bottom: 12px; }
        .panel-desc { color: #d1d5db; font-size: 0.9rem; line-height: 1.6; margin-bottom: 16px; }
        .panel-stats {
            display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px;
        }
        .panel-stat {
            background: rgba(255,255,255,0.05); border-radius: 12px; padding: 10px; text-align: center;
        }
        .panel-stat-icon { font-size: 1.2rem; margin-bottom: 4px; }
        .panel-stat-label { font-size: 0.65rem; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.05em; }
        .panel-stat-value { font-size: 0.85rem; color: #fff; font-weight: 600; }
        .panel-badge {
            display: inline-flex; align-items: center; padding: 4px 12px; border-radius: 99px;
            font-size: 0.7rem; font-weight: 600; margin-bottom: 12px;
        }
        .badge-endangered { background: rgba(239,68,68,0.2); color: #f87171; border: 1px solid rgba(239,68,68,0.3); }
        .badge-vulnerable { background: rgba(249,115,22,0.2); color: #fb923c; border: 1px solid rgba(249,115,22,0.3); }
        .badge-least { background: rgba(34,197,94,0.2); color: #4ade80; border: 1px solid rgba(34,197,94,0.3); }

        /* Minimap */
        #minimap {
            position: fixed; bottom: 24px; right: 24px; z-index: 100;
            width: 180px; height: 180px;
            background: rgba(10,31,10,0.85); backdrop-filter: blur(12px);
            border: 1px solid rgba(34,197,94,0.2); border-radius: 16px;
            overflow: hidden;
        }
        #minimap-canvas { width: 100%; height: 100%; }

        /* Controls hint */
        #controls-hint {
            position: fixed; bottom: 24px; left: 24px; z-index: 100;
            background: rgba(10,31,10,0.85); backdrop-filter: blur(12px);
            border: 1px solid rgba(34,197,94,0.15); border-radius: 16px;
            padding: 16px; color: #9ca3af; font-size: 0.75rem;
            line-height: 1.8; max-width: 200px;
            transition: opacity 0.5s ease;
        }
        #controls-hint kbd {
            background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.15);
            border-radius: 4px; padding: 2px 6px; font-family: 'Outfit', monospace;
            color: #d1d5db; font-size: 0.7rem;
        }

        /* Crosshair */
        #crosshair {
            position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%);
            z-index: 50; pointer-events: none; opacity: 0.4;
        }
        #crosshair div {
            position: absolute; background: #4ade80; border-radius: 99px;
        }
        .ch-h { width: 20px; height: 2px; top: -1px; left: -10px; }
        .ch-v { width: 2px; height: 20px; top: -10px; left: -1px; }

        /* Time indicator */
        #time-display {
            position: fixed; top: 70px; right: 24px; z-index: 100;
            background: rgba(10,31,10,0.85); backdrop-filter: blur(12px);
            border: 1px solid rgba(34,197,94,0.15); border-radius: 12px;
            padding: 10px 16px; text-align: center;
        }
        #time-icon { font-size: 1.5rem; }
        #time-label { color: #9ca3af; font-size: 0.7rem; margin-top: 2px; }

        /* Biome label */
        #biome-label {
            position: fixed; top: 70px; left: 50%; transform: translateX(-50%);
            z-index: 100; padding: 8px 24px;
            background: rgba(10,31,10,0.8); backdrop-filter: blur(12px);
            border: 1px solid rgba(34,197,94,0.2); border-radius: 99px;
            color: #86efac; font-weight: 600; font-size: 0.9rem;
            opacity: 0; transition: opacity 0.5s ease;
        }
        #biome-label.visible { opacity: 1; }

        /* Animal label (3D overlay) */
        .animal-label {
            position: absolute; transform: translate(-50%, -100%);
            background: rgba(10,31,10,0.9); backdrop-filter: blur(8px);
            border: 1px solid rgba(34,197,94,0.3); border-radius: 10px;
            padding: 6px 14px; color: #fff; font-size: 0.8rem; font-weight: 600;
            pointer-events: auto; cursor: pointer; white-space: nowrap;
            transition: all 0.3s; z-index: 50;
        }
        .animal-label:hover { background: rgba(34,197,94,0.3); border-color: #22c55e; transform: translate(-50%, -100%) scale(1.05); }
        .animal-label::after {
            content: ''; position: absolute; bottom: -6px; left: 50%; transform: translateX(-50%);
            width: 0; height: 0; border-left: 6px solid transparent;
            border-right: 6px solid transparent; border-top: 6px solid rgba(34,197,94,0.3);
        }

        @media (max-width: 768px) {
            #controls-hint, #minimap { display: none; }
            #info-panel { min-width: 320px; left: 16px; right: 16px; transform: translateX(0); }
            #info-panel.visible { transform: translateY(0); }
            .panel-stats { grid-template-columns: repeat(2, 1fr); }
        }
    </style>
</head>
<body>
    <!-- Loading Screen -->
    <div id="loading-screen">
        <span style="font-size: 5rem; margin-bottom: 1rem; display: flex;"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #4ade80;"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"/><path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/></svg></span>
        <h1>ZooSphere 3D</h1>
        <p>Preparing your virtual zoo experience...</p>
        <div class="loading-bar-bg">
            <div class="loading-bar-fill" id="loading-bar"></div>
        </div>
        <p id="loading-text">Generating terrain...</p>
    </div>

    <!-- 3D Canvas -->
    <canvas id="zoo-canvas"></canvas>

    <!-- HUD -->
    <div id="hud">
        <a href="{{ route('home') }}" class="hud-logo">
            <span style="display:flex;"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #4ade80;"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"/><path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/></svg></span>
            <span>ZooSphere 3D</span>
        </a>
        <div class="hud-controls">
            <button class="hud-btn" onclick="toggleDayNight()" id="btn-daynight"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"/></svg> Night Mode</button>
            <button class="hud-btn" onclick="toggleWeather()" id="btn-weather"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 14.899A7 7 0 1 1 15.71 8h1.79a4.5 4.5 0 0 1 2.5 8.242"/><path d="M16 14v6"/><path d="M8 14v6"/><path d="M12 16v6"/></svg> Weather</button>
            <button class="hud-btn" onclick="toggleSound()" id="btn-sound"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"/><path d="M15.54 8.46a5 5 0 0 1 0 7.07"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14"/></svg> Sound</button>
            <button class="hud-btn" onclick="resetCamera()"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg> Reset View</button>
            <a href="{{ route('zoo-map') }}" class="hud-btn"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="3 6 9 3 15 6 21 3 21 18 15 21 9 18 3 21"/><line x1="9" x2="9" y1="3" y2="18"/><line x1="15" x2="15" y1="6" y2="21"/></svg> 2D Map</a>
            <a href="{{ route('home') }}" class="hud-btn"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg> Exit</a>
        </div>
    </div>

    <!-- Crosshair -->
    <div id="crosshair">
        <div class="ch-h"></div>
        <div class="ch-v"></div>
    </div>

    <!-- Biome Label -->
    <div id="biome-label"></div>

    <!-- Time Display -->
    <div id="time-display">
        <div id="time-icon" style="display:flex; justify-content:center; align-items:center;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #fbbf24;"><circle cx="12" cy="12" r="4"/><path d="M12 2v2"/><path d="M12 20v2"/><path d="m4.93 4.93 1.41 1.41"/><path d="m17.66 17.66 1.41 1.41"/><path d="M2 12h2"/><path d="M20 12h2"/><path d="m6.34 17.66-1.41 1.41"/><path d="m19.07 4.93-1.41 1.41"/></svg></div>
        <div id="time-label">Daytime</div>
    </div>

    <!-- Controls Hint -->
    <div id="controls-hint">
        <strong style="color: #4ade80;">Controls</strong><br>
        <kbd>W</kbd><kbd>A</kbd><kbd>S</kbd><kbd>D</kbd> Move<br>
        <kbd>Mouse</kbd> Look around<br>
        <kbd>Scroll</kbd> Zoom<br>
        <kbd>Click</kbd> on animals<br>
        <kbd>Space</kbd> Jump / Fly up<br>
        <kbd>Shift</kbd> Sprint
    </div>

    <!-- Minimap -->
    <div id="minimap">
        <canvas id="minimap-canvas" width="180" height="180"></canvas>
    </div>

    <!-- Info Panel -->
    <div id="info-panel">
        <div class="panel-header">
            <span class="panel-title" id="panel-title">Lion</span>
            <button class="panel-close" onclick="closePanel()">&times;</button>
        </div>
        <div class="panel-species" id="panel-species">Panthera leo</div>
        <div id="panel-badge-container"></div>
        <div class="panel-desc" id="panel-desc"></div>
        <div class="panel-stats" id="panel-stats"></div>
    </div>

    <!-- Label container for 3D overlays -->
    <div id="label-container" style="position:fixed;top:0;left:0;width:100%;height:100%;pointer-events:none;z-index:50;"></div>

    <!-- Three.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/controls/OrbitControls.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/loaders/GLTFLoader.js"></script>

    <script>
    // ==========================================
    // ZooSphere 3D Virtual Zoo
    // ==========================================

    // Animal data from database
    const animalsData = @json($animals);
    const habitatsData = @json($habitats);

    // Core Three.js
    let scene, camera, renderer, controls;
    let clock = new THREE.Clock();
    let isNight = false;
    let isRaining = false;
    let soundEnabled = false;
    let animalMeshes = [];
    let mixers = []; // For skeletal animations
    let labelElements = [];
    let particles = [];
    let rainParticles = null;
    let sunLight, ambientLight, moonLight;
    let waterMesh;
    
    // Initialize GLTFLoader
    const gltfLoader = new THREE.GLTFLoader();

    // Animal positions per biome
    const biomes = {
        savannah: { center: { x: 0, z: 0 }, color: 0x8B9A46, animals: [] },
        forest: { center: { x: -80, z: -80 }, color: 0x2D5A27, animals: [] },
        arctic: { center: { x: 80, z: -80 }, color: 0xE8EDF0, animals: [] },
        desert: { center: { x: 80, z: 80 }, color: 0xC2B280, animals: [] },
        ocean: { center: { x: -80, z: 80 }, color: 0x1A6B8A, animals: [] },
    };

    // Map animals to biomes based on habitat
    animalsData.forEach(animal => {
        const habitatName = animal.habitat ? animal.habitat.name.toLowerCase() : 'savannah';
        if (habitatName.includes('forest') || habitatName.includes('tropical') || habitatName.includes('jungle')) {
            biomes.forest.animals.push(animal);
        } else if (habitatName.includes('arctic') || habitatName.includes('polar') || habitatName.includes('tundra')) {
            biomes.arctic.animals.push(animal);
        } else if (habitatName.includes('desert') || habitatName.includes('arid')) {
            biomes.desert.animals.push(animal);
        } else if (habitatName.includes('ocean') || habitatName.includes('marine') || habitatName.includes('aquatic')) {
            biomes.ocean.animals.push(animal);
        } else {
            biomes.savannah.animals.push(animal);
        }
    });

    // ==========================================
    // INITIALIZATION
    // ==========================================
    function init() {
        updateLoading(10, 'Setting up scene...');
        // Scene
        scene = new THREE.Scene();
        scene.background = new THREE.Color(0x87ceeb);
        scene.fog = new THREE.FogExp2(0x87ceeb, 0.003);

        // Camera
        camera = new THREE.PerspectiveCamera(60, window.innerWidth / window.innerHeight, 0.5, 1000);
        camera.position.set(0, 30, 60);

        // Renderer
        renderer = new THREE.WebGLRenderer({
            canvas: document.getElementById('zoo-canvas'),
            antialias: true,
            alpha: true
        });
        renderer.setSize(window.innerWidth, window.innerHeight);
        renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
        renderer.shadowMap.enabled = true;
        renderer.shadowMap.type = THREE.PCFSoftShadowMap;
        renderer.toneMapping = THREE.ACESFilmicToneMapping;
        renderer.toneMappingExposure = 1.2;

        // Controls
        controls = new THREE.OrbitControls(camera, renderer.domElement);
        controls.enableDamping = true;
        controls.dampingFactor = 0.05;
        controls.maxPolarAngle = Math.PI / 2.1;
        controls.minDistance = 10;
        controls.maxDistance = 200;
        controls.target.set(0, 0, 0);

        updateLoading(20, 'Creating terrain...');
        createLighting();

        setTimeout(() => {
            updateLoading(30, 'Generating biomes...');
            createTerrain();
            setTimeout(() => {
                updateLoading(50, 'Planting trees & vegetation...');
                createVegetation();
                setTimeout(() => {
                    updateLoading(65, 'Building zoo structures...');
                    createWater();
                    createPaths();
                    createFences();
                    createStructures();
                    setTimeout(() => {
                        updateLoading(80, 'Spawning animals...');
                        createAnimals();
                        setTimeout(() => {
                            updateLoading(90, 'Adding atmosphere...');
                            createAtmosphere();
                            createSky();
                            setTimeout(() => {
                                updateLoading(100, 'Ready! Click to explore');
                                setTimeout(() => {
                                    document.getElementById('loading-screen').classList.add('hidden');
                                    animate();
                                }, 800);
                            }, 200);
                        }, 200);
                    }, 200);
                }, 200);
            }, 200);
        }, 100);

        // Events
        window.addEventListener('resize', onResize);
        renderer.domElement.addEventListener('click', onCanvasClick);

        // Keyboard controls for WASD movement
        setupKeyboardControls();
    }

    function updateLoading(percent, text) {
        document.getElementById('loading-bar').style.width = percent + '%';
        document.getElementById('loading-text').textContent = text;
    }

    // ==========================================
    // LIGHTING
    // ==========================================
    function createLighting() {
        // Ambient light
        ambientLight = new THREE.AmbientLight(0xffffff, 0.6);
        scene.add(ambientLight);

        // Sun (directional light)
        sunLight = new THREE.DirectionalLight(0xfff4e6, 1.2);
        sunLight.position.set(100, 120, 50);
        sunLight.castShadow = true;
        sunLight.shadow.mapSize.width = 2048;
        sunLight.shadow.mapSize.height = 2048;
        sunLight.shadow.camera.near = 0.5;
        sunLight.shadow.camera.far = 500;
        sunLight.shadow.camera.left = -150;
        sunLight.shadow.camera.right = 150;
        sunLight.shadow.camera.top = 150;
        sunLight.shadow.camera.bottom = -150;
        sunLight.shadow.bias = -0.001;
        scene.add(sunLight);

        // Moon (hidden initially)
        moonLight = new THREE.DirectionalLight(0x8888ff, 0.3);
        moonLight.position.set(-80, 100, -50);
        moonLight.visible = false;
        scene.add(moonLight);

        // Hemisphere light for natural sky/ground color
        const hemiLight = new THREE.HemisphereLight(0x87ceeb, 0x2D5A27, 0.4);
        scene.add(hemiLight);
    }

    // ==========================================
    // TERRAIN
    // ==========================================
    function createTerrain() {
        const size = 400;
        const segments = 80;
        const geometry = new THREE.PlaneGeometry(size, size, segments, segments);
        geometry.rotateX(-Math.PI / 2);

        // Vertex displacement for terrain elevation
        const vertices = geometry.attributes.position;
        const colors = [];

        for (let i = 0; i < vertices.count; i++) {
            const x = vertices.getX(i);
            const z = vertices.getZ(i);

            // Gentle hills
            let y = Math.sin(x * 0.02) * 2 + Math.cos(z * 0.03) * 1.5;
            y += Math.sin(x * 0.05 + z * 0.03) * 0.8;

            // Depression for water areas
            const distToWater = Math.sqrt((x + 80) ** 2 + (z - 80) ** 2);
            if (distToWater < 30) {
                y = Math.min(y, -2 - (30 - distToWater) * 0.15);
            }

            // Arctic area - slightly raised
            const distToArctic = Math.sqrt((x - 80) ** 2 + (z + 80) ** 2);
            if (distToArctic < 40) y += 1;

            vertices.setY(i, y);

            // Color based on biome
            let color = new THREE.Color();
            const distToSavannah = Math.sqrt(x ** 2 + z ** 2);
            const distToForest = Math.sqrt((x + 80) ** 2 + (z + 80) ** 2);
            const distToDesert = Math.sqrt((x - 80) ** 2 + (z - 80) ** 2);

            if (distToArctic < 45) {
                color.setHex(0xe8edf0); // Snow white
                const blend = Math.max(0, 1 - distToArctic / 45);
                color.lerp(new THREE.Color(0xc8d4dc), 1 - blend);
            } else if (distToDesert < 45) {
                color.setHex(0xc2b280); // Sand
                color.lerp(new THREE.Color(0xd4c08a), Math.random() * 0.3);
            } else if (distToWater < 35) {
                color.setHex(0x3a7a4a); // Wet grass near water
            } else if (distToForest < 50) {
                color.setHex(0x2d5a27); // Dense forest green
                color.lerp(new THREE.Color(0x1a3a14), Math.random() * 0.3);
            } else {
                color.setHex(0x6b8c42); // Savannah grass
                color.lerp(new THREE.Color(0x8b9a46), Math.random() * 0.3);
            }

            colors.push(color.r, color.g, color.b);
        }

        geometry.setAttribute('color', new THREE.Float32BufferAttribute(colors, 3));
        geometry.computeVertexNormals();

        const material = new THREE.MeshLambertMaterial({
            vertexColors: true,
            side: THREE.DoubleSide
        });

        const terrain = new THREE.Mesh(geometry, material);
        terrain.receiveShadow = true;
        terrain.name = 'terrain';
        scene.add(terrain);
    }

    // ==========================================
    // VEGETATION
    // ==========================================
    function createTree(x, z, type = 'normal') {
        const group = new THREE.Group();
        let trunkHeight, trunkRadius, leavesSize, leavesColor;

        switch (type) {
            case 'palm':
                trunkHeight = 8 + Math.random() * 4;
                trunkRadius = 0.3;
                leavesColor = 0x228B22;
                const trunkGeo = new THREE.CylinderGeometry(trunkRadius * 0.6, trunkRadius, trunkHeight, 6);
                const trunkMat = new THREE.MeshLambertMaterial({ color: 0x8B6914 });
                const trunk = new THREE.Mesh(trunkGeo, trunkMat);
                trunk.position.y = trunkHeight / 2;
                trunk.castShadow = true;
                group.add(trunk);
                // Palm fronds
                for (let i = 0; i < 6; i++) {
                    const frondGeo = new THREE.ConeGeometry(3, 5, 4);
                    const frondMat = new THREE.MeshLambertMaterial({ color: leavesColor });
                    const frond = new THREE.Mesh(frondGeo, frondMat);
                    frond.position.y = trunkHeight + 1;
                    frond.rotation.z = Math.PI / 4;
                    frond.rotation.y = (i / 6) * Math.PI * 2;
                    frond.castShadow = true;
                    group.add(frond);
                }
                break;
            case 'pine':
                trunkHeight = 6 + Math.random() * 3;
                const pineTrunk = new THREE.Mesh(
                    new THREE.CylinderGeometry(0.25, 0.4, trunkHeight, 6),
                    new THREE.MeshLambertMaterial({ color: 0x5c3d2e })
                );
                pineTrunk.position.y = trunkHeight / 2;
                pineTrunk.castShadow = true;
                group.add(pineTrunk);
                for (let j = 0; j < 4; j++) {
                    const coneSize = 3.5 - j * 0.6;
                    const cone = new THREE.Mesh(
                        new THREE.ConeGeometry(coneSize, 3, 6),
                        new THREE.MeshLambertMaterial({ color: 0x1a5c1a })
                    );
                    cone.position.y = trunkHeight - 1 + j * 2;
                    cone.castShadow = true;
                    group.add(cone);
                }
                break;
            case 'cactus':
                const cactusBody = new THREE.Mesh(
                    new THREE.CylinderGeometry(0.4, 0.5, 4 + Math.random() * 3, 8),
                    new THREE.MeshLambertMaterial({ color: 0x2d8a4e })
                );
                cactusBody.position.y = 2;
                cactusBody.castShadow = true;
                group.add(cactusBody);
                // Arms
                const armGeo = new THREE.CylinderGeometry(0.25, 0.3, 2, 6);
                const armMat = new THREE.MeshLambertMaterial({ color: 0x2d8a4e });
                const arm1 = new THREE.Mesh(armGeo, armMat);
                arm1.position.set(0.8, 3, 0);
                arm1.rotation.z = -0.5;
                group.add(arm1);
                const arm2 = new THREE.Mesh(armGeo, armMat);
                arm2.position.set(-0.7, 2.5, 0);
                arm2.rotation.z = 0.6;
                group.add(arm2);
                break;
            default: // Normal tree
                trunkHeight = 4 + Math.random() * 4;
                leavesSize = 3 + Math.random() * 2;
                const nTrunk = new THREE.Mesh(
                    new THREE.CylinderGeometry(0.3, 0.5, trunkHeight, 6),
                    new THREE.MeshLambertMaterial({ color: 0x5c3d2e })
                );
                nTrunk.position.y = trunkHeight / 2;
                nTrunk.castShadow = true;
                group.add(nTrunk);
                // Spherical canopy
                const canopy = new THREE.Mesh(
                    new THREE.SphereGeometry(leavesSize, 8, 6),
                    new THREE.MeshLambertMaterial({
                        color: new THREE.Color().setHSL(0.3 + Math.random() * 0.05, 0.6, 0.25 + Math.random() * 0.15)
                    })
                );
                canopy.position.y = trunkHeight + leavesSize * 0.5;
                canopy.castShadow = true;
                group.add(canopy);
                break;
        }

        const terrainY = getTerrainHeight(x, z);
        group.position.set(x, terrainY, z);
        scene.add(group);
    }

    function createVegetation() {
        // Forest biome - dense trees
        for (let i = 0; i < 60; i++) {
            const angle = Math.random() * Math.PI * 2;
            const radius = 10 + Math.random() * 40;
            const x = biomes.forest.center.x + Math.cos(angle) * radius;
            const z = biomes.forest.center.z + Math.sin(angle) * radius;
            createTree(x, z, Math.random() > 0.3 ? 'normal' : 'pine');
        }
        // Savannah - scattered trees
        for (let i = 0; i < 15; i++) {
            const angle = Math.random() * Math.PI * 2;
            const radius = 15 + Math.random() * 35;
            const x = biomes.savannah.center.x + Math.cos(angle) * radius;
            const z = biomes.savannah.center.z + Math.sin(angle) * radius;
            createTree(x, z, 'normal');
        }
        // Desert - cacti
        for (let i = 0; i < 20; i++) {
            const angle = Math.random() * Math.PI * 2;
            const radius = 10 + Math.random() * 30;
            const x = biomes.desert.center.x + Math.cos(angle) * radius;
            const z = biomes.desert.center.z + Math.sin(angle) * radius;
            createTree(x, z, 'cactus');
        }
        // Ocean biome - palms
        for (let i = 0; i < 12; i++) {
            const angle = Math.random() * Math.PI * 2;
            const radius = 30 + Math.random() * 15;
            const x = biomes.ocean.center.x + Math.cos(angle) * radius;
            const z = biomes.ocean.center.z + Math.sin(angle) * radius;
            createTree(x, z, 'palm');
        }
        // Arctic - a few pines
        for (let i = 0; i < 8; i++) {
            const angle = Math.random() * Math.PI * 2;
            const radius = 30 + Math.random() * 15;
            const x = biomes.arctic.center.x + Math.cos(angle) * radius;
            const z = biomes.arctic.center.z + Math.sin(angle) * radius;
            createTree(x, z, 'pine');
        }

        // Grass patches (instanced)
        createGrassPatches();
    }

    function createGrassPatches() {
        const grassGeo = new THREE.ConeGeometry(0.15, 0.8, 4);
        const grassMat = new THREE.MeshLambertMaterial({ color: 0x4a7a2e });
        const grassInstances = new THREE.InstancedMesh(grassGeo, grassMat, 2000);

        const dummy = new THREE.Object3D();
        for (let i = 0; i < 2000; i++) {
            const x = (Math.random() - 0.5) * 300;
            const z = (Math.random() - 0.5) * 300;
            const y = getTerrainHeight(x, z);
            dummy.position.set(x, y + 0.3, z);
            dummy.rotation.y = Math.random() * Math.PI;
            dummy.scale.set(0.5 + Math.random(), 0.5 + Math.random() * 0.5, 0.5 + Math.random());
            dummy.updateMatrix();
            grassInstances.setMatrixAt(i, dummy.matrix);
        }
        scene.add(grassInstances);
    }

    // ==========================================
    // WATER
    // ==========================================
    function createWater() {
        const waterGeo = new THREE.CircleGeometry(28, 32);
        waterGeo.rotateX(-Math.PI / 2);
        const waterMat = new THREE.MeshPhongMaterial({
            color: 0x1a8aaa,
            transparent: true,
            opacity: 0.35,
            shininess: 100,
            specular: 0x66ccff,
        });
        waterMesh = new THREE.Mesh(waterGeo, waterMat);
        waterMesh.position.set(biomes.ocean.center.x, -1.5, biomes.ocean.center.z);
        waterMesh.receiveShadow = true;
        scene.add(waterMesh);

        // Small pond near forest
        const pondGeo = new THREE.CircleGeometry(8, 24);
        pondGeo.rotateX(-Math.PI / 2);
        const pond = new THREE.Mesh(pondGeo, waterMat.clone());
        pond.position.set(-40, -0.8, -30);
        scene.add(pond);
    }

    // ==========================================
    // PATHS
    // ==========================================
    function createPaths() {
        const pathMat = new THREE.MeshLambertMaterial({ color: 0x8B7355 });

        // Main path connecting biomes - wide road
        const pathPoints = [
            [0, 0], [40, 0], [80, -40], [80, -80], // Savannah to Arctic
            [0, 0], [-40, -40], [-80, -80], // Savannah to Forest
            [0, 0], [40, 40], [80, 80], // Savannah to Desert
            [0, 0], [-40, 40], [-80, 80], // Savannah to Ocean
        ];

        for (let i = 0; i < pathPoints.length - 1; i++) {
            const [x1, z1] = pathPoints[i];
            const [x2, z2] = pathPoints[i + 1];
            if (x1 === 0 && z1 === 0 && i > 0) continue; // Skip duplicate center
            const dx = x2 - x1;
            const dz = z2 - z1;
            const length = Math.sqrt(dx * dx + dz * dz);
            const angle = Math.atan2(dx, dz);

            const pathGeo = new THREE.BoxGeometry(3, 0.15, length);
            const path = new THREE.Mesh(pathGeo, pathMat);
            path.position.set((x1 + x2) / 2, 0.1, (z1 + z2) / 2);
            path.rotation.y = angle;
            path.receiveShadow = true;
            scene.add(path);
        }
    }

    // ==========================================
    // FENCES
    // ==========================================
    function createFences() {
        const fenceMat = new THREE.MeshLambertMaterial({ color: 0x6b4226 });
        const postMat = new THREE.MeshLambertMaterial({ color: 0x5a3520 });

        Object.values(biomes).forEach(biome => {
            const cx = biome.center.x;
            const cz = biome.center.z;
            const radius = 38;
            const segments = 20;

            for (let i = 0; i < segments; i++) {
                const angle = (i / segments) * Math.PI * 2;
                const nextAngle = ((i + 1) / segments) * Math.PI * 2;

                // Fence post
                const px = cx + Math.cos(angle) * radius;
                const pz = cz + Math.sin(angle) * radius;
                const py = getTerrainHeight(px, pz);

                const post = new THREE.Mesh(
                    new THREE.CylinderGeometry(0.15, 0.15, 2.5, 4),
                    postMat
                );
                post.position.set(px, py + 1.25, pz);
                post.castShadow = true;
                scene.add(post);

                // Fence rail
                const nx = cx + Math.cos(nextAngle) * radius;
                const nz = cz + Math.sin(nextAngle) * radius;
                const dist = Math.sqrt((nx - px) ** 2 + (nz - pz) ** 2);
                const railAngle = Math.atan2(nx - px, nz - pz);

                const rail = new THREE.Mesh(
                    new THREE.BoxGeometry(0.1, 0.12, dist),
                    fenceMat
                );
                rail.position.set((px + nx) / 2, py + 1.8, (pz + nz) / 2);
                rail.rotation.y = railAngle;
                scene.add(rail);

                const rail2 = rail.clone();
                rail2.position.y = py + 1;
                scene.add(rail2);
            }
        });
    }

    // ==========================================
    // STRUCTURES (Entrance, Signs, Benches)
    // ==========================================
    function createStructures() {
        // Entrance gate
        const gateMat = new THREE.MeshLambertMaterial({ color: 0x3a2a1a });
        const accentMat = new THREE.MeshLambertMaterial({ color: 0x22c55e });

        // Gate pillars
        const pillar1 = new THREE.Mesh(new THREE.BoxGeometry(2, 10, 2), gateMat);
        pillar1.position.set(-6, 5, 55);
        pillar1.castShadow = true;
        scene.add(pillar1);

        const pillar2 = pillar1.clone();
        pillar2.position.x = 6;
        scene.add(pillar2);

        // Gate arch
        const arch = new THREE.Mesh(new THREE.BoxGeometry(16, 2, 2), accentMat);
        arch.position.set(0, 10, 55);
        arch.castShadow = true;
        scene.add(arch);

        // Gate sign decoration with 'ZooSphere' text
        const canvas = document.createElement('canvas');
        canvas.width = 512;
        canvas.height = 128;
        const ctx = canvas.getContext('2d');
        ctx.fillStyle = '#0d2818'; // Dark green background
        ctx.fillRect(0, 0, 512, 128);
        ctx.fillStyle = '#4ade80'; // Vibrant green text
        ctx.font = 'bold 70px "Outfit", Arial, sans-serif';
        ctx.textAlign = 'center';
        ctx.textBaseline = 'middle';
        ctx.fillText('ZooSphere', 256, 64);
        
        const textTexture = new THREE.CanvasTexture(canvas);
        const signMatFront = new THREE.MeshLambertMaterial({ map: textTexture });
        const signMatPlain = new THREE.MeshLambertMaterial({ color: 0x0d2818 });
        
        // BoxGeometry materials: +x, -x, +y, -y, +z, -z. The front face facing the user is +z (index 4).
        const signMaterials = [
            signMatPlain, signMatPlain, signMatPlain, signMatPlain, signMatFront, signMatPlain
        ];

        const signBoard = new THREE.Mesh(new THREE.BoxGeometry(10, 3, 0.3), signMaterials);
        signBoard.position.set(0, 12.5, 55);
        scene.add(signBoard);

        // Biome signs
        Object.entries(biomes).forEach(([name, biome]) => {
            const sign = new THREE.Group();
            const post = new THREE.Mesh(
                new THREE.CylinderGeometry(0.2, 0.2, 3, 6),
                new THREE.MeshLambertMaterial({ color: 0x5c3d2e })
            );
            post.position.y = 1.5;
            sign.add(post);

            const board = new THREE.Mesh(
                new THREE.BoxGeometry(4, 1.5, 0.2),
                new THREE.MeshLambertMaterial({ color: 0x2D5A27 })
            );
            board.position.y = 3.5;
            sign.add(board);

            const y = getTerrainHeight(biome.center.x, biome.center.z + 35);
            sign.position.set(biome.center.x, y, biome.center.z + 35);
            scene.add(sign);
        });

        // Benches
        for (let i = 0; i < 8; i++) {
            const angle = (i / 8) * Math.PI * 2;
            const bx = Math.cos(angle) * 20;
            const bz = Math.sin(angle) * 20;
            createBench(bx, bz, angle);
        }
    }

    function createBench(x, z, rotation) {
        const group = new THREE.Group();
        const woodMat = new THREE.MeshLambertMaterial({ color: 0x8B6914 });
        const metalMat = new THREE.MeshLambertMaterial({ color: 0x555555 });

        // Seat
        const seat = new THREE.Mesh(new THREE.BoxGeometry(2.5, 0.15, 0.8), woodMat);
        seat.position.y = 0.8;
        group.add(seat);

        // Back
        const back = new THREE.Mesh(new THREE.BoxGeometry(2.5, 0.8, 0.1), woodMat);
        back.position.set(0, 1.3, -0.35);
        group.add(back);

        // Legs
        [[-1, 0.4, -0.3], [1, 0.4, -0.3], [-1, 0.4, 0.3], [1, 0.4, 0.3]].forEach(pos => {
            const leg = new THREE.Mesh(new THREE.CylinderGeometry(0.05, 0.05, 0.8, 4), metalMat);
            leg.position.set(...pos);
            group.add(leg);
        });

        const y = getTerrainHeight(x, z);
        group.position.set(x, y, z);
        group.rotation.y = rotation;
        group.castShadow = true;
        scene.add(group);
    }

    // ==========================================
    // ANIMALS (Custom Low-Poly / Voxel)
    // ==========================================
    function createAnimals() {
        Object.entries(biomes).forEach(([biomeName, biome]) => {
            biome.animals.forEach((animal, index) => {
                const angle = (index / Math.max(biome.animals.length, 1)) * Math.PI * 2;
                const radius = 10 + Math.random() * 15;
                const x = biome.center.x + Math.cos(angle) * radius;
                const z = biome.center.z + Math.sin(angle) * radius;
                buildCustomAnimal(animal, x, z, biomeName);
            });
        });
    }

    function createBox(w, h, d, color, x=0, y=0, z=0) {
        const mat = new THREE.MeshLambertMaterial({ color: color });
        const mesh = new THREE.Mesh(new THREE.BoxGeometry(w, h, d), mat);
        mesh.position.set(x, y, z);
        mesh.castShadow = true;
        mesh.receiveShadow = true;
        return mesh;
    }

    function addLegs(group, color, w, h, d, spaceX, spaceZ, yOffset) {
        const legs = [];
        const offsets = [[-1, -1], [1, -1], [-1, 1], [1, 1]];
        offsets.forEach(([dirX, dirZ]) => {
            const leg = createBox(w, h, d, color, dirX * spaceX, yOffset, dirZ * spaceZ);
            group.add(leg);
            legs.push(leg);
        });
        group.userData.legs = legs;
    }

    function buildLion(group) {
        const bodyCol = 0xcc9933;
        const maneCol = 0x663300;
        group.add(createBox(1.2, 0.8, 2.0, bodyCol, 0, 1.2, 0)); // Body
        group.add(createBox(0.8, 0.8, 0.8, bodyCol, 0, 1.8, 1.1)); // Head
        group.add(createBox(1.4, 1.4, 0.8, maneCol, 0, 1.7, 0.8)); // Mane
        group.add(createBox(0.4, 0.3, 0.3, 0xffeebb, 0, 1.6, 1.55)); // Snout
        const tail = createBox(0.1, 1.0, 0.1, bodyCol, 0, 1.2, -1.0);
        tail.rotation.x = Math.PI / 4;
        group.add(tail);
        addLegs(group, bodyCol, 0.3, 0.8, 0.3, 0.4, 0.7, 0.4);
    }

    function buildElephant(group) {
        const col = 0x8899aa;
        group.add(createBox(2.2, 1.8, 3.0, col, 0, 1.8, 0)); // Body
        group.add(createBox(1.2, 1.2, 1.2, col, 0, 2.2, 1.8)); // Head
        group.add(createBox(0.2, 1.5, 1.0, col, 0.7, 2.2, 1.5)); // Ear R
        group.add(createBox(0.2, 1.5, 1.0, col, -0.7, 2.2, 1.5)); // Ear L
        const trunk = createBox(0.4, 1.5, 0.4, col, 0, 1.2, 2.5);
        group.add(trunk);
        group.userData.trunk = trunk;
        const tusk1 = createBox(0.1, 0.8, 0.1, 0xffffff, 0.3, 1.5, 2.4);
        tusk1.rotation.x = Math.PI/4; group.add(tusk1);
        const tusk2 = createBox(0.1, 0.8, 0.1, 0xffffff, -0.3, 1.5, 2.4);
        tusk2.rotation.x = Math.PI/4; group.add(tusk2);
        addLegs(group, col, 0.6, 1.0, 0.6, 0.8, 1.0, 0.5);
    }

    function buildZebra(group) {
        const col = 0xffffff;
        const black = 0x222222;
        group.add(createBox(1.0, 0.8, 0.4, col, 0, 1.2, 0.8));
        group.add(createBox(1.0, 0.8, 0.4, black, 0, 1.2, 0.4));
        group.add(createBox(1.0, 0.8, 0.4, col, 0, 1.2, 0.0));
        group.add(createBox(1.0, 0.8, 0.4, black, 0, 1.2, -0.4));
        group.add(createBox(1.0, 0.8, 0.4, col, 0, 1.2, -0.8));
        group.add(createBox(0.4, 1.0, 0.4, col, 0, 2.0, 1.0)); // Neck
        group.add(createBox(0.4, 0.4, 0.6, black, 0, 2.3, 1.3)); // Snout
        addLegs(group, col, 0.2, 0.8, 0.2, 0.3, 0.7, 0.4);
    }

    function buildGiraffe(group) {
        const col = 0xddaa55;
        const spots = 0x884411;
        group.add(createBox(1.2, 1.2, 2.0, col, 0, 2.0, 0));
        group.add(createBox(1.3, 0.8, 1.5, spots, 0, 2.0, 0));
        const neck = createBox(0.5, 2.5, 0.5, col, 0, 3.5, 0.8);
        neck.rotation.x = -0.2; group.add(neck);
        group.add(createBox(0.5, 0.5, 0.8, col, 0, 4.8, 1.2)); // Head
        group.add(createBox(0.05, 0.3, 0.05, spots, 0.15, 5.2, 1.0)); // Horns
        group.add(createBox(0.05, 0.3, 0.05, spots, -0.15, 5.2, 1.0));
        addLegs(group, col, 0.3, 1.5, 0.3, 0.4, 0.8, 0.75);
    }

    function buildDolphin(group) {
        const col = 0x6699cc;
        group.add(createBox(0.8, 0.8, 2.5, col, 0, 0.4, 0)); // Body
        group.add(createBox(0.3, 0.3, 0.8, col, 0, 0.4, 1.5)); // Snout
        group.add(createBox(0.1, 0.6, 0.6, col, 0, 1.0, -0.2)); // Dorsal
        group.add(createBox(1.2, 0.1, 0.5, col, 0, 0.4, -1.4)); // Tail
        const f1 = createBox(0.8, 0.1, 0.4, col, 0.6, 0.3, 0.5);
        const f2 = createBox(0.8, 0.1, 0.4, col, -0.6, 0.3, 0.5);
        group.add(f1); group.add(f2);
        group.userData.flippers = [f1, f2];
    }

    function buildBird(group) {
        const col = 0xff4444; 
        const wings = 0x2288cc;
        group.add(createBox(0.5, 0.5, 1.0, col, 0, 0, 0)); // Body
        group.add(createBox(0.4, 0.4, 0.4, col, 0, 0.3, 0.6)); // Head
        group.add(createBox(0.1, 0.1, 0.3, 0xffff00, 0, 0.3, 0.9)); // Beak
        const w1 = createBox(0.8, 0.1, 0.6, wings, 0.6, 0.1, 0);
        const w2 = createBox(0.8, 0.1, 0.6, wings, -0.6, 0.1, 0);
        group.add(w1); group.add(w2);
        group.userData.wings = [w1, w2];
    }

    function buildBear(group, isPolar) {
        const col = isPolar ? 0xffffff : 0x5c4033;
        group.add(createBox(1.4, 1.2, 2.0, col, 0, 1.2, 0));
        group.add(createBox(0.8, 0.8, 0.8, col, 0, 1.6, 1.2));
        group.add(createBox(0.4, 0.4, 0.4, 0x000000, 0, 1.5, 1.6)); // Snout
        group.add(createBox(0.2, 0.2, 0.1, col, 0.4, 2.0, 1.0)); // Ears
        group.add(createBox(0.2, 0.2, 0.1, col, -0.4, 2.0, 1.0));
        addLegs(group, col, 0.4, 0.8, 0.4, 0.5, 0.8, 0.6);
    }
    
    function buildPenguin(group) {
        const black = 0x111111; const white = 0xffffff;
        group.add(createBox(0.8, 1.2, 0.6, black, 0, 0.9, 0)); // Body
        group.add(createBox(0.6, 1.0, 0.1, white, 0, 0.9, 0.35)); // Belly
        group.add(createBox(0.6, 0.6, 0.6, black, 0, 1.8, 0)); // Head
        group.add(createBox(0.2, 0.1, 0.3, 0xffa500, 0, 1.8, 0.4)); // Beak
        const w1 = createBox(0.2, 0.8, 0.3, black, 0.5, 1.0, 0);
        const w2 = createBox(0.2, 0.8, 0.3, black, -0.5, 1.0, 0);
        group.add(w1); group.add(w2);
        group.userData.wings = [w1, w2];
        group.add(createBox(0.3, 0.1, 0.4, 0xffa500, 0.2, 0.05, 0.2));
        group.add(createBox(0.3, 0.1, 0.4, 0xffa500, -0.2, 0.05, 0.2));
    }

    function buildGenericAnimal(group, biomeName) {
        const color = biomes[biomeName] ? biomes[biomeName].color : 0x888888;
        group.add(createBox(1.0, 0.8, 1.5, color, 0, 0.8, 0));
        group.add(createBox(0.6, 0.6, 0.6, color, 0, 1.2, 0.8)); // Head
        addLegs(group, color, 0.2, 0.6, 0.2, 0.3, 0.5, 0.3);
    }

    function buildCamel(group) {
        const col = 0xc19a6b; // Camel brown/tan
        group.add(createBox(1.2, 1.0, 2.0, col, 0, 1.5, 0)); // Body
        group.add(createBox(0.8, 0.8, 0.8, col, 0, 2.2, -0.4)); // Hump 1
        group.add(createBox(0.8, 0.8, 0.8, col, 0, 2.2, 0.6)); // Hump 2
        
        const neck = createBox(0.4, 1.5, 0.5, col, 0, 2.0, 1.2);
        neck.rotation.x = -0.3; 
        group.add(neck); // Neck
        
        group.add(createBox(0.6, 0.6, 0.8, col, 0, 2.8, 1.6)); // Head
        group.add(createBox(0.4, 0.4, 0.6, col, 0, 2.7, 2.0)); // Snout
        
        addLegs(group, col, 0.3, 1.2, 0.3, 0.4, 0.8, 0.6);
    }

    const glbModels = {
        flamingo: '/models/Flamingo.glb',
        horse: '/models/Horse.glb',
        parrot: '/models/Parrot.glb',
        stork: '/models/Stork.glb'
    };

    function buildCustomAnimal(animalData, x, z, biomeName) {
        const species = animalData.name.toLowerCase();
        let isFlying = false;

        let glbMatch = null;
        if (species.includes('flamingo')) glbMatch = 'flamingo';
        else if (species.includes('horse') || species.includes('zebra')) glbMatch = 'horse';
        else if (species.includes('parrot')) glbMatch = 'parrot';
        else if (species.includes('stork') || species.includes('bird') || species.includes('eagle')) glbMatch = 'stork';

        if (species.includes('flamingo') || species.includes('parrot') || species.includes('stork') || species.includes('bird') || species.includes('eagle')) {
            isFlying = true;
        }

        const terrainY = getTerrainHeight(x, z);
        const finalY = isFlying ? terrainY + 12 + Math.random() * 8 : terrainY;
        
        const setupGroup = (group) => {
            group.position.set(x, finalY, z);
            group.scale.set(0.8, 0.8, 0.8);
            group.userData = {
                animalData: animalData,
                biomeName: biomeName,
                animPhase: Math.random() * Math.PI * 2,
                idleSpeed: 0.5 + Math.random() * 0.5,
                moveRadius: 10 + Math.random() * 15,
                baseX: x,
                baseZ: z,
                baseY: finalY,
                isFlying: isFlying,
                species: species
            };
            scene.add(group);
            animalMeshes.push(group);
            createAnimalLabel(group, animalData);
        };

        if (glbMatch) {
            const group = new THREE.Group();
            gltfLoader.load(glbModels[glbMatch], (gltf) => {
                const model = gltf.scene;
                let s = 0.05;
                if (glbMatch === 'horse') s = 0.02;
                if (glbMatch === 'parrot') s = 0.05;
                if (glbMatch === 'flamingo') s = 0.04;
                if (glbMatch === 'stork') s = 0.04;
                model.scale.set(s, s, s);
                
                model.traverse((child) => {
                    if (child.isMesh) {
                        child.castShadow = true;
                        child.receiveShadow = true;
                    }
                });

                group.add(model);
                
                if (gltf.animations && gltf.animations.length > 0) {
                    const mixer = new THREE.AnimationMixer(model);
                    const action = mixer.clipAction(gltf.animations[0]);
                    action.play();
                    group.userData.mixer = mixer;
                }
            });
            setupGroup(group);
            return;
        }

        const group = new THREE.Group();
        // Route to the correct procedural builder
        if (species.includes('lion')) buildLion(group);
        else if (species.includes('elephant')) buildElephant(group);
        else if (species.includes('giraffe')) buildGiraffe(group);
        else if (species.includes('penguin')) buildPenguin(group);
        else if (species.includes('camel')) buildCamel(group);
        else if (species.includes('bear') || species.includes('polar')) buildBear(group, species.includes('polar'));
        else if (species.includes('dolphin') || species.includes('whale') || species.includes('fish')) buildDolphin(group);
        else buildGenericAnimal(group, biomeName);

        setupGroup(group);
    }

    function createAnimalLabel(mesh, data) {
        const label = document.createElement('div');
        label.className = 'animal-label';
        label.innerHTML = `${getAnimalEmoji(data.name)} ${data.name}`;
        label.onclick = () => showAnimalInfo(data);
        document.getElementById('label-container').appendChild(label);
        labelElements.push({ element: label, mesh: mesh });
    }

    function getAnimalEmoji(name) {
        return `<span style="display:inline-flex;align-items:center;vertical-align:middle;margin-right:4px;"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 11c-1.3 0-2.3-1.6-2.3-3.6S9.7 3.8 11 3.8s2.3 1.6 2.3 3.6-1 3.6-2.3 3.6Z"/><path d="M5.3 12.3C4.1 11.5 3.3 10 3.3 8.3s.9-3 2.1-3.7 2.4-.4 3.5.4 1.8 2.2 1.8 3.9-.8 3.1-2 3.9c-1.1.8-2.3.6-3.4-.5Z"/><path d="M18.7 12.3c1.2-.8 2-2.3 2-4s-.9-3-2.1-3.7-2.4-.4-3.5.4-1.8 2.2-1.8 3.9.8 3.1 2 3.9c1.1.8 2.3.6 3.4-.5Z"/><path d="M12 14.5c-2.8 0-5.3 1.6-6.4 4-.9 1.9-.3 4.2 1.6 5.1 1 .5 2.1.4 3.1-.2 1.1-.7 2.2-.7 3.4 0 1 .6 2.1.7 3.1.2 1.9-.9 2.5-3.2 1.6-5.1-1.1-2.4-3.6-4-6.4-4Z"/></svg></span>`;
    }

    // ==========================================
    // ATMOSPHERE (Particles, Sky)
    // ==========================================
    function createAtmosphere() {
        // Fireflies / floating particles
        const particleGeo = new THREE.BufferGeometry();
        const positions = [];
        const particleColors = [];

        for (let i = 0; i < 300; i++) {
            positions.push(
                (Math.random() - 0.5) * 300,
                3 + Math.random() * 20,
                (Math.random() - 0.5) * 300
            );
            const c = new THREE.Color().setHSL(0.3 + Math.random() * 0.1, 0.8, 0.6);
            particleColors.push(c.r, c.g, c.b);
        }

        particleGeo.setAttribute('position', new THREE.Float32BufferAttribute(positions, 3));
        particleGeo.setAttribute('color', new THREE.Float32BufferAttribute(particleColors, 3));

        const particleMat = new THREE.PointsMaterial({
            size: 0.4,
            vertexColors: true,
            transparent: true,
            opacity: 0.6,
            blending: THREE.AdditiveBlending,
            depthWrite: false,
        });

        const part = new THREE.Points(particleGeo, particleMat);
        part.name = 'fireflies';
        scene.add(part);

        // Snow particles for arctic zone
        const snowGeo = new THREE.BufferGeometry();
        const snowPositions = [];
        for (let i = 0; i < 500; i++) {
            snowPositions.push(
                biomes.arctic.center.x + (Math.random() - 0.5) * 80,
                5 + Math.random() * 30,
                biomes.arctic.center.z + (Math.random() - 0.5) * 80
            );
        }
        snowGeo.setAttribute('position', new THREE.Float32BufferAttribute(snowPositions, 3));

        const snowMat = new THREE.PointsMaterial({
            size: 0.3,
            color: 0xffffff,
            transparent: true,
            opacity: 0.8,
        });

        const snow = new THREE.Points(snowGeo, snowMat);
        snow.name = 'snow';
        scene.add(snow);
    }

    function createSky() {
        // Sun sphere
        const sunGeo = new THREE.SphereGeometry(5, 16, 8);
        const sunMat = new THREE.MeshBasicMaterial({ color: 0xfff4c4 });
        const sun = new THREE.Mesh(sunGeo, sunMat);
        sun.position.copy(sunLight.position);
        sun.name = 'sun';
        scene.add(sun);

        // Clouds
        for (let i = 0; i < 15; i++) {
            const cloudGroup = new THREE.Group();
            const cloudMat = new THREE.MeshLambertMaterial({
                color: 0xffffff,
                transparent: true,
                opacity: 0.7,
            });

            for (let j = 0; j < 3 + Math.floor(Math.random() * 4); j++) {
                const puff = new THREE.Mesh(
                    new THREE.SphereGeometry(3 + Math.random() * 4, 8, 6),
                    cloudMat
                );
                puff.position.set(j * 4, Math.random() * 2, Math.random() * 3);
                puff.scale.y = 0.6;
                cloudGroup.add(puff);
            }

            cloudGroup.position.set(
                (Math.random() - 0.5) * 400,
                60 + Math.random() * 30,
                (Math.random() - 0.5) * 400
            );
            cloudGroup.name = 'cloud';
            scene.add(cloudGroup);
        }
    }

    function createRain() {
        if (rainParticles) return;
        const rainGeo = new THREE.BufferGeometry();
        const rainPositions = [];
        for (let i = 0; i < 5000; i++) {
            rainPositions.push(
                (Math.random() - 0.5) * 300,
                Math.random() * 80,
                (Math.random() - 0.5) * 300
            );
        }
        rainGeo.setAttribute('position', new THREE.Float32BufferAttribute(rainPositions, 3));
        const rainMat = new THREE.PointsMaterial({
            color: 0xaaaaee,
            size: 0.2,
            transparent: true,
            opacity: 0.5,
        });
        rainParticles = new THREE.Points(rainGeo, rainMat);
        rainParticles.name = 'rain';
        scene.add(rainParticles);
    }

    function removeRain() {
        if (rainParticles) {
            scene.remove(rainParticles);
            rainParticles = null;
        }
    }

    // ==========================================
    // ANIMATION LOOP
    // ==========================================
    function animate() {
        requestAnimationFrame(animate);
        const delta = clock.getDelta();
        const elapsed = clock.getElapsedTime();

        controls.update();

        // Animate animals (movement in scene + skeletal voxel animations)
        animalMeshes.forEach(mesh => {
            if(!mesh.userData) return;
            const data = mesh.userData;
            const phase = data.animPhase;
            const speed = data.idleSpeed;
            const t = elapsed * speed;

            // Idle movement - circular wandering
            mesh.position.x = data.baseX + Math.sin(t * 0.3 + phase) * data.moveRadius;
            mesh.position.z = data.baseZ + Math.cos(t * 0.4 + phase) * data.moveRadius;

            // Subtle bobbing (if flying or swimming)
            if(data.isFlying || data.species.includes('dolphin') || data.species.includes('whale') || data.species.includes('fish')) {
                mesh.position.y = data.baseY + Math.sin(t * 2 + phase) * 2;
            } else {
                mesh.position.y = data.baseY + Math.abs(Math.sin(t * 4 + phase)) * 0.2; // Walk bounce
            }

            // Face movement direction
            const dx = Math.cos(t * 0.3 + phase) * data.moveRadius * speed * 0.3;
            const dz = -Math.sin(t * 0.4 + phase) * data.moveRadius * speed * 0.4;
            
            if (Math.abs(dx) > 0.01 || Math.abs(dz) > 0.01) {
                // Models face +Z by default
                mesh.rotation.y = Math.atan2(dx, dz);
            }

            // Custom Voxel Skeletal Animations
            if (data.mixer) {
                data.mixer.update(delta);
            }

            if (data.legs && data.legs.length === 4) {
                data.legs[0].rotation.x = Math.sin(t * 5 + phase) * 0.5; // Front Left
                data.legs[1].rotation.x = -Math.sin(t * 5 + phase) * 0.5; // Front Right
                data.legs[2].rotation.x = -Math.sin(t * 5 + phase) * 0.5; // Back Left
                data.legs[3].rotation.x = Math.sin(t * 5 + phase) * 0.5; // Back Right
            }

            if (data.wings && data.wings.length === 2) {
                data.wings[0].rotation.z = Math.sin(t * 10) * 0.5 - 0.5; // Wing Left
                data.wings[1].rotation.z = -Math.sin(t * 10) * 0.5 + 0.5; // Wing Right
            }

            if (data.trunk) {
                data.trunk.rotation.x = Math.sin(t * 2) * 0.2;
            }

            if (data.flippers && data.flippers.length === 2) {
                data.flippers[0].rotation.z = Math.sin(t * 3) * 0.2;
                data.flippers[1].rotation.z = -Math.sin(t * 3) * 0.2;
            }
        });

        // Animate water
        if (waterMesh) {
            waterMesh.position.y = -1.5 + Math.sin(elapsed * 0.5) * 0.1;
        }

        // Animate snow
        const snow = scene.getObjectByName('snow');
        if (snow) {
            const positions = snow.geometry.attributes.position;
            for (let i = 0; i < positions.count; i++) {
                let y = positions.getY(i);
                y -= delta * 3;
                if (y < 0) y = 30;
                positions.setY(i, y);
                positions.setX(i, positions.getX(i) + Math.sin(elapsed + i) * delta * 0.5);
            }
            positions.needsUpdate = true;
        }

        // Animate fireflies
        const fireflies = scene.getObjectByName('fireflies');
        if (fireflies) {
            const positions = fireflies.geometry.attributes.position;
            for (let i = 0; i < positions.count; i++) {
                positions.setY(i, positions.getY(i) + Math.sin(elapsed * 0.5 + i * 0.1) * delta * 0.5);
            }
            positions.needsUpdate = true;
            fireflies.material.opacity = isNight ? 0.9 : 0.2;
        }

        // Animate rain
        if (rainParticles) {
            const positions = rainParticles.geometry.attributes.position;
            for (let i = 0; i < positions.count; i++) {
                let y = positions.getY(i);
                y -= delta * 40;
                if (y < 0) y = 80;
                positions.setY(i, y);
            }
            positions.needsUpdate = true;
        }

        // Animate clouds
        scene.children.filter(c => c.name === 'cloud').forEach(cloud => {
            cloud.position.x += delta * 2;
            if (cloud.position.x > 200) cloud.position.x = -200;
        });

        // Update labels
        updateLabels();

        // Update biome label
        updateBiomeLabel();

        // Update minimap
        updateMinimap();

        renderer.render(scene, camera);
    }

    // ==========================================
    // LABEL SYSTEM
    // ==========================================
    function updateLabels() {
        const halfWidth = window.innerWidth / 2;
        const halfHeight = window.innerHeight / 2;

        labelElements.forEach(({ element, mesh }) => {
            const pos = new THREE.Vector3();
            pos.copy(mesh.position);
            pos.y += 5; // Above the animal

            const dist = camera.position.distanceTo(mesh.position);
            if (dist > 80) {
                element.style.display = 'none';
                return;
            }

            pos.project(camera);

            const x = (pos.x * halfWidth) + halfWidth;
            const y = -(pos.y * halfHeight) + halfHeight;

            if (pos.z > 1 || x < -100 || x > window.innerWidth + 100 || y < -50 || y > window.innerHeight + 50) {
                element.style.display = 'none';
            } else {
                element.style.display = 'block';
                element.style.left = x + 'px';
                element.style.top = y + 'px';
                const scale = Math.max(0.6, Math.min(1, 40 / dist));
                element.style.transform = `translate(-50%, -100%) scale(${scale})`;
            }
        });
    }

    // ==========================================
    // BIOME DETECTION
    // ==========================================
    function updateBiomeLabel() {
        const camX = camera.position.x;
        const camZ = camera.position.z;
        let closestBiome = '';
        let closestDist = Infinity;

        Object.entries(biomes).forEach(([name, biome]) => {
            const dist = Math.sqrt((camX - biome.center.x) ** 2 + (camZ - biome.center.z) ** 2);
            if (dist < closestDist) { closestDist = dist; closestBiome = name; }
        });

        const label = document.getElementById('biome-label');
        const icons = {
            savannah: '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22v-6"/><path d="M12 16L7 22"/><path d="M12 16l5 6"/><path d="M12 8 4 16h16Z"/><path d="m12 2-6 8h12Z"/></svg>',
            forest: '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22v-6"/><path d="M12 16L7 22"/><path d="M12 16l5 6"/><path d="M12 8 4 16h16Z"/><path d="m12 2-6 8h12Z"/></svg>',
            arctic: '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m10 20-3-3 3-3"/><path d="m14 4 3 3-3 3"/><path d="M12 2v20"/><path d="m20 10-3 3 3 3"/><path d="m4 14 3-3-3-3"/><path d="M2 12h20"/><path d="m17 17-2.8-2.8"/><path d="m7 7 2.8 2.8"/><path d="m17 7-2.8 2.8"/><path d="m7 17 2.8-2.8"/></svg>',
            desert: '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="4"/><path d="M12 2v2"/><path d="M12 20v2"/><path d="m4.93 4.93 1.41 1.41"/><path d="m17.66 17.66 1.41 1.41"/><path d="M2 12h2"/><path d="M20 12h2"/><path d="m6.34 17.66-1.41 1.41"/><path d="m19.07 4.93-1.41 1.41"/></svg>',
            ocean: '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 6c.6.5 1.2 1 2.5 1C7 7 7 5 9.5 5c2.6 0 2.6 2 5 2 2.3 0 2.3-2 5-2 1.3 0 1.9.5 2.5 1"/><path d="M2 12c.6.5 1.2 1 2.5 1 2.5 0 2.5-2 5-2 2.6 0 2.6 2 5 2 2.3 0 2.3-2 5-2 1.3 0 1.9.5 2.5 1"/><path d="M2 18c.6.5 1.2 1 2.5 1 2.5 0 2.5-2 5-2 2.6 0 2.6 2 5 2 2.3 0 2.3-2 5-2 1.3 0 1.9.5 2.5 1"/></svg>'
        };
        if (closestDist < 60) {
            label.innerHTML = `<span style="display:inline-flex;align-items:center;gap:6px;">${icons[closestBiome]} ${closestBiome.charAt(0).toUpperCase() + closestBiome.slice(1)} Zone</span>`;
            label.classList.add('visible');
        } else {
            label.classList.remove('visible');
        }
    }

    // ==========================================
    // MINIMAP
    // ==========================================
    function updateMinimap() {
        const canvas = document.getElementById('minimap-canvas');
        const ctx = canvas.getContext('2d');
        if (!ctx) return;

        ctx.clearRect(0, 0, 180, 180);

        // Background
        ctx.fillStyle = '#0a1f0a';
        ctx.fillRect(0, 0, 180, 180);

        // Biomes
        const scale = 0.45;
        const offsetX = 90;
        const offsetY = 90;

        const biomeColors = { savannah: '#6b8c42', forest: '#2d5a27', arctic: '#c8d4dc', desert: '#c2b280', ocean: '#1a6b8a' };
        Object.entries(biomes).forEach(([name, biome]) => {
            ctx.beginPath();
            ctx.arc(biome.center.x * scale + offsetX, biome.center.z * scale + offsetY, 18, 0, Math.PI * 2);
            ctx.fillStyle = biomeColors[name] + '66';
            ctx.fill();
            ctx.strokeStyle = biomeColors[name];
            ctx.lineWidth = 1;
            ctx.stroke();
        });

        // Animals
        animalMeshes.forEach(mesh => {
            ctx.beginPath();
            ctx.arc(mesh.position.x * scale + offsetX, mesh.position.z * scale + offsetY, 2, 0, Math.PI * 2);
            ctx.fillStyle = '#4ade80';
            ctx.fill();
        });

        // Camera (player)
        const camX = camera.position.x * scale + offsetX;
        const camZ = camera.position.z * scale + offsetY;
        ctx.beginPath();
        ctx.arc(camX, camZ, 4, 0, Math.PI * 2);
        ctx.fillStyle = '#f97316';
        ctx.fill();
        ctx.strokeStyle = '#fff';
        ctx.lineWidth = 1;
        ctx.stroke();

        // Camera direction
        const dir = new THREE.Vector3();
        camera.getWorldDirection(dir);
        ctx.beginPath();
        ctx.moveTo(camX, camZ);
        ctx.lineTo(camX + dir.x * 12, camZ + dir.z * 12);
        ctx.strokeStyle = '#f97316';
        ctx.lineWidth = 2;
        ctx.stroke();
    }

    // ==========================================
    // INFO PANEL
    // ==========================================
    function showAnimalInfo(data) {
        document.getElementById('panel-title').textContent = `${getAnimalEmoji(data.name)} ${data.name}`;
        document.getElementById('panel-species').textContent = data.scientific_name || data.species;
        document.getElementById('panel-desc').textContent = data.description || 'This amazing animal is one of the stars of ZooSphere!';

        // Badge
        const status = (data.conservation_status || '').toLowerCase();
        let badgeClass = 'badge-least';
        if (status.includes('endangered')) badgeClass = 'badge-endangered';
        else if (status.includes('vulnerable')) badgeClass = 'badge-vulnerable';
        document.getElementById('panel-badge-container').innerHTML =
            `<span class="panel-badge ${badgeClass}">${data.conservation_status || 'Unknown'}</span>`;

        // Stats
        document.getElementById('panel-stats').innerHTML = `
            <div class="panel-stat"><div class="panel-stat-icon" style="display:flex; justify-content:center;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 0 0 2-2V2"/><path d="M7 2v20"/><path d="M21 15V2v0a5 5 0 0 0-5 5v6c0 1.1.9 2 2 2h3Zm0 0v7"/></svg></div><div class="panel-stat-label">Diet</div><div class="panel-stat-value">${data.diet || 'N/A'}</div></div>
            <div class="panel-stat"><div class="panel-stat-icon" style="display:flex; justify-content:center;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 22h14"/><path d="M5 2h14"/><path d="M17 22v-4.172a2 2 0 0 0-.586-1.414L12 12l-4.414 4.414A2 2 0 0 0 7 17.828V22"/><path d="M7 2v4.172a2 2 0 0 0 .586 1.414L12 12l4.414-4.414A2 2 0 0 0 17 6.172V2"/></svg></div><div class="panel-stat-label">Lifespan</div><div class="panel-stat-value">${data.lifespan || 'N/A'}</div></div>
            <div class="panel-stat"><div class="panel-stat-icon" style="display:flex; justify-content:center;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path d="M2 12h20"/></svg></div><div class="panel-stat-label">Habitat</div><div class="panel-stat-value">${data.habitat ? data.habitat.name : 'N/A'}</div></div>
            <div class="panel-stat"><div class="panel-stat-icon" style="display:flex; justify-content:center;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m16 16 3-8 3 8c-.87.65-1.92 1-3 1s-2.13-.35-3-1Z"/><path d="m2 16 3-8 3 8c-.87.65-1.92 1-3 1s-2.13-.35-3-1Z"/><path d="M7 21h10"/><path d="M12 3v18"/><path d="M3 7h2c2 0 5-1 7-2 2 1 5 2 7 2h2"/></svg></div><div class="panel-stat-label">Weight</div><div class="panel-stat-value">${data.weight || 'N/A'}</div></div>
            <div class="panel-stat"><div class="panel-stat-icon" style="display:flex; justify-content:center;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.3 15.3a2.4 2.4 0 0 1 0 3.4l-2.6 2.6a2.4 2.4 0 0 1-3.4 0L2.7 8.7a2.41 2.41 0 0 1 0-3.4l2.6-2.6a2.41 2.41 0 0 1 3.4 0Z"/><path d="m14.5 12.5 2-2"/><path d="m11.5 9.5 2-2"/><path d="m8.5 6.5 2-2"/><path d="m17.5 15.5 2-2"/></svg></div><div class="panel-stat-label">Height</div><div class="panel-stat-value">${data.height || 'N/A'}</div></div>
            <div class="panel-stat"><div class="panel-stat-icon" style="display:flex; justify-content:center;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.7 7.7a2.5 2.5 0 1 1 1.8 4.3H2"/><path d="M9.6 4.6A2 2 0 1 1 11 8H2"/><path d="M12.6 19.4A2 2 0 1 0 14 16H2"/></svg></div><div class="panel-stat-label">Speed</div><div class="panel-stat-value">${data.speed || 'N/A'}</div></div>
        `;

        document.getElementById('info-panel').classList.add('visible');
    }

    function closePanel() {
        document.getElementById('info-panel').classList.remove('visible');
    }

    // ==========================================
    // INTERACTION
    // ==========================================
    function onCanvasClick(event) {
        const rect = renderer.domElement.getBoundingClientRect();
        const mouse = new THREE.Vector2(
            ((event.clientX - rect.left) / rect.width) * 2 - 1,
            -((event.clientY - rect.top) / rect.height) * 2 + 1
        );

        const raycaster = new THREE.Raycaster();
        raycaster.setFromCamera(mouse, camera);

        // Check all animal groups
        for (const mesh of animalMeshes) {
            const intersects = raycaster.intersectObjects(mesh.children, true);
            if (intersects.length > 0) {
                showAnimalInfo(mesh.userData.animalData);
                // Smooth camera focus
                const target = new THREE.Vector3().copy(mesh.position);
                target.y += 3;
                gsapLerp(controls.target, target, 1000);
                return;
            }
        }

        closePanel();
    }

    function gsapLerp(obj, target, duration) {
        const start = { x: obj.x, y: obj.y, z: obj.z };
        const startTime = Date.now();
        function update() {
            const progress = Math.min(1, (Date.now() - startTime) / duration);
            const ease = 1 - Math.pow(1 - progress, 3);
            obj.x = start.x + (target.x - start.x) * ease;
            obj.y = start.y + (target.y - start.y) * ease;
            obj.z = start.z + (target.z - start.z) * ease;
            if (progress < 1) requestAnimationFrame(update);
        }
        update();
    }

    // ==========================================
    // HUD CONTROLS
    // ==========================================
    function toggleDayNight() {
        isNight = !isNight;
        const btn = document.getElementById('btn-daynight');

        if (isNight) {
            // Night mode
            scene.background = new THREE.Color(0x0a0a2e);
            scene.fog = new THREE.FogExp2(0x0a0a2e, 0.005);
            sunLight.intensity = 0.1;
            ambientLight.intensity = 0.15;
            moonLight.visible = true;
            btn.innerHTML = '☀️ Day Mode';
            btn.classList.add('active');
            document.getElementById('time-icon').textContent = '🌙';
            document.getElementById('time-label').textContent = 'Nighttime';

            // Dim sun visual
            const sun = scene.getObjectByName('sun');
            if (sun) sun.material.color.setHex(0x333355);
        } else {
            // Day mode
            scene.background = new THREE.Color(0x87ceeb);
            scene.fog = new THREE.FogExp2(0x87ceeb, 0.003);
            sunLight.intensity = 1.2;
            ambientLight.intensity = 0.6;
            moonLight.visible = false;
            btn.innerHTML = '🌙 Night Mode';
            btn.classList.remove('active');
            document.getElementById('time-icon').textContent = '☀️';
            document.getElementById('time-label').textContent = 'Daytime';

            const sun = scene.getObjectByName('sun');
            if (sun) sun.material.color.setHex(0xfff4c4);
        }
    }

    function toggleWeather() {
        isRaining = !isRaining;
        const btn = document.getElementById('btn-weather');
        if (isRaining) {
            createRain();
            btn.classList.add('active');
            btn.innerHTML = '☀️ Clear';
        } else {
            removeRain();
            btn.classList.remove('active');
            btn.innerHTML = '🌧️ Weather';
        }
    }

    function toggleSound() {
        soundEnabled = !soundEnabled;
        const btn = document.getElementById('btn-sound');
        btn.classList.toggle('active');
        btn.innerHTML = soundEnabled ? '🔇 Mute' : '🔊 Sound';
    }

    function resetCamera() {
        gsapLerp(camera.position, { x: 0, y: 30, z: 60 }, 1500);
        gsapLerp(controls.target, { x: 0, y: 0, z: 0 }, 1500);
        closePanel();
    }

    // ==========================================
    // KEYBOARD CONTROLS
    // ==========================================
    function setupKeyboardControls() {
        const keys = {};
        document.addEventListener('keydown', e => { keys[e.key.toLowerCase()] = true; });
        document.addEventListener('keyup', e => { keys[e.key.toLowerCase()] = false; });

        function updateMovement() {
            const speed = keys['shift'] ? 1.5 : 0.5;
            const dir = new THREE.Vector3();
            camera.getWorldDirection(dir);
            dir.y = 0;
            dir.normalize();

            const right = new THREE.Vector3().crossVectors(dir, new THREE.Vector3(0, 1, 0));

            if (keys['w'] || keys['arrowup']) { camera.position.addScaledVector(dir, speed); controls.target.addScaledVector(dir, speed); }
            if (keys['s'] || keys['arrowdown']) { camera.position.addScaledVector(dir, -speed); controls.target.addScaledVector(dir, -speed); }
            if (keys['a'] || keys['arrowleft']) { camera.position.addScaledVector(right, -speed); controls.target.addScaledVector(right, -speed); }
            if (keys['d'] || keys['arrowright']) { camera.position.addScaledVector(right, speed); controls.target.addScaledVector(right, speed); }
            if (keys[' ']) { camera.position.y += speed; controls.target.y += speed; }

            requestAnimationFrame(updateMovement);
        }
        updateMovement();
    }

    // ==========================================
    // HELPERS
    // ==========================================
    function getTerrainHeight(x, z) {
        let y = Math.sin(x * 0.02) * 2 + Math.cos(z * 0.03) * 1.5;
        y += Math.sin(x * 0.05 + z * 0.03) * 0.8;
        return y;
    }

    function onResize() {
        camera.aspect = window.innerWidth / window.innerHeight;
        camera.updateProjectionMatrix();
        renderer.setSize(window.innerWidth, window.innerHeight);
    }

    // ==========================================
    // START
    // ==========================================
    window.addEventListener('DOMContentLoaded', init);
    </script>
</body>
</html>