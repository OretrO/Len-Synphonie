@props(['partition'])

<div class="partition-card">
    <div class="partition-card-header">
        {{-- Indicateur LED selon le statut --}}
        <div class="absolute top-2 right-2 flex items-center gap-2">
            @if($partition->arrangements_count > 0)
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse shadow-lg shadow-emerald-400/50" title="Arrangements disponibles"></span>
            @else
                <span class="w-2 h-2 rounded-full bg-slate-600" title="Aucun arrangement"></span>
            @endif
        </div>

        <svg class="partition-card-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
        </svg>
    </div>

    <div class="partition-card-body">
        <span class="partition-badge">
            Partition
        </span>

        <h3 class="partition-title" title="{{ $partition->title }}">
            {{ $partition->title }}
        </h3>

        @if($partition->composer)
            <p class="partition-meta">
                Par <span class="partition-meta-strong">{{ $partition->composer }}</span>
            </p>
        @endif

        <p class="partition-meta text-xs">
            Créée par
            <span class="partition-meta-strong">{{ $partition->user->name }}</span>
            @if($partition->user_id === auth()->id())
                <span class="text-indigo-400">(Vous)</span>
            @endif
        </p>

        <div class="partition-meta-row">
            <div class="partition-meta-item" title="Date de création">
                <svg class="partition-meta-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                {{ $partition->created_at->format('d/m/Y') }}
            </div>

            <div class="partition-meta-item" title="Nombre d'arrangements">
                <svg class="partition-meta-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                </svg>
                {{ $partition->arrangements_count ?? 0 }}
            </div>
        </div>
    </div>

    <div class="partition-card-footer">
        @auth
            {{-- Utilisateurs connectés peuvent voir les détails --}}
            <a href="{{ route('partitions.show', $partition) }}" class="partition-link">
                <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                Voir les détails
            </a>
        @else
            {{-- Visiteurs non connectés --}}
            <a href="{{ route('login') }}" class="text-xs text-slate-400 hover:text-indigo-400 transition-colors">
                <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                Connectez-vous pour voir
            </a>
        @endauth

        <div class="partition-actions">
            @auth
                {{-- Modifier : propriétaire ou admin --}}
                @if(auth()->user()->id === $partition->user_id || auth()->user()->role === 'admin')
                    <a href="{{ route('partitions.edit', $partition) }}" class="partition-action partition-action-edit" title="Modifier">
                        <svg class="partition-action-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </a>

                    {{-- Supprimer : propriétaire ou admin --}}
                    <form action="{{ route('partitions.destroy', $partition) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette partition ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="partition-action partition-action-delete" title="Supprimer">
                            <svg class="partition-action-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </form>
                @endif
            @endauth
        </div>
    </div>
</div>
