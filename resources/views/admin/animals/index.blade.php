@extends('layouts.app')
@section('title', 'Manage Animals')
@section('content')
<section class="py-12 px-4">
    <div class="max-w-7xl mx-auto">
        <div class="flex items-center justify-between mb-8">
            <h1 class="section-title">🦁 Manage Animals</h1>
            <a href="{{ route('admin.animals.create') }}" class="btn-primary">+ Add Animal</a>
        </div>
        <div class="glass-card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b border-white/10 bg-white/5">
                            <th class="py-3 px-4 text-gray-400 text-sm">Image</th>
                            <th class="py-3 px-4 text-gray-400 text-sm">Name</th>
                            <th class="py-3 px-4 text-gray-400 text-sm">Species</th>
                            <th class="py-3 px-4 text-gray-400 text-sm">Habitat</th>
                            <th class="py-3 px-4 text-gray-400 text-sm">Status</th>
                            <th class="py-3 px-4 text-gray-400 text-sm">Views</th>
                            <th class="py-3 px-4 text-gray-400 text-sm">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($animals as $animal)
                            <tr class="border-b border-white/5 hover:bg-white/5">
                                <td class="py-3 px-4"><img src="{{ $animal->image }}" class="w-10 h-10 rounded-lg object-cover" alt=""></td>
                                <td class="py-3 px-4 text-white font-medium">{{ $animal->name }}</td>
                                <td class="py-3 px-4 text-gray-400 text-sm">{{ $animal->species }}</td>
                                <td class="py-3 px-4 text-gray-400 text-sm">{{ $animal->habitat->name ?? 'N/A' }}</td>
                                <td class="py-3 px-4"><span class="badge bg-zoo-500/20 text-zoo-400 border border-zoo-500/30">{{ $animal->conservation_status }}</span></td>
                                <td class="py-3 px-4 text-gray-400">{{ $animal->views_count }}</td>
                                <td class="py-3 px-4">
                                    <div class="flex gap-2">
                                        <a href="{{ route('admin.animals.edit', $animal) }}" class="text-blue-400 hover:text-blue-300 text-sm">Edit</a>
                                        <form method="POST" action="{{ route('admin.animals.delete', $animal) }}" onsubmit="return confirm('Delete this animal?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-400 hover:text-red-300 text-sm">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-4"><a href="{{ route('admin.dashboard') }}" class="text-zoo-400 hover:underline">← Back to Dashboard</a></div>
    </div>
</section>
@endsection
