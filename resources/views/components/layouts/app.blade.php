@props(['title' => 'Page'])
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{{ $title ?? 'LenSymphony' }}</title>
    @vite('resources/css/app.css')
</head>
<body>

<x-navbar />

<main>
    {{ $slot }}
</main>

<x-footer />

</body>
</html>
