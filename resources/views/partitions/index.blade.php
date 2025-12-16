<x-layouts.app>
    <x-slot:title>Sheet Music Library</x-slot:title>

    <div class="page-container">
        <!-- Header with title and actions -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-bold text-shimmer">Sheet Music</h1>
                <p class="text-slate-400 mt-1">Discover and explore community scores</p>
            </div>

            @auth
                @if(in_array(optional(auth()->user())->role, ['arranger', 'admin']))
                    <a href="{{ route('partitions.create') }}" class="btn btn-primary">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Create Score
                    </a>
                @endif
            @endauth
        </div>

        <!-- Search bar (functional) -->
        <form action="{{ route('partitions.search') }}" method="GET" class="search-wrapper" role="search">
            <label for="query" class="sr-only">Search scores</label>
            <svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>

            <input id="query" name="query" type="text" class="search-input" placeholder="Search for a score, composer..." value="{{ request('query', '') }}">

            <!-- Scope select: search in title, composer or both -->
            <label for="scope" class="sr-only">Scope</label>
            <select id="scope" name="scope" class="ml-2 px-2 py-1 border rounded bg-white">
                <option value="all" {{ request('scope', 'all') === 'all' ? 'selected' : '' }}>Tout</option>
                <option value="title" {{ request('scope') === 'title' ? 'selected' : '' }}>Titre</option>
                <option value="composer" {{ request('scope') === 'composer' ? 'selected' : '' }}>Compositeur</option>
                <option value="genre" {{ request('scope') === 'genre' ? 'selected' : '' }}>Genre</option>
            </select>

            <button type="submit" class="btn btn-secondary ml-2">Search</button>
        </form>

        @if($partitions->count())
            <div class="partition-grid">
                @foreach($partitions as $partition)
                    <x-card-partition :partition="$partition" />
                @endforeach
            </div>

            <div class="mt-8 flex justify-center">
                {{ $partitions->appends(request()->except('page'))->links() }}

        @else
            <div class="empty-state">
                <svg class="empty-state-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                </svg>
                <h3 class="empty-state-title">No scores available</h3>
                <p class="empty-state-text">Be the first to create a score!</p>
                @auth
                    @if(in_array(optional(auth()->user())->role, ['arranger', 'admin']))
                        <a href="{{ route('partitions.create') }}" class="btn btn-primary mt-6">
                            Create my first score
                        </a>
                    @endif
                @endauth
            </div>
        @endif
    </div>
</x-layouts.app>
