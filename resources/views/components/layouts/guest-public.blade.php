<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- SEO --}}
    @isset($seo){{ $seo }}@endisset
    @empty($seo)
        <title>{{ $title ?? 'Mandorin — Platform Digital Konstruksi Indonesia' }}</title>
        <meta name="description" content="{{ $description ?? 'Temukan kontraktor & mandor terpercaya di Mandorin.' }}">
    @endempty

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Big+Shoulders+Display:wght@700;800;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>
</head>
<body class="font-sans antialiased bg-white text-slate-900">

    {{ $slot }}

    @livewireScripts

    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('swal-success', ({ title, text }) => {
                Swal.fire({ icon: 'success', title, text, timer: 2500, showConfirmButton: false, toast: true, position: 'top-end' });
            });
            Livewire.on('swal-error', ({ title, text }) => {
                Swal.fire({ icon: 'error', title, text });
            });
        });
    </script>
</body>
</html>
