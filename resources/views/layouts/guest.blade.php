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
                        <svg class="w-10 h-10 text-orange-500" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 8.25h3m-3 3.75h3M6.75 15h.008v.008H6.75V15z"/>
                        </svg>
                        <span class="text-3xl font-bold text-navy" style="font-family: 'Big Shoulders Display', sans-serif;">Mandorin</span>
                    </a>
                </div>

                {{ $slot }}
            </div>
            
            <div class="relative z-10 mt-8 text-center text-sm text-slate-500">
                &copy; {{ date('Y') }} Mandorin. Platform Digital Konstruksi.
            </div>
        </div>
    </body>
</html>
