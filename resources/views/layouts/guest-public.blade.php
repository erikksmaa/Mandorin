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

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased bg-white text-slate-900">

    {{ $slot }}

    @livewireScripts
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const swalConfig = {
            confirmButtonColor: '#0f172a',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Lanjutkan',
            cancelButtonText: 'Batal',
        };

        const checkGuestSessionSwal = () => {
            @if(session('swal_modal'))
                const modalData = @json(session('swal_modal'));
                Swal.fire({
                    icon: modalData.icon ?? 'info',
                    title: modalData.title ?? '',
                    text: modalData.text ?? '',
                    confirmButtonText: 'OK, Mengerti',
                    ...swalConfig
                });
            @endif
            @if(session('swal_success'))
                Swal.fire({ icon: 'success', title: 'Berhasil!', text: @json(session('swal_success')), timer: 3000, showConfirmButton: false, toast: true, position: 'top-end', ...swalConfig });
            @endif
            @if(session('swal_error'))
                Swal.fire({ icon: 'error', title: 'Gagal!', text: @json(session('swal_error')), ...swalConfig });
            @endif
        };

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', checkGuestSessionSwal);
        } else {
            checkGuestSessionSwal();
        }
    </script>
</body>
</html>
