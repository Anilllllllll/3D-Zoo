@extends('layouts.app')
@section('title', 'Wildlife Quiz')
@section('content')
<section class="py-12 px-4">
    <div class="max-w-3xl mx-auto">
        <div class="text-center mb-12 reveal">
            <h1 class="section-title">🧠 Wildlife Quiz</h1>
            <p class="section-subtitle">Test your knowledge about the animal kingdom!</p>
        </div>

        <form method="POST" action="{{ route('quiz.submit') }}" id="quizForm">
            @csrf

            @foreach($quizzes as $index => $quiz)
                <div class="glass-card p-6 mb-6 reveal" style="transition-delay: {{ $index * 0.05 }}s">
                    <div class="flex items-start gap-4 mb-4">
                        <span class="bg-zoo-600/30 text-zoo-400 rounded-full w-8 h-8 flex items-center justify-center font-bold text-sm shrink-0">{{ $index + 1 }}</span>
                        <h3 class="text-lg font-semibold text-white">{{ $quiz->question }}</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 ml-12">
                        @php
                            $options = is_string($quiz->options) ? json_decode($quiz->options, true) : $quiz->options;
                        @endphp
                        @foreach($options as $option)
                            <label class="quiz-option flex items-center gap-3 cursor-pointer" id="option-{{ $quiz->id }}-{{ $loop->index }}">
                                <input type="radio" name="answers[{{ $quiz->id }}]" value="{{ $option }}"
                                       class="text-zoo-500 focus:ring-zoo-400 bg-white/5 border-white/20"
                                       onchange="selectOption({{ $quiz->id }}, {{ $loop->index }})">
                                <span class="text-gray-300">{{ $option }}</span>
                            </label>
                        @endforeach
                    </div>

                    @if($quiz->difficulty)
                        <div class="ml-12 mt-3">
                            @php
                                $diffColor = match($quiz->difficulty) {
                                    'easy' => 'text-green-400 bg-green-400/10',
                                    'medium' => 'text-yellow-400 bg-yellow-400/10',
                                    'hard' => 'text-red-400 bg-red-400/10',
                                    default => 'text-gray-400 bg-gray-400/10'
                                };
                            @endphp
                            <span class="text-xs px-2 py-1 rounded-full {{ $diffColor }}">{{ ucfirst($quiz->difficulty) }}</span>
                        </div>
                    @endif
                </div>
            @endforeach

            <div class="text-center reveal">
                <button type="submit" class="btn-primary text-lg px-10 py-4 pulse-ring">
                    📝 Submit Quiz
                </button>
                <p class="text-gray-500 text-sm mt-3">Answer all questions before submitting</p>
            </div>
        </form>
    </div>
</section>
@endsection

@push('scripts')
<script>
    function selectOption(quizId, optionIndex) {
        // Remove selected class from all options in this question
        document.querySelectorAll(`[id^="option-${quizId}-"]`).forEach(el => {
            el.classList.remove('selected');
        });
        // Add selected class to chosen option
        document.getElementById(`option-${quizId}-${optionIndex}`).classList.add('selected');
    }
</script>
@endpush
