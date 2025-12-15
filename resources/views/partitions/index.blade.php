<x-layouts.app title="Partitions - LenSymphony">
    <div class="page-container">
        <div class="card">
            <div class="card-header-row">
                <h1 class="card-title">Scores</h1>

                @can('create', App\Models\Partition::class)
                    <div class="card-actions">
                        <a href="{{ route('partitions.create') }}" class="btn btn-primary">
                            Create partition
                        </a>
                    </div>
                @endcan
            </div>

            @if($partitions->count())
                <div class="partition-grid">
                    @foreach($partitions as $partition)
                        <x-card-partition :partition="$partition" />
                    @endforeach
                </div>
            @else
                <p class="home-empty-text">No scores available yet.</p>
            @endif
        </div>
    </div>
</x-layouts.app>

