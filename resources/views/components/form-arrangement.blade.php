@props(['partition', 'instruments', 'arrangement' => null])

<form method="POST" action="{{ $arrangement ? route('arrangements.update', $arrangement) : route('partitions.arrangements.store', $partition) }}" class="space-y-4">
    @csrf
    @if($arrangement)
        @method('PUT')
    @endif

    <div>
        <label class="form-label">Nom de l'arrangement</label>
        <input name="name" type="text" value="{{ old('name', $arrangement->name ?? '') }}" class="form-input" required minlength="5" maxlength="50">
        @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="form-label">Description (optionnelle)</label>
        <textarea name="description" rows="4" class="form-input" maxlength="500">{{ old('description', $arrangement->description ?? '') }}</textarea>
        @error('description')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="form-label">Affectation des instruments par piste</label>
        <p class="text-xs text-slate-400">Sélectionnez un instrument pour chaque piste de la partition (ordre libre, chaque sélection crée une piste).</p>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mt-2">
            @foreach($instruments as $inst)
                <label class="inline-flex items-center gap-2">
                    <input type="checkbox" name="instruments[]" value="{{ $inst->id }}" @checked( in_array($inst->id, old('instruments', $arrangement ? ($arrangement->instruments->pluck('id')->toArray() ?? []) : [] )) ) class="form-checkbox">
                    <span class="text-sm">{{ $inst->name }}</span>
                </label>
            @endforeach
        </div>
        @error('instruments')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
    </div>

    <div class="flex items-center gap-3">
        <button class="btn btn-primary" type="submit">{{ $arrangement ? 'Mettre à jour' : 'Créer l\'arrangement' }}</button>
        <a href="{{ route('partitions.show', $partition) }}" class="btn btn-outline">Annuler</a>
    </div>
</form>
