@extends('layouts.app')
@section('title', 'Conservation News')
@section('content')
<section class="py-12 px-4">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-12 reveal">
            <h1 class="section-title">📰 Conservation News</h1>
            <p class="section-subtitle">Stay updated with the latest wildlife conservation stories</p>
        </div>

        {{-- Featured Article --}}
        @if(count($articles) > 0)
            <div class="glass-card overflow-hidden mb-12 reveal">
                <div class="grid grid-cols-1 lg:grid-cols-2">
                    <img src="{{ $articles[0]['image'] }}" alt="{{ $articles[0]['title'] }}" class="w-full h-64 lg:h-full object-cover">
                    <div class="p-8 flex flex-col justify-center">
                        <span class="badge bg-zoo-500/20 text-zoo-400 border border-zoo-500/30 w-fit mb-4">{{ $articles[0]['category'] }}</span>
                        <h2 class="text-2xl font-bold text-white mb-3">{{ $articles[0]['title'] }}</h2>
                        <p class="text-gray-300 leading-relaxed mb-4">{{ $articles[0]['content'] }}</p>
                        <div class="flex items-center gap-4 text-sm text-gray-500">
                            <span>📅 {{ date('M d, Y', strtotime($articles[0]['date'])) }}</span>
                            <span>🏛️ {{ $articles[0]['source'] }}</span>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Article Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach(array_slice($articles, 1) as $article)
                <div class="glass-card overflow-hidden reveal" style="transition-delay: {{ $loop->index * 0.1 }}s">
                    <img src="{{ $article['image'] }}" alt="{{ $article['title'] }}" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <span class="badge bg-zoo-500/20 text-zoo-400 border border-zoo-500/30 mb-3 inline-block">{{ $article['category'] }}</span>
                        <h3 class="text-lg font-bold text-white mb-2">{{ $article['title'] }}</h3>
                        <p class="text-gray-400 text-sm mb-3">{{ $article['excerpt'] }}</p>
                        <div class="flex items-center gap-3 text-xs text-gray-500">
                            <span>📅 {{ date('M d, Y', strtotime($article['date'])) }}</span>
                            <span>🏛️ {{ $article['source'] }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
