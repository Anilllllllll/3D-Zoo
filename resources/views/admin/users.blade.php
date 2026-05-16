@extends('layouts.app')
@section('title', 'Manage Users')
@section('content')
<section class="py-12 px-4">
    <div class="max-w-7xl mx-auto">
        <h1 class="section-title mb-8">👥 Manage Users</h1>
        <div class="glass-card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b border-white/10 bg-white/5">
                            <th class="py-3 px-4 text-gray-400 text-sm">ID</th>
                            <th class="py-3 px-4 text-gray-400 text-sm">Name</th>
                            <th class="py-3 px-4 text-gray-400 text-sm">Email</th>
                            <th class="py-3 px-4 text-gray-400 text-sm">Role</th>
                            <th class="py-3 px-4 text-gray-400 text-sm">Joined</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr class="border-b border-white/5 hover:bg-white/5">
                                <td class="py-3 px-4 text-gray-500">{{ $user->id }}</td>
                                <td class="py-3 px-4 text-white font-medium">{{ $user->name }}</td>
                                <td class="py-3 px-4 text-gray-400">{{ $user->email }}</td>
                                <td class="py-3 px-4">
                                    <span class="badge {{ $user->role === 'admin' ? 'bg-purple-500/20 text-purple-400 border border-purple-500/30' : 'bg-blue-500/20 text-blue-400 border border-blue-500/30' }}">{{ ucfirst($user->role) }}</span>
                                </td>
                                <td class="py-3 px-4 text-gray-500 text-sm">{{ $user->created_at->format('M d, Y') }}</td>
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
