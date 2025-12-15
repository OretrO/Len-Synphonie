<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'LenSymphony')</title>
    @vite('resources/css/app.css')
</head>
<body>

    <x-navbar />

    <main>
        @yield('content')
    </main>

    <x-footer />

</body>
</html>
