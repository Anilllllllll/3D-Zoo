@extends('layouts.app')
@section('title', 'Animal Directory')
@section('content')
<section class="py-12 px-4">
    <div class="max-w-7xl mx-auto">
        {{-- Header --}}
        <div class="text-center mb-10 reveal">
            <h1 class="section-title">🦁 Animal Directory</h1>
            <p class="section-subtitle">Explore our complete collection of amazing wildlife</p>
        </div>

        {{-- Search & Filters --}}
        <div class="glass-card p-6 mb-10 reveal">
            <form method="GET" action="{{ route('animals.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
                <div class="md:col-span-2">
                    <label class="block text-sm text-gray-400 mb-1">Search Animals</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or species..."
                           class="form-input w-full px-4 py-3">
                </div>
                <div>
                    <label class="block text-sm text-gray-400 mb-1">Habitat</label>
                    <select name="habitat" class="form-input w-full px-4 py-3">
                        <option value="">All Habitats</option>
                        @foreach($habitats as $habitat)
                            <option value="{{ $habitat->id }}" {{ request('habitat') == $habitat->id ? 'selected' : '' }}>{{ $habitat->icon }} {{ $habitat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm text-gray-400 mb-1">Category</label>
                    <select name="category" class="form-input w-full px-4 py-3">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <button type="submit" class="btn-primary w-full py-3">🔍 Search</button>
                </div>
            </form>
        </div>

        {{-- Animals Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($animals as $animal)
                <a href="{{ route('animals.show', $animal) }}" class="animal-card reveal" style="transition-delay: {{ $loop->index * 0.05 }}s">
                    <div class="overflow-hidden h-52">
                        <img src="{{ $animal->image }}" alt="{{ $animal->name }}" class="card-image" loading="lazy">
                    </div>
                    <div class="p-5">
                        <div class="flex items-center justify-between mb-1">
                            <h3 class="text-lg font-bold text-white">{{ $animal->name }}</h3>
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
                        <p class="text-gray-400 text-sm italic">{{ $animal->scientific_name }}</p>
                        <div class="flex items-center gap-3 mt-3 text-xs text-gray-500">
                            <span>🌍 {{ $animal->habitat->name }}</span>
                            <span>🍽️ {{ $animal->diet }}</span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center py-20">
                    <span class="text-6xl mb-4 block">🔍</span>
                    <p class="text-gray-400 text-lg">No animals found matching your criteria.</p>
                    <a href="{{ route('animals.index') }}" class="btn-primary mt-4 inline-block">Clear Filters</a>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-10">
            {{ $animals->appends(request()->query())->links() }}
        </div>
    </div>
</section>
@endsection
