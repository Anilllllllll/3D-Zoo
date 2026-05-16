@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'form-input w-full px-4 py-3 bg-white/5 border border-white/20 rounded-xl text-white placeholder-gray-500 focus:border-zoo-400 focus:ring-zoo-400/20']) }}>
