<x-layouts.app>
    <x-slot:title>Liste des Partitions</x-slot:title>

    <div class="page-container">
        <div class="page-header">
            <h1 class="page-title">Partitions Musicales</h1>

            @auth
                @if(in_array(auth()->user()->role, ['arranger', 'admin']))
                    <a href="{{ route('partitions.create') }}" class="btn btn-primary">
                        <svg class="btn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Créer une partition
                    </a>
                @endif
            @endauth
        </div>

        @if($partitions->count())
            <div class="partition-grid">
                @foreach($partitions as $partition)
                    <x-card-partition :partition="$partition" />
                @endforeach
            </div>

            <div class="pagination-wrapper">
                {{ $partitions->links() }}
            </div>
        @else
            <p class="home-empty-text">
                Aucune partition disponible pour le moment.
            </p>
        @endif
    </div>

    <style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    .page-title {
        font-size: 2rem;
        font-weight: 700;
        color: #f5f5f5;
        margin: 0;
    }

    .pagination-wrapper {
        margin-top: 2rem;
        display: flex;
        justify-content: center;
    }
    </style>
</x-layouts.app>

