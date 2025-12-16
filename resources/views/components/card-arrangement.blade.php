@props(['arrangement', 'currentUser' => null])

<div class="partition-card p-4">
    <div class="flex items-start justify-between">
        <div>
            <h4 class="font-semibold">{{ $arrangement->name }}</h4>
            <p class="text-xs text-slate-400">Status: <strong class="text-slate-200">{{ $arrangement->status }}</strong></p>
            <p class="text-xs text-slate-400">By: {{ $arrangement->creator?->name ?? '—' }}</p>
        </div>
        <div class="text-xs text-slate-400">{{ optional($arrangement->created_at)->diffForHumans() }}</div>
    </div>

    @php
        // Normalize instruments config (accepts array, collection or JSON string)
        $cfg = [];
        $raw = $arrangement->instruments_config ?? null;
        if ($raw instanceof \Illuminate\Support\Collection) {
            $raw = $raw->toArray();
        }
        if (is_array($raw)) {
            $cfg = $raw;
        } elseif (is_string($raw) && strlen(trim($raw)) > 0) {
            $decoded = @json_decode($raw, true);
            if (is_array($decoded)) {
                $cfg = $decoded;
            }
        }
    @endphp

    @if(count($cfg))
        <div class="mt-3">
            <h5 class="text-sm font-semibold">Instruments</h5>
            <ul class="text-sm text-slate-400 mt-2 space-y-1">
                @foreach($cfg as $inst)
                    <li>{{ $inst['name'] ?? 'Instrument' }} — vol: {{ $inst['volume'] ?? '—' }} — pan: {{ $inst['pan'] ?? 0 }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(!empty($arrangement->audio_file_path))
        <div class="mt-3">
            <audio id="audio-{{ $arrangement->id }}" src="{{ asset($arrangement->audio_file_path) }}"></audio>
        </div>
    @endif

    <div class="mt-3 flex items-center gap-2">
        @if(\Illuminate\Support\Facades\Route::has('arrangements.show'))
            <a href="{{ route('arrangements.show', $arrangement) }}" class="btn btn-outline btn-small">Voir</a>
        @else
            <span class="btn btn-outline btn-small opacity-50 cursor-not-allowed">Voir</span>
        @endif

        @if(!empty($arrangement->audio_file_path))
            <button type="button" onclick="(function(id){const a=document.getElementById('audio-'+id); if(!a) return; if(a.paused){a.play();} else {a.pause(); a.currentTime=0;}})({{ $arrangement->id }})" class="btn btn-outline btn-small">Jouer</button>
        @else
            <button type="button" class="btn btn-outline btn-small opacity-50 cursor-not-allowed" disabled>Jouer</button>
        @endif

        @if($currentUser instanceof \App\Models\User && ($currentUser->id === ($arrangement->creator_id ?? null) || $currentUser->role === 'admin'))
            @if(\Illuminate\Support\Facades\Route::has('arrangements.edit'))
                <a href="{{ route('arrangements.edit', $arrangement) }}" class="btn btn-outline btn-small">Edit</a>
            @endif
        @endif
    </div>
</div>

