@props(['title' => 'Authentification'])
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - LenSymphony</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 min-h-screen">

    <!-- Header minimaliste pour l'auth -->
    <header class="py-6">
        <div class="container mx-auto px-4">
            <a href="{{ route('home') }}" class="inline-flex items-center text-2xl font-bold text-gray-800 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                <svg class="w-8 h-8 mr-2" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 3v10.55c-.59-.34-1.27-.55-2-.55-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4V7h4V3h-6z"/>
                </svg>
                LenSymphony
            </a>
        </div>
    </header>

    <!-- Contenu principal -->
    <main class="px-4 py-8 flex items-center justify-center min-h-[calc(100vh-200px)]">
        {{ $slot }}
    </main>

    <!-- Footer minimaliste -->
    <footer class="py-6 text-center text-sm text-gray-600 dark:text-gray-400">
        <p>&copy; {{ date('Y') }} LenSymphony. Tous droits réservés.</p>
    </footer>

</body>
</html>

