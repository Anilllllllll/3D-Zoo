{{-- ZooSphere Footer --}}
<footer class="bg-jungle-dark border-t border-white/5 mt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            {{-- Brand --}}
            <div class="col-span-1 md:col-span-2">
                <div class="flex items-center gap-2 mb-4">
                    <span class="text-3xl">🌿</span>
                    <span class="text-2xl font-bold gradient-text">ZooSphere</span>
                </div>
                <p class="text-gray-400 max-w-md leading-relaxed">
                    An immersive virtual zoo platform dedicated to wildlife education and conservation awareness.
                    Explore, learn, and help protect our planet's incredible biodiversity.
                </p>
                <div class="flex gap-4 mt-6">
                    <span class="text-2xl hover:scale-125 transition-transform cursor-pointer">🦁</span>
                    <span class="text-2xl hover:scale-125 transition-transform cursor-pointer">🐘</span>
                    <span class="text-2xl hover:scale-125 transition-transform cursor-pointer">🐧</span>
                    <span class="text-2xl hover:scale-125 transition-transform cursor-pointer">🐅</span>
                    <span class="text-2xl hover:scale-125 transition-transform cursor-pointer">🐬</span>
                </div>
            </div>

            {{-- Quick Links --}}
            <div>
                <h4 class="text-white font-semibold mb-4">Explore</h4>
                <ul class="space-y-2">
                    <li><a href="{{ route('animals.index') }}" class="text-gray-400 hover:text-zoo-400 transition-colors">Animals</a></li>
                    <li><a href="{{ route('habitats.index') }}" class="text-gray-400 hover:text-zoo-400 transition-colors">Habitats</a></li>
                    <li><a href="{{ route('zoo-map') }}" class="text-gray-400 hover:text-zoo-400 transition-colors">Zoo Map</a></li>
                    <li><a href="{{ route('quiz.index') }}" class="text-gray-400 hover:text-zoo-400 transition-colors">Wildlife Quiz</a></li>
                    <li><a href="{{ route('kids-zone') }}" class="text-gray-400 hover:text-zoo-400 transition-colors">Kids Zone</a></li>
                </ul>
            </div>

            {{-- Resources --}}
            <div>
                <h4 class="text-white font-semibold mb-4">Resources</h4>
                <ul class="space-y-2">
                    <li><a href="{{ route('chatbot') }}" class="text-gray-400 hover:text-zoo-400 transition-colors">AI Chatbot</a></li>
                    <li><a href="{{ route('news') }}" class="text-gray-400 hover:text-zoo-400 transition-colors">Conservation News</a></li>
                </ul>

                <h4 class="text-white font-semibold mt-6 mb-3">Conservation Pledge</h4>
                <p class="text-gray-500 text-sm italic">"In protecting wildlife, we protect ourselves."</p>
            </div>
        </div>

        {{-- Bottom Bar --}}
        <div class="border-t border-white/5 mt-10 pt-6 flex flex-col md:flex-row items-center justify-between gap-4">
            <p class="text-gray-500 text-sm">
                © {{ date('Y') }} ZooSphere. Built with ❤️ for Wildlife Conservation.
            </p>
            <p class="text-gray-600 text-xs">
                Built with Laravel, Tailwind CSS & JavaScript — Academic Project
            </p>
        </div>
    </div>
</footer>
