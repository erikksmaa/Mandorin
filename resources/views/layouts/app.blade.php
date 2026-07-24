<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($title) ? $title . ' — SIPORA' : config('app.name', 'SIPORA') }}</title>
    <meta name="description"
        content="SIPORA — Sistem Informasi Program Olahraga dan Kepemudaan.">

    <!-- Fonts: Inter (data/body) + Big Shoulders Display (heading) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Big+Shoulders+Display:wght@700;800&display=swap"
        rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
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
        <div class="mt-8">
            <x-public.footer />
        </div>
    </div>

    @livewireScripts
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const swalConfig = {
            confirmButtonColor: '#0f172a',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Lanjutkan',
            cancelButtonText: 'Batal',
        };

        // Listen for Livewire-dispatched SweetAlert events
        document.addEventListener('livewire:init', () => {
            const handleSuccess = (data) => {
                const msg = typeof data === 'string' ? data : (data?.message ?? data[0]?.text ?? data[0]?.message ?? 'Berhasil!');
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: msg,
                    timer: 2500,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end',
                    ...swalConfig,
                });
            };

            const handleError = (data) => {
                const msg = typeof data === 'string' ? data : (data?.message ?? data[0]?.text ?? data[0]?.message ?? 'Terjadi kesalahan');
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: msg,
                    ...swalConfig,
                });
            };

            const handleWarning = (data) => {
                const msg = typeof data === 'string' ? data : (data?.message ?? data[0]?.text ?? data[0]?.message ?? 'Peringatan');
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian',
                    text: msg,
                    ...swalConfig,
                });
            };

            Livewire.on('swal-success', handleSuccess);
            Livewire.on('swal:success', handleSuccess);
            Livewire.on('swal-error', handleError);
            Livewire.on('swal:error', handleError);
            Livewire.on('swal:warning', handleWarning);

            Livewire.on('swal-confirm', (data) => {
                Swal.fire({
                    icon: 'warning',
                    title: data[0]?.title ?? 'Konfirmasi',
                    text: data[0]?.text ?? 'Apakah Anda yakin?',
                    showCancelButton: true,
                    ...swalConfig,
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.find(data[0]?.componentId)?.call(data[0]?.method, ...(data[0]?.params ?? []));
                    }
                });
            });
        });
        // Handle post-redirect SweetAlert notifications from session
        const checkSessionSwal = () => {
            @if(session('swal_success'))
                Swal.fire({ icon: 'success', title: 'Berhasil!', text: @json(session('swal_success')), timer: 2500, showConfirmButton: false, toast: true, position: 'top-end', ...swalConfig });
            @endif
            @if(session('swal_error'))
                Swal.fire({ icon: 'error', title: 'Gagal!', text: @json(session('swal_error')), ...swalConfig });
            @endif
        };

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', checkSessionSwal);
        } else {
            checkSessionSwal();
        }
    </script>
</body>

</html>
