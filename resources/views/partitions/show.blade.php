<x-layouts.app title="{{ $partition->title }} - LenSymphony">
    <div class="page-container">
        <div class="card">
            <h1 class="card-title">Score details</h1>

            <x-card-partition :partition="$partition" />

            <div class="card-actions">
                @can('update', $partition)
                    <a href="{{ route('partitions.edit', $partition) }}" class="btn btn-outline">
                        Edit partition
                    </a>
                @endcan

                @can('delete', $partition)
                    <form action="{{ route('partitions.destroy', $partition) }}" method="POST" style="display:inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete partition</button>
                    </form>
                @endcan
            </div>
        </div>
    </div>
</x-layouts.app>

