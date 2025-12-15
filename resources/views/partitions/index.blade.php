<x-layouts.app>
    <x-slot:title>Liste des Partitions</x-slot:title>

    <div class="page-container">
        <!-- Header avec titre et actions -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-bold text-shimmer">Partitions Musicales</h1>
                <p class="text-slate-400 mt-1">Découvrez et explorez les partitions de la communauté</p>
            </div>

            @auth
                @if(in_array(auth()->user()->role, ['arranger', 'admin']))
                    <a href="{{ route('partitions.create') }}" class="btn btn-primary">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Créer une partition
                    </a>
                @endif
            @endauth
        </div>

        <!-- Search bar (placeholder pour le futur) -->
        <div class="search-wrapper">
            <svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <input type="text" class="search-input" placeholder="Rechercher une partition, un compositeur..." disabled>
        </div>

        @if($partitions->count())
            <div class="partition-grid">
                @foreach($partitions as $partition)
                    <x-card-partition :partition="$partition" />
                @endforeach
            </div>

            <div class="mt-8 flex justify-center">
                {{ $partitions->links() }}
            </div>
        @else
            <div class="empty-state">
                <svg class="empty-state-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                </svg>
                <h3 class="empty-state-title">Aucune partition disponible</h3>
                <p class="empty-state-text">Soyez le premier à créer une partition !</p>
                @auth
                    @if(in_array(auth()->user()->role, ['arranger', 'admin']))
                        <a href="{{ route('partitions.create') }}" class="btn btn-primary mt-6">
                            Créer ma première partition
                        </a>
                    @endif
                @endauth
            </div>
        @endif
    </div>
</x-layouts.app>
