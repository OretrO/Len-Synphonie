@props(['partition' => $partition])

<div class="partition-card">
    <div class="partition-card-header">
        <svg class="partition-card-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
        </svg>
    </div>

    <div class="partition-card-body">
        <span class="partition-badge">
            {{ $partition->genre ?? 'Uncategorized' }}
        </span>

        <h3 class="partition-title" title="{{ $partition->title }}">
            {{ $partition->title }}
        </h3>

        <p class="partition-meta">
            By <span class="partition-meta-strong">{{ $partition->composer }}</span>
        </p>

        <div class="partition-meta-row">
            <div class="partition-meta-item" title="Creation date">
                <svg class="partition-meta-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                {{ $partition->created_at->format('d/m/Y') }}
            </div>

            <div class="partition-meta-item" title="Number of arrangements">
                <svg class="partition-meta-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                </svg>
                {{ $partition->arrangements_count ?? 0 }}
            </div>
        </div>
    </div>

    <div class="partition-card-footer">
        @auth
            <a href="{{ route('partitions.show', $partition) }}" class="partition-link">
                View details
            </a>
        @else
            <span class="partition-locked-text">Log in to see details</span>
        @endauth

        <div class="partition-actions">
            @can('update', $partition)
                <a href="{{ route('partitions.edit', $partition) }}" class="partition-action partition-action-edit" title="Edit">
                    <svg class="partition-action-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </a>
            @endcan

            @can('delete', $partition)
                <form action="{{ route('partitions.destroy', $partition) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this score?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="partition-action partition-action-delete" title="Delete">
                        <svg class="partition-action-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </form>
            @endcan
        </div>
    </div>
</div>
