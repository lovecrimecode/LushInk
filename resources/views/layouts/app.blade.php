<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'LushInk') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-ink text-gray-200">
    <div class="min-h-screen">

        @include('layouts.navigation')

        @hasSection('header')
            <header class="border-b border-white/5 bg-ink2/60 backdrop-blur">
                <div class="max-w-7xl mx-auto py-6 px-6">
                    @yield('header')
                </div>
            </header>
        @endif

        {{-- CONTENIDO PRINCIPAL --}}
        <main class="container mx-auto px-6 py-8">
            @yield('content')
        </main>

        <footer class="mt-10 border-t border-white/5">
            <div class="max-w-7xl mx-auto px-6 py-6 text-sm text-zinc-500">
                © {{ date('Y') }} LushInk | Lectura moderna
            </div>
        </footer>
    </div>
</body>
</html>
