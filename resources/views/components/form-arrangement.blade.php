@props(['partition' => null, 'partitions' => null, 'instruments', 'arrangement' => null])

@php
    // Determine form action depending on whether we are creating for a partition or globally
    if ($arrangement) {
        $formAction = route('arrangements.update', $arrangement);
        $formMethodHidden = method_field('PUT');
    } else {
        if (!empty($partition)) {
            $formAction = route('partitions.arrangements.store', $partition);
        } else {
            $formAction = route('arrangements.store');
        }
        $formMethodHidden = '';
    }

    // Cancel URL
    $cancelUrl = !empty($partition) ? route('partitions.show', $partition) : route('arrangements.index');
@endphp

<form method="POST" action="{{ $formAction }}" class="space-y-4">
    @csrf
    {!! $formMethodHidden !!}

    @if(empty($partition) && !empty($partitions))
        <div>
            <label class="form-label">Choisir une partition</label>
            <select name="partition_id" class="form-input" required>
                <option value="">-- Sélectionner --</option>
                @foreach($partitions as $p)
                    <option value="{{ $p->id }}" @selected(old('partition_id') == $p->id)>{{ $p->title }}</option>
                @endforeach
            </select>
            @error('partition_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>
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
        <a href="{{ $cancelUrl }}" class="btn btn-outline">Annuler</a>
    </div>
</form>
