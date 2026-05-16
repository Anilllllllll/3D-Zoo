@extends('layouts.app')
@section('title', 'Admin Dashboard')
@section('content')
<section class="py-12 px-4">
    <div class="max-w-7xl mx-auto">
        <div class="flex items-center justify-between mb-10">
            <div>
                <h1 class="section-title">⚙️ Admin Dashboard</h1>
                <p class="text-gray-400">Manage your ZooSphere platform</p>
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-12">
            <div class="stat-card">
                <span class="text-3xl mb-2 block">🦁</span>
                <div class="text-2xl font-bold gradient-text">{{ $stats['total_animals'] }}</div>
                <p class="text-gray-400 text-sm">Animals</p>
            </div>
            <div class="stat-card">
                <span class="text-3xl mb-2 block">🌍</span>
                <div class="text-2xl font-bold gradient-text">{{ $stats['total_habitats'] }}</div>
                <p class="text-gray-400 text-sm">Habitats</p>
            </div>
            <div class="stat-card">
                <span class="text-3xl mb-2 block">👥</span>
                <div class="text-2xl font-bold gradient-text">{{ $stats['total_users'] }}</div>
                <p class="text-gray-400 text-sm">Users</p>
            </div>
            <div class="stat-card">
                <span class="text-3xl mb-2 block">🧠</span>
                <div class="text-2xl font-bold gradient-text">{{ $stats['total_quizzes'] }}</div>
                <p class="text-gray-400 text-sm">Quiz Questions</p>
            </div>
            <div class="stat-card">
                <span class="text-3xl mb-2 block">🎫</span>
                <div class="text-2xl font-bold gradient-text">{{ $stats['total_bookings'] }}</div>
                <p class="text-gray-400 text-sm">Bookings</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            {{-- Quick Management Links --}}
            <div class="glass-card p-6">
                <h2 class="text-xl font-bold text-white mb-6">🔧 Management</h2>
                <div class="space-y-3">
                    <a href="{{ route('admin.animals') }}" class="flex items-center justify-between p-4 rounded-xl hover:bg-white/5 transition-colors">
                        <div class="flex items-center gap-3">
                            <span class="text-2xl">🦁</span>
                            <div>
                                <p class="text-white font-medium">Manage Animals</p>
                                <p class="text-gray-400 text-sm">Add, edit, delete animals</p>
                            </div>
                        </div>
                        <span class="text-gray-500">→</span>
                    </a>
                    <a href="{{ route('admin.habitats') }}" class="flex items-center justify-between p-4 rounded-xl hover:bg-white/5 transition-colors">
                        <div class="flex items-center gap-3">
                            <span class="text-2xl">🌍</span>
                            <div>
                                <p class="text-white font-medium">Manage Habitats</p>
                                <p class="text-gray-400 text-sm">Add, edit, delete habitats</p>
                            </div>
                        </div>
                        <span class="text-gray-500">→</span>
                    </a>
                    <a href="{{ route('admin.quizzes') }}" class="flex items-center justify-between p-4 rounded-xl hover:bg-white/5 transition-colors">
                        <div class="flex items-center gap-3">
                            <span class="text-2xl">🧠</span>
                            <div>
                                <p class="text-white font-medium">Manage Quiz Questions</p>
                                <p class="text-gray-400 text-sm">Create and manage quiz content</p>
                            </div>
                        </div>
                        <span class="text-gray-500">→</span>
                    </a>
                    <a href="{{ route('admin.users') }}" class="flex items-center justify-between p-4 rounded-xl hover:bg-white/5 transition-colors">
                        <div class="flex items-center gap-3">
                            <span class="text-2xl">👥</span>
                            <div>
                                <p class="text-white font-medium">Manage Users</p>
                                <p class="text-gray-400 text-sm">View registered users</p>
                            </div>
                        </div>
                        <span class="text-gray-500">→</span>
                    </a>
                </div>
            </div>

            {{-- Most Viewed Animals --}}
            <div class="glass-card p-6">
                <h2 class="text-xl font-bold text-white mb-6">🔥 Most Viewed Animals</h2>
                <div class="space-y-3">
                    @foreach($mostViewed as $animal)
                        <div class="flex items-center gap-4 p-3 rounded-xl hover:bg-white/5 transition-colors">
                            <span class="text-lg font-bold text-gray-500 w-6">{{ $loop->iteration }}</span>
                            <img src="{{ $animal->image }}" alt="{{ $animal->name }}" class="w-12 h-12 rounded-lg object-cover">
                            <div class="flex-1">
                                <p class="text-white font-medium">{{ $animal->name }}</p>
                                <p class="text-gray-400 text-xs">{{ $animal->species }}</p>
                            </div>
                            <span class="text-zoo-400 font-semibold">{{ number_format($animal->views_count) }} views</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Recent Users --}}
        <div class="glass-card p-6 mt-8">
            <h2 class="text-xl font-bold text-white mb-6">👤 Recent Users</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b border-white/10">
                            <th class="py-3 px-4 text-gray-400 text-sm">Name</th>
                            <th class="py-3 px-4 text-gray-400 text-sm">Email</th>
                            <th class="py-3 px-4 text-gray-400 text-sm">Role</th>
                            <th class="py-3 px-4 text-gray-400 text-sm">Joined</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentUsers as $user)
                            <tr class="border-b border-white/5 hover:bg-white/5">
                                <td class="py-3 px-4 text-white">{{ $user->name }}</td>
                                <td class="py-3 px-4 text-gray-400">{{ $user->email }}</td>
                                <td class="py-3 px-4">
                                    <span class="badge {{ $user->role === 'admin' ? 'bg-purple-500/20 text-purple-400 border border-purple-500/30' : 'bg-blue-500/20 text-blue-400 border border-blue-500/30' }}">{{ ucfirst($user->role) }}</span>
                                </td>
                                <td class="py-3 px-4 text-gray-500 text-sm">{{ $user->created_at->diffForHumans() }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
