@props(['title' => 'Authentification'])
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - LenSymphony</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="auth-layout">

    <!-- Header -->
    <header class="auth-header">
        <div class="max-w-7xl mx-auto px-4 flex items-center justify-between">
            <a href="{{ route('home') }}" class="navbar-logo">
                🎵 LenSymphony
            </a>
            <nav class="flex items-center gap-4">
                <a href="{{ route('home') }}" class="navbar-link">Accueil</a>
                @guest
                    <a href="{{ route('login') }}" class="navbar-link">Connexion</a>
                    <a href="{{ route('register') }}" class="btn btn-primary">Inscription</a>
                @else
                    <span class="text-sm text-slate-400">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="navbar-link text-red-400 hover:text-red-300">Déconnexion</button>
                    </form>
                @endguest
            </nav>
        </div>
    </header>

    <!-- Contenu principal -->
    <main class="flex-1 px-4 py-12 flex items-center justify-center relative z-10">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="auth-footer">
        <p class="auth-footer-text">
            &copy; {{ date('Y') }} LenSymphony - Projet SAE S3.A.01 - IUT de Lens
        </p>
    </footer>

</body>
</html>

