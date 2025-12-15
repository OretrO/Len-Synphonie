<x-layouts.app>
    <x-slot:title>{{ $partition->title }}</x-slot:title>

    <div class="page-container">
        <div class="partition-header">
            <h1 class="partition-title">{{ $partition->title }}</h1>

            @auth
                @if(auth()->user()->id === $partition->user_id || auth()->user()->role === 'admin')
                    <div class="partition-actions">
                        <a href="{{ route('partitions.edit', $partition) }}" class="btn btn-outline">
                            Modifier
                        </a>
                        <form action="{{ route('partitions.destroy', $partition) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette partition ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Supprimer</button>
                        </form>
                    </div>
                @endif
            @endauth
        </div>

        <div class="partition-info">
            @if($partition->composer)
                <p class="partition-composer">
                    <strong>Compositeur :</strong> {{ $partition->composer }}
                </p>
            @endif

            <p class="partition-meta">
                <strong>Créée par :</strong> {{ $partition->user->name }}
            </p>

            <p class="partition-meta">
                <strong>Date :</strong> {{ $partition->created_at->format('d/m/Y') }}
            </p>
        </div>

        <div class="partition-arrangements">
            <h2 class="section-title">Arrangements</h2>

            @if($partition->arrangements->count())
                <div class="arrangements-list">
                    @foreach($partition->arrangements as $arrangement)
                        <div class="arrangement-card">
                            <h3>{{ $arrangement->name }}</h3>
                            <p><strong>Statut :</strong> {{ $arrangement->status }}</p>
                            <p><strong>Créé le :</strong> {{ $arrangement->created_at->format('d/m/Y') }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="empty-text">Aucun arrangement pour cette partition.</p>
            @endif
        </div>

        <a href="{{ route('partitions.index') }}" class="btn btn-outline">← Retour à la liste</a>
    </div>

    <style>
    .partition-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #333;
    }

    .partition-title {
        font-size: 2rem;
        font-weight: 700;
        color: #f5f5f5;
        margin: 0;
    }

    .partition-actions {
        display: flex;
        gap: 1rem;
    }

    .partition-actions form {
        margin: 0;
    }

    .partition-info {
        background: #1a1a1a;
        padding: 1.5rem;
        border-radius: 0.5rem;
        margin-bottom: 2rem;
    }

    .partition-composer, .partition-meta {
        margin: 0.5rem 0;
        color: #d1d5db;
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #f5f5f5;
        margin: 2rem 0 1rem;
    }

    .arrangements-list {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 1rem;
    }

    .arrangement-card {
        background: #1a1a1a;
        padding: 1rem;
        border-radius: 0.5rem;
        border: 1px solid #333;
    }

    .arrangement-card h3 {
        margin: 0 0 0.5rem;
        color: #f5f5f5;
    }

    .arrangement-card p {
        margin: 0.25rem 0;
        font-size: 0.875rem;
        color: #9ca3af;
    }

    .empty-text {
        color: #6b7280;
        font-style: italic;
    }

    .btn-danger {
        background-color: #dc2626;
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        cursor: pointer;
        font-weight: 500;
    }

    .btn-danger:hover {
        background-color: #b91c1c;
    }
    </style>
</x-layouts.app>

