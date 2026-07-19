<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($title) ? $title . ' — Mandorin' : config('app.name', 'Mandorin') }}</title>
    <meta name="description"
        content="Mandorin — Platform digital penghubung kontraktor &amp; customer properti Indonesia.">

    <!-- Fonts: Inter (data/body) + Big Shoulders Display (heading) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Big+Shoulders+Display:wght@700;800&display=swap"
        rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="font-sans antialiased bg-slate-50">
    <div class="min-h-screen flex flex-col">
        <livewire:layout.navigation />

        <!-- Page Heading (optional slot) -->
        @if (isset($header))
            <header class="bg-white border-b border-slate-200">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main class="flex-1">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                {{ $slot }}
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-navy text-white/60 text-center text-xs py-4 mt-8">
            &copy; {{ date('Y') }} Mandorin — Platform Digital Konstruksi Indonesia
        </footer>
    </div>

    @livewireScripts
</body>

</html>
