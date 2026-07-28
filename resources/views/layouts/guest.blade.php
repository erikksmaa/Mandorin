<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-900 bg-white">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative overflow-hidden bg-slate-50">
            <!-- Background element -->
            <div class="absolute inset-0 bg-gradient-to-br from-navy via-[#2d4080] to-navy opacity-10"></div>
            
            <div class="relative z-10 w-full sm:max-w-md mt-6 px-8 py-8 bg-white shadow-xl shadow-slate-200/50 overflow-hidden sm:rounded-2xl border border-slate-100">
                <div class="flex justify-center mb-8">
                    <a href="/" wire:navigate class="flex items-center gap-2">
                        <img src="{{ asset('logo.png') }}" alt="SIPORA" class="h-10 w-auto object-contain">
                        <span class="text-3xl font-bold text-navy" style="font-family: 'Big Shoulders Display', sans-serif;">SIPORA</span>
                    </a>
                </div>

                {{ $slot }}
            </div>
            
            <div class="relative z-10 mt-8 text-center text-sm text-slate-500">
                &copy; {{ date('Y') }} SIPORA. Platform Digital Konstruksi.
            </div>
        </div>
    </body>
</html>
