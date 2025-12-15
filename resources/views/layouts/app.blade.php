<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'LushInk') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-dark text-gray-200">
    <div class="min-h-screen">

        @include('layouts.navigation')

        {{-- Header opcional --}}
        @hasSection('header')
            <header class="bg-paper shadow">
                <div class="max-w-7xl mx-auto py-6 px-6">
                    @yield('header')
                </div>
            </header>
        @endif

        {{-- CONTENIDO PRINCIPAL --}}
        <main class="container mx-auto px-6 py-8">
            @yield('content')
        </main>

    </div>
</body>
</html>
