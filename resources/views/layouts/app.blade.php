<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'E-Voting System')</title>

    <!-- Load Montserrat font -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Vite CSS -->
    @vite(['resources/scss/navigation.scss',
    'resources/scss/welcome.scss', 'resources/js/app.js'])
</head>
<body class="font-montserrat">
    @include('layouts.navigation')

    <main>
        @yield('content')
    </main>

    @vite('resources/js/navigation.js')
    @vite('resources/js/welcome.js')
</body>
</html>