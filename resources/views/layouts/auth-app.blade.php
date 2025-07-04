<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Dashboard'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Vite CSS -->
    @vite([
        'resources/scss/auth-app.scss',
        'resources/scss/dashboard.scss',
        'resources/scss/election.scss', 
        'resources/js/app.js',
        'resources/js/dashboard.js',
        'resources/js/election.js'
    ])

    @stack('styles')
</head>
<body class="auth-app font-montserrat">
    <div class="min-h-screen">
        <main class="auth-app-main">
            @yield('content')
        </main>
    </div>

    <!-- AlpineJS -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    
    @stack('scripts')
    @vite(['resources/js/auth-app.js'])
</body>
</html>