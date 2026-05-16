@extends('layouts.app')
@section('title', 'Edit Habitat')
@section('content')
<section class="py-12 px-4">
    <div class="max-w-3xl mx-auto">
        <h1 class="section-title mb-8">✏️ Edit {{ $habitat->name }}</h1>
        @if($errors->any())
            <div class="bg-red-500/20 border border-red-500/30 rounded-xl p-4 mb-4">
                <ul class="text-red-400 text-sm">@foreach($errors->all() as $e)<li>• {{ $e }}</li>@endforeach</ul>
            </div>
        @endif
        <form method="POST" action="{{ route('admin.habitats.update', $habitat) }}" class="glass-card p-8 space-y-5">
            @csrf @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div><label class="block text-sm text-gray-400 mb-1">Name *</label><input type="text" name="name" value="{{ old('name', $habitat->name) }}" required class="form-input w-full px-4 py-3"></div>
                <div><label class="block text-sm text-gray-400 mb-1">Slug *</label><input type="text" name="slug" value="{{ old('slug', $habitat->slug) }}" required class="form-input w-full px-4 py-3"></div>
                <div><label class="block text-sm text-gray-400 mb-1">Climate</label><input type="text" name="climate" value="{{ old('climate', $habitat->climate) }}" class="form-input w-full px-4 py-3"></div>
                <div><label class="block text-sm text-gray-400 mb-1">Region</label><input type="text" name="region" value="{{ old('region', $habitat->region) }}" class="form-input w-full px-4 py-3"></div>
                <div><label class="block text-sm text-gray-400 mb-1">Icon</label><input type="text" name="icon" value="{{ old('icon', $habitat->icon) }}" class="form-input w-full px-4 py-3"></div>
                <div><label class="block text-sm text-gray-400 mb-1">Image URL</label><input type="text" name="image" value="{{ old('image', $habitat->image) }}" class="form-input w-full px-4 py-3"></div>
            </div>
            <div><label class="block text-sm text-gray-400 mb-1">Description *</label><textarea name="description" rows="4" required class="form-input w-full px-4 py-3">{{ old('description', $habitat->description) }}</textarea></div>
            <button type="submit" class="btn-primary w-full py-3">Update Habitat</button>
        </form>
        <div class="mt-4"><a href="{{ route('admin.habitats') }}" class="text-zoo-400 hover:underline">← Back</a></div>
    </div>
</section>
@endsection
