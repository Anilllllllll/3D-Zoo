@extends('layouts.app')
@section('title', 'Edit Quiz Question')
@section('content')
<section class="py-12 px-4">
    <div class="max-w-3xl mx-auto">
        <h1 class="section-title mb-8">✏️ Edit Question</h1>
        @if($errors->any())
            <div class="bg-red-500/20 border border-red-500/30 rounded-xl p-4 mb-4">
                <ul class="text-red-400 text-sm">@foreach($errors->all() as $e)<li>• {{ $e }}</li>@endforeach</ul>
            </div>
        @endif
        @php $options = $quiz->options; @endphp
        <form method="POST" action="{{ route('admin.quizzes.update', $quiz) }}" class="glass-card p-8 space-y-5">
            @csrf @method('PUT')
            <div><label class="block text-sm text-gray-400 mb-1">Question *</label><textarea name="question" rows="2" required class="form-input w-full px-4 py-3">{{ old('question', $quiz->question) }}</textarea></div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div><label class="block text-sm text-gray-400 mb-1">Option 1 *</label><input type="text" name="option_1" value="{{ old('option_1', $options[0] ?? '') }}" required class="form-input w-full px-4 py-3"></div>
                <div><label class="block text-sm text-gray-400 mb-1">Option 2 *</label><input type="text" name="option_2" value="{{ old('option_2', $options[1] ?? '') }}" required class="form-input w-full px-4 py-3"></div>
                <div><label class="block text-sm text-gray-400 mb-1">Option 3 *</label><input type="text" name="option_3" value="{{ old('option_3', $options[2] ?? '') }}" required class="form-input w-full px-4 py-3"></div>
                <div><label class="block text-sm text-gray-400 mb-1">Option 4 *</label><input type="text" name="option_4" value="{{ old('option_4', $options[3] ?? '') }}" required class="form-input w-full px-4 py-3"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div><label class="block text-sm text-gray-400 mb-1">Correct Answer *</label><input type="text" name="correct_answer" value="{{ old('correct_answer', $quiz->correct_answer) }}" required class="form-input w-full px-4 py-3"></div>
                <div><label class="block text-sm text-gray-400 mb-1">Difficulty *</label>
                    <select name="difficulty" required class="form-input w-full px-4 py-3">
                        <option value="easy" {{ old('difficulty', $quiz->difficulty) == 'easy' ? 'selected' : '' }}>Easy</option>
                        <option value="medium" {{ old('difficulty', $quiz->difficulty) == 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="hard" {{ old('difficulty', $quiz->difficulty) == 'hard' ? 'selected' : '' }}>Hard</option>
                    </select>
                </div>
                <div><label class="block text-sm text-gray-400 mb-1">Category</label><input type="text" name="category" value="{{ old('category', $quiz->category) }}" class="form-input w-full px-4 py-3"></div>
            </div>
            <button type="submit" class="btn-primary w-full py-3">Update Question</button>
        </form>
        <div class="mt-4"><a href="{{ route('admin.quizzes') }}" class="text-zoo-400 hover:underline">← Back</a></div>
    </div>
</section>
@endsection
