@extends('layouts.app')
@section('title', 'Manage Quizzes')
@section('content')
<section class="py-12 px-4">
    <div class="max-w-7xl mx-auto">
        <div class="flex items-center justify-between mb-8">
            <h1 class="section-title">🧠 Manage Quiz Questions</h1>
            <a href="{{ route('admin.quizzes.create') }}" class="btn-primary">+ Add Question</a>
        </div>
        <div class="space-y-4">
            @foreach($quizzes as $quiz)
                <div class="glass-card p-5 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                    <div class="flex-1">
                        <p class="text-white font-medium">{{ $quiz->question }}</p>
                        <div class="flex items-center gap-3 mt-2 text-xs text-gray-400">
                            <span class="badge {{ $quiz->difficulty === 'easy' ? 'bg-green-500/20 text-green-400' : ($quiz->difficulty === 'medium' ? 'bg-yellow-500/20 text-yellow-400' : 'bg-red-500/20 text-red-400') }}">{{ ucfirst($quiz->difficulty) }}</span>
                            <span>Answer: {{ $quiz->correct_answer }}</span>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.quizzes.edit', $quiz) }}" class="text-blue-400 hover:text-blue-300 text-sm">Edit</a>
                        <form method="POST" action="{{ route('admin.quizzes.delete', $quiz) }}" onsubmit="return confirm('Delete?')">
                            @csrf @method('DELETE')
                            <button class="text-red-400 hover:text-red-300 text-sm">Delete</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-4"><a href="{{ route('admin.dashboard') }}" class="text-zoo-400 hover:underline">← Back</a></div>
    </div>
</section>
@endsection
