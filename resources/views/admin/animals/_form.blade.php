{{-- Shared animal form partial for create/edit --}}
@if($errors->any())
    <div class="bg-red-500/20 border border-red-500/30 rounded-xl p-4 mb-4">
        <ul class="text-red-400 text-sm space-y-1">
            @foreach($errors->all() as $error)
                <li>• {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm text-gray-400 mb-1">Name *</label>
        <input type="text" name="name" value="{{ old('name', $animal->name ?? '') }}" required class="form-input w-full px-4 py-3">
    </div>
    <div>
        <label class="block text-sm text-gray-400 mb-1">Species *</label>
        <input type="text" name="species" value="{{ old('species', $animal->species ?? '') }}" required class="form-input w-full px-4 py-3">
    </div>
    <div>
        <label class="block text-sm text-gray-400 mb-1">Scientific Name *</label>
        <input type="text" name="scientific_name" value="{{ old('scientific_name', $animal->scientific_name ?? '') }}" required class="form-input w-full px-4 py-3">
    </div>
    <div>
        <label class="block text-sm text-gray-400 mb-1">Category *</label>
        <select name="category" required class="form-input w-full px-4 py-3">
            @foreach(['Mammal', 'Bird', 'Reptile', 'Fish', 'Amphibian', 'Insect'] as $cat)
                <option value="{{ $cat }}" {{ old('category', $animal->category ?? '') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm text-gray-400 mb-1">Habitat *</label>
        <select name="habitat_id" required class="form-input w-full px-4 py-3">
            @foreach($habitats as $habitat)
                <option value="{{ $habitat->id }}" {{ old('habitat_id', $animal->habitat_id ?? '') == $habitat->id ? 'selected' : '' }}>{{ $habitat->name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm text-gray-400 mb-1">Diet *</label>
        <select name="diet" required class="form-input w-full px-4 py-3">
            @foreach(['Carnivore', 'Herbivore', 'Omnivore'] as $diet)
                <option value="{{ $diet }}" {{ old('diet', $animal->diet ?? '') == $diet ? 'selected' : '' }}>{{ $diet }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm text-gray-400 mb-1">Lifespan *</label>
        <input type="text" name="lifespan" value="{{ old('lifespan', $animal->lifespan ?? '') }}" required class="form-input w-full px-4 py-3" placeholder="e.g., 10-15 years">
    </div>
    <div>
        <label class="block text-sm text-gray-400 mb-1">Conservation Status *</label>
        <select name="conservation_status" required class="form-input w-full px-4 py-3">
            @foreach(['Least Concern', 'Near Threatened', 'Vulnerable', 'Endangered', 'Critically Endangered'] as $status)
                <option value="{{ $status }}" {{ old('conservation_status', $animal->conservation_status ?? '') == $status ? 'selected' : '' }}>{{ $status }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm text-gray-400 mb-1">Weight</label>
        <input type="text" name="weight" value="{{ old('weight', $animal->weight ?? '') }}" class="form-input w-full px-4 py-3" placeholder="e.g., 190 kg">
    </div>
    <div>
        <label class="block text-sm text-gray-400 mb-1">Height</label>
        <input type="text" name="height" value="{{ old('height', $animal->height ?? '') }}" class="form-input w-full px-4 py-3" placeholder="e.g., 1.2 m">
    </div>
    <div>
        <label class="block text-sm text-gray-400 mb-1">Speed</label>
        <input type="text" name="speed" value="{{ old('speed', $animal->speed ?? '') }}" class="form-input w-full px-4 py-3" placeholder="e.g., 80 km/h">
    </div>
    <div>
        <label class="block text-sm text-gray-400 mb-1">Image URL</label>
        <input type="text" name="image" value="{{ old('image', $animal->image ?? '') }}" class="form-input w-full px-4 py-3" placeholder="https://...">
    </div>
</div>
<div>
    <label class="block text-sm text-gray-400 mb-1">Description *</label>
    <textarea name="description" rows="4" required class="form-input w-full px-4 py-3">{{ old('description', $animal->description ?? '') }}</textarea>
</div>
<div>
    <label class="block text-sm text-gray-400 mb-1">Fun Facts (one per line)</label>
    <textarea name="fun_facts" rows="4" class="form-input w-full px-4 py-3" placeholder="Enter one fun fact per line">{{ old('fun_facts', is_array($animal->fun_facts ?? null) ? implode("\n", $animal->fun_facts) : '') }}</textarea>
</div>
