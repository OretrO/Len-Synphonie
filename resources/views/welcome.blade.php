<x-layouts.app title="LenSymphony - Music Sharing Platform">
    <div class="homepage-spotify">
        {{-- Fond animé avec barres audio --}}
        <div class="audio-visualizer">
            <div class="audio-bar"></div>
            <div class="audio-bar"></div>
            <div class="audio-bar"></div>
            <div class="audio-bar"></div>
            <div class="audio-bar"></div>
            <div class="audio-bar"></div>
            <div class="audio-bar"></div>
            <div class="audio-bar"></div>
            <div class="audio-bar"></div>
            <div class="audio-bar"></div>
            <div class="audio-bar"></div>
            <div class="audio-bar"></div>
            <div class="audio-bar"></div>
            <div class="audio-bar"></div>
            <div class="audio-bar"></div>
            <div class="audio-bar"></div>
            <div class="audio-bar"></div>
            <div class="audio-bar"></div>
            <div class="audio-bar"></div>
            <div class="audio-bar"></div>
        </div>

        {{-- Icônes musicales flottantes en fond --}}
        <div class="floating-music-icons">
            <svg class="music-icon" viewBox="0 0 24 24" fill="currentColor">
                <path d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
            </svg>
            <svg class="music-icon" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 3v10.55c-.59-.34-1.27-.55-2-.55-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4V7h4V3h-6z"/>
            </svg>
            <svg class="music-icon" viewBox="0 0 24 24" fill="currentColor">
                <path d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
            </svg>
            <svg class="music-icon" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 3v10.55c-.59-.34-1.27-.55-2-.55-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4V7h4V3h-6z"/>
            </svg>
            <svg class="music-icon" viewBox="0 0 24 24" fill="currentColor">
                <path d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
            </svg>
            <svg class="music-icon" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 3v10.55c-.59-.34-1.27-.55-2-.55-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4V7h4V3h-6z"/>
            </svg>
            <svg class="music-icon" viewBox="0 0 24 24" fill="currentColor">
                <path d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
            </svg>
            <svg class="music-icon" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 3v10.55c-.59-.34-1.27-.55-2-.55-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4V7h4V3h-6z"/>
            </svg>
        </div>

        {{-- Hero Section avec glassmorphism --}}
        <section class="spotify-hero">
            <div class="spotify-hero-background"></div>
            <div class="spotify-hero-content">
                @guest
                    <h1 class="spotify-hero-title">Welcome to LenSymphony</h1>
                    <p class="spotify-hero-subtitle">Discover, create and share your sheet music</p>
                    <div class="spotify-hero-actions">
                        <a href="{{ route('register') }}" class="spotify-btn spotify-btn-primary">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z"/>
                            </svg>
                            Get started for free
                        </a>
                        <a href="{{ route('login') }}" class="spotify-btn spotify-btn-secondary">
                            Log in
                        </a>
                    </div>
                @else
                    <h1 class="spotify-hero-title">Hello, {{ auth()->user()->name }}</h1>
                    <p class="spotify-hero-subtitle">
                        @if(auth()->user()->role === 'admin')
                            Manage your music platform
                        @elseif(auth()->user()->role === 'arranger')
                            Create and share your compositions
                        @else
                            Explore the music library
                        @endif
                    </p>
                    @if(in_array(auth()->user()->role, ['arranger', 'admin']))
                        <div class="spotify-hero-actions">
                            <a href="{{ route('partitions.create') }}" class="spotify-btn spotify-btn-primary">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                                </svg>
                                Create Score
                            </a>
                            <a href="{{ route('partitions.index') }}" class="spotify-btn spotify-btn-secondary">
                                View Library
                            </a>
                            <a>
                                <a href="{{ route('arrangements.index') }}" class="spotify-btn spotify-btn-secondary">
                                    Manage <Arrangements></Arrangements>
                            </a>
                        </div>
                    @endif
                @endauth
            </div>
        </section>

        {{-- Stats avec glassmorphism et animations --}}
        <section class="spotify-stats-section">
            <div class="spotify-stats-grid">
                <div class="spotify-stat-card">
                    <div class="spotify-stat-icon">
                        <svg fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                        </svg>
                    </div>
                    <div class="spotify-stat-content">
                        <div class="spotify-stat-number">{{ \App\Models\Partition::count() }}</div>
                        <div class="spotify-stat-label">Scores</div>
                    </div>
                </div>
                <div class="spotify-stat-card">
                    <div class="spotify-stat-icon">
                        <svg fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 3v10.55c-.59-.34-1.27-.55-2-.55-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4V7h4V3h-6z"/>
                        </svg>
                    </div>
                    <div class="spotify-stat-content">
                        <div class="spotify-stat-number">{{ \App\Models\Arrangement::count() }}</div>
                        <div class="spotify-stat-label">Arrangements</div>
                    </div>
                </div>
                <div class="spotify-stat-card">
                    <div class="spotify-stat-icon">
                        <svg fill="currentColor" viewBox="0 0 24 24">
                            <path d="M16 7c0-2.21-1.79-4-4-4S8 4.79 8 7s1.79 4 4 4 4-1.79 4-4zm-4 7c-2.67 0-8 1.34-8 4v3h16v-3c0-2.66-5.33-4-8-4z"/>
                        </svg>
                    </div>
                    <div class="spotify-stat-content">
                        <div class="spotify-stat-number">{{ \App\Models\User::count() }}</div>
                        <div class="spotify-stat-label">Musicians</div>
                    </div>
                </div>
                <div class="spotify-stat-card">
                    <div class="spotify-stat-icon">
                        <svg fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 3v10.55c-.59-.34-1.27-.55-2-.55-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4V7h4V3h-6z"/>
                        </svg>
                    </div>
                    <div class="spotify-stat-content">
                        <div class="spotify-stat-number">{{ \App\Models\Instrument::count() }}</div>
                        <div class="spotify-stat-label">Instruments</div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Section Partitions récentes --}}
        @if(isset($partitions) && $partitions->count() > 0)
            <section class="spotify-content-section">
                <div class="spotify-section-header">
                    <h2 class="spotify-section-title">Recent Scores</h2>
                    <a href="{{ route('partitions.index') }}" class="spotify-section-link">
                        View All
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"/>
                        </svg>
                    </a>
                </div>
                <div class="spotify-grid">
                    @foreach($partitions->take(6) as $partition)
                        <x-card-partition :partition="$partition" />
                    @endforeach
                </div>
            </section>
        @else
            <section class="spotify-content-section">
                <div class="spotify-empty-state">
                    <svg class="spotify-empty-icon" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                    </svg>
                    <h3 class="spotify-empty-title">No scores available</h3>
                    <p class="spotify-empty-text">Start by creating your first score</p>
                    @auth
                        @if(in_array(auth()->user()->role, ['arranger', 'admin']))
                            <a href="{{ route('partitions.create') }}" class="spotify-btn spotify-btn-primary">
                                Create a score
                            </a>
                        @endif
                    @else
                        <a href="{{ route('register') }}" class="spotify-btn spotify-btn-primary">
                            Sign up
                        </a>
                    @endauth
                </div>
            </section>
        @endif

        {{-- Section Features pour les visiteurs --}}
        @guest
            <section class="spotify-features-section">
                <h2 class="spotify-features-title">Why choose LenSymphony?</h2>
                <div class="spotify-features-grid">
                    <div class="spotify-feature-card">
                        <div class="spotify-feature-icon">
                            <svg fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                            </svg>
                        </div>
                        <h3 class="spotify-feature-title">Rich library</h3>
                        <p class="spotify-feature-text">Access thousands of sheet music across genres and styles.</p>
                    </div>
                    <div class="spotify-feature-card">
                        <div class="spotify-feature-icon">
                            <svg fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                            </svg>
                        </div>
                        <h3 class="spotify-feature-title">Easy creation</h3>
                        <p class="spotify-feature-text">Create your own scores with intuitive and powerful tools.</p>
                    </div>
                    <div class="spotify-feature-card">
                        <div class="spotify-feature-icon">
                            <svg fill="currentColor" viewBox="0 0 24 24">
                                <path d="M16 7c0-2.21-1.79-4-4-4S8 4.79 8 7s1.79 4 4 4 4-1.79 4-4zm-4 7c-2.67 0-8 1.34-8 4v3h16v-3c0-2.66-5.33-4-8-4z"/>
                            </svg>
                        </div>
                        <h3 class="spotify-feature-title">Active community</h3>
                        <p class="spotify-feature-text">Join a community of passionate musicians and share your creations.</p>
                    </div>
                </div>
            </section>
        @endguest
    </div>
</x-layouts.app>
