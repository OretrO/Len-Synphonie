<header class="navbar">
    <div class="navbar-inner">
        <div class="navbar-left">
            {{-- Boutons de navigation (back/forward) optionnels --}}
            <button class="navbar-nav-btn" disabled>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <button class="navbar-nav-btn" disabled>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>

        <div class="navbar-center">
            {{-- Barre de recherche (à implémenter) --}}
        </div>

        <div class="navbar-right">
            @auth
                {{-- Badge de rôle --}}
                <span class="badge
                    {{ auth()->user()->role === 'admin' ? 'badge-admin' : '' }}
                    {{ auth()->user()->role === 'arranger' ? 'badge-arranger' : '' }}
                    {{ auth()->user()->role === 'user' ? 'badge-user' : '' }}">
                    {{ ucfirst(auth()->user()->role) }}
                </span>

                {{-- Menu utilisateur --}}
                <div class="relative user-dropdown-container">
                    <div class="navbar-user">
                        @if(auth()->user()->avatar && auth()->user()->avatar !== 'avatars/default.svg')
                            <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Avatar" class="navbar-avatar">
                        @else
                            <div class="navbar-avatar flex items-center justify-center">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                </svg>
                            </div>
                        @endif
                        <span class="navbar-username hidden md:inline">{{ auth()->user()->name }}</span>
                        <svg class="navbar-dropdown-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>

                    {{-- Dropdown menu --}}
                    <div class="dropdown-menu">
                        <div class="px-4 py-3 border-b border-gray-700">
                            <p class="text-sm font-semibold text-white">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-400 mt-1">{{ auth()->user()->email }}</p>
                        </div>

                        <a href="{{ route('profile.show') }}" class="dropdown-item">
                            <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            My Profile
                        </a>


                        <div class="border-t border-gray-700 mt-1 pt-1">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-left w-full hover:text-red-400">
                                    <svg class="w-4 h-4 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline text-xs px-4 py-2">
                    Login
                </a>
                <a href="{{ route('register') }}" class="btn btn-primary text-xs px-4 py-2">
                    Register
                </a>
            @endauth
        </div>
    </div>
</header>
