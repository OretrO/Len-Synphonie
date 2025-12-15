<nav class="navbar">
    <div class="navbar-inner">
        <a href="{{ route('home') }}" class="navbar-logo">
            🎵 LenSymphony
        </a>

        <div class="navbar-links">
            <a href="{{ route('home') }}" class="navbar-link {{ request()->routeIs('home') ? 'bg-indigo-500/20 text-indigo-300' : '' }}">
                Accueil
            </a>

            <a href="{{ route('partitions.index') }}" class="navbar-link {{ request()->routeIs('partitions.*') ? 'bg-indigo-500/20 text-indigo-300' : '' }}">
                Partitions
            </a>

            @auth
                {{-- Menu pour les utilisateurs connectés --}}
                @if(in_array(auth()->user()->role, ['arranger', 'admin']))
                    <a href="{{ route('partitions.create') }}" class="navbar-link text-emerald-400 hover:text-emerald-300 hover:bg-emerald-500/10">
                        <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Créer
                    </a>
                @endif

                {{-- Badge de rôle --}}
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold
                    {{ auth()->user()->role === 'admin' ? 'bg-purple-500/20 text-purple-300 border border-purple-500/30' : '' }}
                    {{ auth()->user()->role === 'arranger' ? 'bg-indigo-500/20 text-indigo-300 border border-indigo-500/30' : '' }}
                    {{ auth()->user()->role === 'user' ? 'bg-blue-500/20 text-blue-300 border border-blue-500/30' : '' }}
                    {{ auth()->user()->role === 'visitor' ? 'bg-slate-500/20 text-slate-300 border border-slate-500/30' : '' }}">
                    {{ ucfirst(auth()->user()->role) }}
                </span>

                {{-- Menu utilisateur --}}
                <div class="relative group">
                    <a href="{{ route('profile.show') }}" class="navbar-link flex items-center gap-2">
                        @if(auth()->user()->avatar && auth()->user()->avatar !== 'avatars/default.svg')
                            <img src="{{ Storage::url(auth()->user()->avatar) }}" alt="Avatar" class="w-6 h-6 rounded-full object-cover border border-indigo-500/50">
                        @else
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        @endif
                        <span class="hidden sm:inline">{{ auth()->user()->name }}</span>
                    </a>

                    {{-- Dropdown menu (hover) --}}
                    <div class="absolute right-0 mt-2 w-48 bg-slate-900 border border-slate-700 rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                        <div class="py-1">
                            <div class="px-4 py-2 text-xs text-slate-400 border-b border-slate-700">
                                {{ auth()->user()->email }}
                            </div>

                            <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-slate-300 hover:bg-slate-800 transition-colors">
                                <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Mon Profil
                            </a>

                            @if(in_array(auth()->user()->role, ['arranger', 'admin']))
                                <a href="{{ route('partitions.index') }}" class="block px-4 py-2 text-sm text-slate-300 hover:bg-slate-800 transition-colors">
                                    <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                    </svg>
                                    Mes Partitions
                                </a>
                            @endif

                            <form method="POST" action="{{ route('logout') }}" class="border-t border-slate-700 mt-1 pt-1">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-400 hover:bg-slate-800 transition-colors">
                                    <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    Déconnexion
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                {{-- Menu pour les visiteurs non connectés --}}
                <a href="{{ route('login') }}" class="navbar-link">
                    Connexion
                </a>
                <a href="{{ route('register') }}" class="btn btn-primary text-xs px-4 py-2">
                    Inscription
                </a>
            @endauth
        </div>
    </div>
</nav>
