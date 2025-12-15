<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>{{ $title ?? 'LenSymphony' }}</title>
    @vite('resources/css/app.css')
</head>
<body>

@include('components.navbar')

<main>
    {{ $slot }}
</main>

@include('components.footer')

</body>
</html>

