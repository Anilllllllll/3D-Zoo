@extends('layouts.app')
@section('title', 'Manage Habitats')
@section('content')
<section class="py-12 px-4">
    <div class="max-w-7xl mx-auto">
        <div class="flex items-center justify-between mb-8">
            <h1 class="section-title">🌍 Manage Habitats</h1>
            <a href="{{ route('admin.habitats.create') }}" class="btn-primary">+ Add Habitat</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($habitats as $habitat)
                <div class="glass-card p-6">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="text-3xl">{{ $habitat->icon }}</span>
                        <div>
                            <h3 class="text-lg font-bold text-white">{{ $habitat->name }}</h3>
                            <p class="text-gray-400 text-sm">{{ $habitat->animals_count }} animals</p>
                        </div>
                    </div>
                    <p class="text-gray-400 text-sm mb-4">{{ Str::limit($habitat->description, 100) }}</p>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.habitats.edit', $habitat) }}" class="btn-secondary text-sm py-2 px-4">Edit</a>
                        <form method="POST" action="{{ route('admin.habitats.delete', $habitat) }}" onsubmit="return confirm('Delete?')">
                            @csrf @method('DELETE')
                            <button class="text-red-400 hover:text-red-300 text-sm py-2 px-4">Delete</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-4"><a href="{{ route('admin.dashboard') }}" class="text-zoo-400 hover:underline">← Back</a></div>
    </div>
</section>
@endsection
