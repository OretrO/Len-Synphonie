<nav class="navbar">
    <div class="navbar-inner">
        <a href="{{ route('home') }}" class="navbar-logo">
            LenSymphony
        </a>

        <div class="navbar-links">
            <a href="{{ route('home') }}" class="navbar-link">Home</a>
            <a href="{{ route('about') }}" class="navbar-link">About</a>
            <a href="{{ route('contact') }}" class="navbar-link">Contact</a>

            @auth
                {{-- CAS 1 : L'utilisateur est CONNECTÉ --}}

                {{-- Lien vers le profil (Source: 56, 102) --}}
                <a href="{{ route('profile.edit') }}" class="navbar-link">
                    Mon Profil ({{ Auth::user()->name }})
                </a>

                {{-- Bouton Déconnexion (DOIT être un formulaire pour sécurité CSRF) --}}
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="navbar-link" style="background:none; border:none; cursor:pointer; font: inherit;">
                        Déconnexion
                    </button>
                </form>

            @else
                {{-- CAS 2 : L'utilisateur est un VISITEUR (Source: 58) --}}
                <a href="{{ route('register') }}" class="navbar-link">Inscription</a>
                <a href="{{ route('login') }}" class="navbar-link">Login</a>
            @endauth
        </div>
    </div>
</nav>
