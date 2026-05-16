@extends('layouts.app')
@section('title', 'Quiz Results')
@section('content')
<section class="py-12 px-4">
    <div class="max-w-3xl mx-auto">
        {{-- Score Card --}}
        <div class="glass-card p-10 text-center mb-10 reveal">
            @if($percentage >= 80)
                <span class="text-7xl block mb-4">🏆</span>
                <h1 class="text-3xl font-bold text-yellow-400 mb-2">Outstanding!</h1>
            @elseif($percentage >= 60)
                <span class="text-7xl block mb-4">🌟</span>
                <h1 class="text-3xl font-bold text-zoo-400 mb-2">Great Job!</h1>
            @elseif($percentage >= 40)
                <span class="text-7xl block mb-4">👍</span>
                <h1 class="text-3xl font-bold text-blue-400 mb-2">Good Effort!</h1>
            @else
                <span class="text-7xl block mb-4">📚</span>
                <h1 class="text-3xl font-bold text-gray-400 mb-2">Keep Learning!</h1>
            @endif

            <div class="text-6xl font-black gradient-text my-4">{{ $percentage }}%</div>
            <p class="text-xl text-gray-300">You scored <strong class="text-white">{{ $score }}</strong> out of <strong class="text-white">{{ $total }}</strong></p>

            {{-- Certificate Message --}}
            @if($percentage >= 80)
                <div class="mt-6 p-4 bg-yellow-400/10 border border-yellow-400/30 rounded-xl">
                    <p class="text-yellow-400 font-semibold">🎓 Certificate of Wildlife Knowledge Earned!</p>
                    <p class="text-gray-400 text-sm mt-1">Congratulations! You are a certified Wildlife Explorer.</p>
                </div>
            @endif
        </div>

        {{-- Detailed Results --}}
        <h2 class="text-2xl font-bold text-white mb-6 reveal">📋 Detailed Results</h2>
        <div class="space-y-4">
            @foreach($results as $index => $result)
                <div class="glass-card p-5 reveal {{ $result['is_correct'] ? 'border-green-500/30' : 'border-red-500/30' }} border">
                    <div class="flex items-start gap-3">
                        <span class="text-xl mt-0.5">{{ $result['is_correct'] ? '✅' : '❌' }}</span>
                        <div class="flex-1">
                            <p class="text-white font-medium mb-2">{{ $result['question'] }}</p>
                            <p class="text-sm">
                                <span class="text-gray-400">Your answer:</span>
                                <span class="{{ $result['is_correct'] ? 'text-green-400' : 'text-red-400' }} font-medium">{{ $result['your_answer'] }}</span>
                            </p>
                            @if(!$result['is_correct'])
                                <p class="text-sm mt-1">
                                    <span class="text-gray-400">Correct answer:</span>
                                    <span class="text-green-400 font-medium">{{ $result['correct_answer'] }}</span>
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-10 reveal">
            <a href="{{ route('quiz.index') }}" class="btn-primary">🔄 Try Again</a>
            <a href="{{ route('home') }}" class="btn-secondary ml-3">🏠 Go Home</a>
        </div>
    </div>
</section>
@endsection
