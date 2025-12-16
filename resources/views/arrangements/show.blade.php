<x-layouts.app title="{{ $arrangement->name }} - LenSymphony">
    <div class="page-container">
        <div class="card">
            <h1 class="card-title">{{ $arrangement->name }}</h1>

            <p class="card-text">Partition ID: {{ $arrangement->partition_id }}</p>

            <div class="card-actions">
                @can('update', $arrangement)
                    <a href="{{ route('arrangements.edit', $arrangement) }}" class="btn btn-outline">Edit arrangement</a>
                @endcan

                @can('delete', $arrangement)
                    <form action="{{ route('arrangements.destroy', $arrangement) }}" method="POST" style="display:inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete arrangement</button>
                    </form>
                @endcan
            </div>
        </div>
    </div>
</x-layouts.app>

