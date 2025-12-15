<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'LenSymphony')</title>
    @vite('resources/css/app.css')
</head>
<body>

@include('components.navbar')

<main>
    @yield('content')
</main>

@include('components.footer')

</body>
</html>
