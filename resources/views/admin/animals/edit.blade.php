@extends('layouts.app')
@section('title', 'Edit Animal')
@section('content')
<section class="py-12 px-4">
    <div class="max-w-3xl mx-auto">
        <h1 class="section-title mb-8">✏️ Edit {{ $animal->name }}</h1>
        <form method="POST" action="{{ route('admin.animals.update', $animal) }}" class="glass-card p-8 space-y-5">
            @csrf @method('PUT')
            @include('admin.animals._form')
            <button type="submit" class="btn-primary w-full py-3">Update Animal</button>
        </form>
        <div class="mt-4"><a href="{{ route('admin.animals') }}" class="text-zoo-400 hover:underline">← Back to Animals</a></div>
    </div>
</section>
@endsection
