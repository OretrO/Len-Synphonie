@props(['title' => 'Authentification'])
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - LenSymphony</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 min-h-screen flex flex-col">

    <!-- Header -->
    <x-auth.header />

    <!-- Contenu principal -->
    <main class="flex-1 px-4 py-8 flex items-center justify-center">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <x-auth.footer />

</body>
</html>

