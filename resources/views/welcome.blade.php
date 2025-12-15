<x-layouts.app title="Accueil - LenSymphony">
    <div class="page-container">
        {{-- Hero Section avec message personnalisé --}}
        <div class="card bg-gradient-to-br from-indigo-900/40 to-purple-900/30 border-indigo-500/30">
            @guest
                <h1 class="card-title text-3xl">
                    Bienvenue sur LenSymphony 🎵
                </h1>

                <p class="card-text">
                    LenSymphony est une plateforme web permettant de gérer, organiser et visualiser
                    des partitions musicales au format MusicXML. Créez vos arrangements, partagez vos
                    créations et explorez les partitions de la communauté.
                </p>

                <p class="card-text text-slate-400">
                    Connectez-vous pour accéder aux partitions et découvrir toutes les fonctionnalités.
                </p>

                <div class="card-actions">
                    <a href="{{ route('register') }}" class="btn btn-primary btn-large">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                        Créer un compte
                    </a>
                    <a href="{{ route('login') }}" class="btn btn-outline btn-large">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        Se connecter
                    </a>
                </div>
            @else
                <h1 class="card-title text-3xl">
                    Bonjour, {{ auth()->user()->name }} !
                </h1>

                <p class="card-text">
                    @if(auth()->user()->role === 'admin')
                        En tant qu'<strong class="text-purple-400">Administrateur</strong>, vous avez accès à toutes les fonctionnalités de la plateforme.
                    @elseif(auth()->user()->role === 'arranger')
                        En tant qu'<strong class="text-indigo-400">Arrangeur</strong>, vous pouvez créer et gérer vos partitions et arrangements.
                    @elseif(auth()->user()->role === 'user')
                        En tant qu'<strong class="text-blue-400">Utilisateur</strong>, vous pouvez consulter les partitions et laisser des commentaires.
                    @else
                        Bienvenue sur LenSymphony ! Explorez les partitions disponibles.
                    @endif
                </p>

                <div class="card-actions">
                    @if(in_array(auth()->user()->role, ['arranger', 'admin']))
                        <a href="{{ route('partitions.create') }}" class="btn btn-primary">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Créer une partition
                        </a>
                    @endif
                    <a href="{{ route('partitions.index') }}" class="btn btn-outline">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                        </svg>
                        Toutes les partitions
                    </a>
                </div>
            @endguest
        </div>

        {{-- Section Partitions Récentes --}}
        @if(isset($partitions) && $partitions->count())
            <div class="home-section-header">
                <h2 class="home-section-title">Partitions récentes</h2>
                <p class="home-section-sub">
                    Découvrez les dernières partitions ajoutées à la plateforme.
                </p>
            </div>

            <div class="partition-grid">
                @foreach($partitions as $partition)
                    <x-card-partition :partition="$partition" />
                @endforeach
            </div>

            {{-- Bouton voir plus --}}
            @if($partitions->count() >= 6)
                <div class="flex justify-center mt-8">
                    <a href="{{ route('partitions.index') }}" class="btn btn-outline">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                        Voir toutes les partitions
                    </a>
                </div>
            @endif
        @else
            <div class="home-section-header">
                <h2 class="home-section-title">Partitions</h2>
            </div>

            <div class="card text-center py-12">
                <svg class="w-16 h-16 mx-auto mb-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                </svg>
                <p class="text-lg text-slate-400 mb-4">Aucune partition disponible pour le moment.</p>

                @auth
                    @if(in_array(auth()->user()->role, ['arranger', 'admin']))
                        <a href="{{ route('partitions.create') }}" class="btn btn-primary">
                            Créer la première partition
                        </a>
                    @else
                        <p class="text-sm text-slate-500">Les arrangers peuvent créer des partitions.</p>
                    @endif
                @else
                    <a href="{{ route('register') }}" class="btn btn-primary">
                        Créer un compte pour commencer
                    </a>
                @endauth
            </div>
        @endif

        {{-- Section Statistiques (visible seulement pour les connectés) --}}
        @auth
            <div class="home-section-header">
                <h2 class="home-section-title">Statistiques</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="card text-center">
                    <div class="text-4xl font-bold text-indigo-400 mb-2">
                        {{ \App\Models\Partition::count() }}
                    </div>
                    <div class="text-sm text-slate-400">Partitions</div>
                </div>

                <div class="card text-center">
                    <div class="text-4xl font-bold text-purple-400 mb-2">
                        {{ \App\Models\Arrangement::count() }}
                    </div>
                    <div class="text-sm text-slate-400">Arrangements</div>
                </div>

                <div class="card text-center">
                    <div class="text-4xl font-bold text-blue-400 mb-2">
                        {{ \App\Models\User::count() }}
                    </div>
                    <div class="text-sm text-slate-400">Utilisateurs</div>
                </div>

                <div class="card text-center">
                    <div class="text-4xl font-bold text-emerald-400 mb-2">
                        {{ \App\Models\Instrument::count() }}
                    </div>
                    <div class="text-sm text-slate-400">Instruments</div>
                </div>
            </div>
        @endauth
    </div>
</x-layouts.app>
