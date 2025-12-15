<x-layouts.app title="Accueil - LenSymphony">
    <div class="page-container">
        <div class="card">
            <h1 class="card-title">Welcome to LenSymphony</h1>

            <p class="card-text">
                LenSymphony-Web is a web application to manage, organize and view
                MusicXML scores, developed as part of the SAE S3.A.01 project at
                IUT de Lens.
            </p>

            <p class="card-text card-text-muted">
                Use the navigation bar at the top to explore the project or contact the team.
            </p>

            <div class="card-actions">
                <a href="{{ route('about') }}" class="btn btn-primary">About</a>
                <a href="{{ route('contact') }}" class="btn btn-outline">Contact</a>
            </div>
        </div>

        @if(isset($partitions) && $partitions->count())
            <div class="home-section-header">
                <h2 class="home-section-title">Latest scores</h2>
                <p class="home-section-sub">
                    A quick overview of the most recent scores available in LenSymphony.
                </p>
            </div>

            <div class="partition-grid">
                @foreach($partitions as $partition)
                    <x-card-partition :partition="$partition" />
                @endforeach
            </div>
        @else
            <p class="home-empty-text">
                No scores available yet. Add some scores to see them here.
            </p>
        @endif
    </div>
</x-layouts.app>
