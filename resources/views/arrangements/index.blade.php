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
                        <div class="flex justify-between items-start">
                            <div>
                                <a href="{{ route('arrangements.show', $arrangement) }}" class="list-link text-lg font-bold">
                                    {{ $arrangement->name }}
                                </a>
                                <div class="text-sm text-slate-500 mt-1 flex flex-col gap-1">
                                    <span>Arrangeur: {{ $arrangement->creator->name ?? 'Unknown' }}</span>
                                    <span>Date: {{ $arrangement->created_at->format('d/m/Y') }}</span>
                                    <span>Popularité: {{ $arrangement->likesCount() }} likes</span>
                                </div>
                            </div>

                            <div class="list-item-actions ml-4">
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
                        </div>
                    </li>
                @empty
                    <li class="list-empty">No arrangements found.</li>
                @endforelse
            </ul>
        </div>
    </div>
</x-layouts.app>
