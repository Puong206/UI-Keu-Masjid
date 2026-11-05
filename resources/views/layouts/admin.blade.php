<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin — Masjid Al-Hidayah')</title>
    <link rel="stylesheet" href="/css/admin.css?v={{ filemtime(public_path('css/admin.css')) }}">
</head>
<body class="admin-body">
    @yield('content')
    @stack('scripts')
</body>
</html>
