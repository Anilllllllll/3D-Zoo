{{-- ZooSphere Navigation Bar --}}
<nav class="fixed top-0 left-0 right-0 z-50 bg-jungle/80 backdrop-blur-xl border-b border-white/5" x-data="{ mobileOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                <span class="text-3xl group-hover:animate-bounce-slow">🌿</span>
                <span class="text-xl font-bold gradient-text">ZooSphere</span>
            </a>

            {{-- Desktop Navigation --}}
            <div class="hidden md:flex items-center gap-6">
                <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
                <a href="{{ route('animals.index') }}" class="nav-link {{ request()->routeIs('animals.*') ? 'active' : '' }}">Animals</a>
                <a href="{{ route('habitats.index') }}" class="nav-link {{ request()->routeIs('habitats.*') ? 'active' : '' }}">Habitats</a>
                <a href="{{ route('zoo-map') }}" class="nav-link {{ request()->routeIs('zoo-map') ? 'active' : '' }}">Zoo Map</a>
                <a href="{{ route('3d-zoo') }}" class="nav-link {{ request()->routeIs('3d-zoo') ? 'active' : '' }}" style="color: #4ade80; text-shadow: 0 0 10px rgba(74,222,128,0.3);">🌐 3D Zoo</a>
                <a href="{{ route('quiz.index') }}" class="nav-link {{ request()->routeIs('quiz.*') ? 'active' : '' }}">Quiz</a>
                <a href="{{ route('chatbot') }}" class="nav-link {{ request()->routeIs('chatbot') ? 'active' : '' }}">🤖 AI Chat</a>

                {{-- Dropdown for more --}}
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="nav-link flex items-center gap-1">
                        More
                        <svg class="w-4 h-4 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="open" @click.away="open = false" x-transition
                         class="absolute right-0 mt-2 w-48 bg-jungle-light/95 backdrop-blur-xl rounded-xl border border-white/10 shadow-2xl py-2 z-50">
                        <a href="{{ route('kids-zone') }}" class="block px-4 py-2 text-gray-300 hover:text-zoo-400 hover:bg-white/5 transition-colors">🎮 Kids Zone</a>
                        <a href="{{ route('news') }}" class="block px-4 py-2 text-gray-300 hover:text-zoo-400 hover:bg-white/5 transition-colors">📰 News</a>
                        @auth
                            <a href="{{ route('favorites.index') }}" class="block px-4 py-2 text-gray-300 hover:text-zoo-400 hover:bg-white/5 transition-colors">❤️ Favorites</a>
                        @endauth
                    </div>
                </div>
            </div>

            {{-- Auth Buttons --}}
            <div class="hidden md:flex items-center gap-3">
                @guest
                    <a href="{{ route('login') }}" class="btn-secondary text-sm py-2 px-4">Login</a>
                    <a href="{{ route('register') }}" class="btn-primary text-sm py-2 px-4">Sign Up</a>
                @else
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center gap-2 text-gray-300 hover:text-white transition-colors">
                            <div class="w-8 h-8 rounded-full bg-zoo-600 flex items-center justify-center text-white font-semibold text-sm">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <span class="text-sm font-medium">{{ auth()->user()->name }}</span>
                        </button>
                        <div x-show="open" @click.away="open = false" x-transition
                             class="absolute right-0 mt-2 w-48 bg-jungle-light/95 backdrop-blur-xl rounded-xl border border-white/10 shadow-2xl py-2">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-300 hover:text-zoo-400 hover:bg-white/5">👤 Profile</a>
                            <a href="{{ route('favorites.index') }}" class="block px-4 py-2 text-gray-300 hover:text-zoo-400 hover:bg-white/5">❤️ Favorites</a>
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-gray-300 hover:text-zoo-400 hover:bg-white/5">⚙️ Admin</a>
                            @endif
                            <hr class="border-white/10 my-1">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-gray-300 hover:text-red-400 hover:bg-white/5">🚪 Logout</button>
                            </form>
                        </div>
                    </div>
                @endguest
            </div>

            {{-- Mobile Menu Button --}}
            <button @click="mobileOpen = !mobileOpen" class="md:hidden text-gray-300 hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path x-show="!mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    <path x-show="mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div x-show="mobileOpen" x-transition class="md:hidden bg-jungle-light/95 backdrop-blur-xl border-t border-white/5">
        <div class="px-4 py-4 space-y-2">
            <a href="{{ route('home') }}" class="block py-2 text-gray-300 hover:text-zoo-400">🏠 Home</a>
            <a href="{{ route('animals.index') }}" class="block py-2 text-gray-300 hover:text-zoo-400">🦁 Animals</a>
            <a href="{{ route('habitats.index') }}" class="block py-2 text-gray-300 hover:text-zoo-400">🌍 Habitats</a>
            <a href="{{ route('zoo-map') }}" class="block py-2 text-gray-300 hover:text-zoo-400">🗺️ Zoo Map</a>
            <a href="{{ route('3d-zoo') }}" class="block py-2 text-zoo-400 font-semibold">🌐 3D Zoo</a>
            <a href="{{ route('quiz.index') }}" class="block py-2 text-gray-300 hover:text-zoo-400">🧠 Quiz</a>
            <a href="{{ route('chatbot') }}" class="block py-2 text-gray-300 hover:text-zoo-400">🤖 AI Chat</a>
            <a href="{{ route('kids-zone') }}" class="block py-2 text-gray-300 hover:text-zoo-400">🎮 Kids Zone</a>
            <a href="{{ route('news') }}" class="block py-2 text-gray-300 hover:text-zoo-400">📰 News</a>
            @guest
                <hr class="border-white/10">
                <a href="{{ route('login') }}" class="block py-2 text-zoo-400">Login</a>
                <a href="{{ route('register') }}" class="block py-2 text-zoo-400">Sign Up</a>
            @else
                <hr class="border-white/10">
                <a href="{{ route('favorites.index') }}" class="block py-2 text-gray-300 hover:text-zoo-400">❤️ Favorites</a>
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="block py-2 text-gray-300 hover:text-zoo-400">⚙️ Admin</a>
                @endif
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block py-2 text-red-400">Logout</button>
                </form>
            @endguest
        </div>
    </div>
</nav>

{{-- Spacer for fixed nav --}}
<div class="h-16"></div>
