<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @isset($seo){{ $seo }}@endisset
    @empty($seo)
        <title>{{ $title ?? 'SIPORA — Sistem Informasi Program Olahraga dan Kepemudaan' }}</title>
        <meta name="description" content="{{ $description ?? 'Sistem Informasi Program Olahraga dan Kepemudaan Dinas Dindikpora.' }}">
    @endempty

    <!-- Open Graph -->
    <meta property="og:title" content="SIPORA — Platform Digital Konstruksi Indonesia">
    <meta property="og:description" content="Temukan kontraktor terpercaya untuk program Anda. Terverifikasi, transparan, dan mudah.">
    <meta property="og:type" content="website">

    <!-- Fonts: Inter + Big Shoulders Display -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Big+Shoulders+Display:wght@700;800;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased bg-white text-slate-900">

    {{ $slot }}

    @livewireScripts
</body>
</html>
