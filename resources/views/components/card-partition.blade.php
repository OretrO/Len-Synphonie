@props(['partition'])

<a href="{{ auth()->check() ? route('partitions.show', $partition) : route('login') }}" class="partition-card-new">
    <div class="partition-card-new-image">
        <div class="partition-card-new-gradient"></div>
        <svg class="partition-card-new-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
        </svg>
        
        {{-- Indicateur LED --}}
        @if($partition->arrangements_count > 0)
            <div class="partition-card-new-indicator partition-card-new-indicator-active"></div>
        @else
            <div class="partition-card-new-indicator"></div>
        @endif

        {{-- Bouton play au hover --}}
        <div class="partition-card-new-play">
            <svg fill="currentColor" viewBox="0 0 24 24">
                <path d="M8 5v14l11-7z"/>
            </svg>
        </div>
    </div>

    <div class="partition-card-new-content">
        <div class="partition-card-new-badge">Partition</div>
        
        <h3 class="partition-card-new-title" title="{{ $partition->title }}">
            {{ $partition->title }}
        </h3>

        @if($partition->composer)
            <p class="partition-card-new-composer">
                Par {{ $partition->composer }}
            </p>
        @endif

        <div class="partition-card-new-info">
            <div class="partition-card-new-info-item">
                <svg fill="currentColor" viewBox="0 0 24 24">
                    <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span>{{ $partition->created_at->format('d/m/Y') }}</span>
            </div>
            <div class="partition-card-new-info-item">
                <svg fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 3v10.55c-.59-.34-1.27-.55-2-.55-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4V7h4V3h-6z"/>
                </svg>
                <span>{{ $partition->arrangements_count ?? 0 }} arrangement{{ $partition->arrangements_count > 1 ? 's' : '' }}</span>
            </div>
        </div>

        <div class="partition-card-new-footer">
            <span class="partition-card-new-creator">
                Par {{ $partition->user->name }}
                @if(auth()->check() && $partition->user_id === auth()->id())
                    <span class="partition-card-new-you">(Vous)</span>
                @endif
            </span>
            <svg class="partition-card-new-arrow" fill="currentColor" viewBox="0 0 24 24">
                <path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"/>
            </svg>
        </div>
    </div>
</a>
