<x-layouts.app title="Arrangements - LenSymphony">
    <div class="page-container">
        <div class="card">
            <h1 class="card-title">Arrangements</h1>

            @can('create', App\Models\Arrangement::class)
                <div class="card-actions">
                    <a href="{{ route('arrangements.create') }}" class="btn btn-primary">
                        Create arrangement
                    </a>
                </div>
            @endcan

            <ul class="list">
                @forelse($arrangements as $arrangement)
                    <li class="list-item">
                        <a href="{{ route('arrangements.show', $arrangement) }}" class="list-link">
                            {{ $arrangement->name }}
                        </a>

                        <div class="list-item-actions">
                            @can('update', $arrangement)
                                <a href="{{ route('arrangements.edit', $arrangement) }}" class="btn btn-outline btn-xs">
                                    Edit
                                </a>
                            @endcan

                            @can('delete', $arrangement)
                                <form action="{{ route('arrangements.destroy', $arrangement) }}" method="POST" style="display:inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-xs">
                                        Delete
                                    </button>
                                </form>
                            @endcan
                        </div>
                    </li>
                @empty
                    <li class="list-empty">No arrangements found.</li>
                @endforelse
            </ul>
        </div>
    </div>
</x-layouts.app>
