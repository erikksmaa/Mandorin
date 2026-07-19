<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Mandorin — Platform Digital Konstruksi Indonesia</title>
        <meta name="description" content="Temukan kontraktor & mandor terpercaya, kelola proyek, dan pantau progres harian secara transparan bersama Mandorin.">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Big+Shoulders+Display:wght@700;800;900&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            .hero-gradient {
                background-color: #1E2A4A;
                background-image: linear-gradient(135deg, #1E2A4A 0%, #2d4080 60%, #1E2A4A 100%);
            }
            .hero-gradient.grid-blueprint {
                background-image:
                    linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
                    linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px),
                    linear-gradient(135deg, #1E2A4A 0%, #2d4080 60%, #1E2A4A 100%);
                background-size: 32px 32px, 32px 32px, 100% 100%;
            }
            .feature-card {
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            }
            .feature-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 20px 40px rgba(0,0,0,0.08);
            }
            .stat-number {
                font-family: 'Big Shoulders Display', sans-serif;
                font-size: 2.5rem;
                font-weight: 900;
                color: #F97316;
            }
            .hero-title {
                font-family: 'Big Shoulders Display', sans-serif;
                font-weight: 900;
                letter-spacing: -0.02em;
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-white">

        <!-- NAVBAR -->
        <nav class="bg-navy/95 backdrop-blur-sm sticky top-0 z-50 border-b border-white/10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center gap-2">
                        <svg class="w-7 h-7 text-orange-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 8.25h3m-3 3.75h3M6.75 15h.008v.008H6.75V15z"/>
                        </svg>
                        <span class="text-white text-xl font-bold">Mandorin</span>
                    </div>

                    <div class="flex items-center gap-3">
                        @if (Route::has('login'))
                            @auth
                                @php
                                    $dashRoute = match(auth()->user()->role?->value) {
                                        'contractor' => route('contractor.dashboard'),
                                        'admin'      => route('admin.dashboard'),
                                        default      => route('customer.dashboard'),
                                    };
                                @endphp
                                <a href="{{ $dashRoute }}"
                                   class="px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white text-sm font-medium rounded-xl transition">
                                    Masuk ke Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}"
                                   class="text-white/80 hover:text-white text-sm font-medium transition px-3 py-2">
                                    Masuk
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}"
                                       class="px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white text-sm font-medium rounded-xl transition">
                                        Daftar Gratis
                                    </a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        <!-- HERO -->
        <section class="hero-gradient grid-blueprint text-white overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-32">
                <div class="max-w-3xl">
                    <!-- Badge -->
                    <div class="inline-flex items-center gap-2 bg-orange-500/20 border border-orange-500/30 text-orange-300 text-sm font-medium px-3 py-1.5 rounded-full mb-6">
                        <span class="w-1.5 h-1.5 rounded-full bg-orange-400 animate-pulse"></span>
                        Platform Konstruksi Digital Indonesia
                    </div>

                    <h1 class="hero-title text-5xl lg:text-7xl text-white mb-6 leading-tight">
                        Temukan<br>
                        <span class="text-orange-400">Kontraktor</span><br>
                        Terpercaya
                    </h1>

                    <p class="text-white/70 text-lg lg:text-xl mb-10 leading-relaxed max-w-xl">
                        Mandorin menghubungkan pemilik properti dengan mandor berpengalaman.
                        Pantau progres proyek, kelola tim, dan laporan harian — semua dalam satu platform.
                    </p>

                    <div class="flex flex-wrap gap-3">
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                               class="px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-xl text-base transition shadow-lg shadow-orange-500/30">
                                Mulai Sekarang →
                            </a>
                        @endif
                        <a href="{{ route('login') }}"
                           class="px-6 py-3 bg-white/10 hover:bg-white/20 text-white font-semibold rounded-xl text-base border border-white/20 transition backdrop-blur-sm">
                            Masuk ke Akun
                        </a>
                    </div>
                </div>
            </div>

            <!-- Decorative wave -->
            <div class="h-16 relative overflow-hidden">
                <svg class="absolute bottom-0 w-full" viewBox="0 0 1440 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 32L48 37.3C96 43 192 53 288 58.7C384 64 480 64 576 58.7C672 53 768 43 864 42.7C960 43 1056 53 1152 56C1248 59 1344 56 1392 53.3L1440 51.2V64H0V32Z" fill="#f8fafc"/>
                </svg>
            </div>
        </section>

        <!-- STATS -->
        <section class="bg-slate-50 py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="text-center">
                        <div class="stat-number">500+</div>
                        <div class="text-slate-500 text-sm mt-1">Kontraktor Terdaftar</div>
                    </div>
                    <div class="text-center">
                        <div class="stat-number">1.2k+</div>
                        <div class="text-slate-500 text-sm mt-1">Proyek Selesai</div>
                    </div>
                    <div class="text-center">
                        <div class="stat-number">98%</div>
                        <div class="text-slate-500 text-sm mt-1">Kepuasan Customer</div>
                    </div>
                    <div class="text-center">
                        <div class="stat-number">34</div>
                        <div class="text-slate-500 text-sm mt-1">Kabupaten/Kota</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- FEATURES -->
        <section class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-14">
                    <h2 class="hero-title text-4xl lg:text-5xl text-slate-900 mb-4">
                        Semua yang Anda Butuhkan
                    </h2>
                    <p class="text-slate-500 text-lg max-w-2xl mx-auto">
                        Dari pencarian kontraktor hingga pelaporan harian — Mandorin digitalisasi seluruh proses konstruksi Anda.
                    </p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Feature 1 -->
                    <div class="feature-card bg-white border border-slate-200 rounded-2xl p-6">
                        <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-slate-800 mb-2">Cari Kontraktor Terverifikasi</h3>
                        <p class="text-slate-500 text-sm leading-relaxed">
                            Temukan mandor & kontraktor yang sudah diverifikasi identitasnya. Filter berdasarkan layanan, rating, dan lokasi.
                        </p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="feature-card bg-white border border-slate-200 rounded-2xl p-6">
                        <div class="w-12 h-12 bg-navy/10 rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-navy" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-slate-800 mb-2">Laporan Harian Transparan</h3>
                        <p class="text-slate-500 text-sm leading-relaxed">
                            Kontraktor kirim laporan progres harian dengan foto before/after. Customer pantau perkembangan secara real-time.
                        </p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="feature-card bg-white border border-slate-200 rounded-2xl p-6">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-slate-800 mb-2">Manajemen Tim Pekerja</h3>
                        <p class="text-slate-500 text-sm leading-relaxed">
                            Kontraktor kelola data pekerja dan absensi harian per proyek. Rekam kehadiran dengan mudah langsung dari platform.
                        </p>
                    </div>

                    <!-- Feature 4 -->
                    <div class="feature-card bg-white border border-slate-200 rounded-2xl p-6">
                        <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-slate-800 mb-2">Log Pembayaran Digital</h3>
                        <p class="text-slate-500 text-sm leading-relaxed">
                            Catat setiap pembayaran dengan bukti kwitansi. Customer konfirmasi pembayaran langsung di platform.
                        </p>
                    </div>

                    <!-- Feature 5 -->
                    <div class="feature-card bg-white border border-slate-200 rounded-2xl p-6">
                        <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-slate-800 mb-2">Portfolio Proyek</h3>
                        <p class="text-slate-500 text-sm leading-relaxed">
                            Kontraktor bangun reputasi dengan portfolio foto before/after proyek yang sudah dikerjakan.
                        </p>
                    </div>

                    <!-- Feature 6 -->
                    <div class="feature-card bg-white border border-slate-200 rounded-2xl p-6">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-slate-800 mb-2">Verifikasi Identitas</h3>
                        <p class="text-slate-500 text-sm leading-relaxed">
                            Admin verifikasi identitas dan sertifikat kontraktor. Hanya kontraktor terverifikasi yang bisa menerima proyek.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- HOW IT WORKS -->
        <section class="py-20 bg-slate-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-14">
                    <h2 class="hero-title text-4xl lg:text-5xl text-slate-900 mb-4">Cara Kerja Mandorin</h2>
                </div>

                <div class="grid md:grid-cols-2 gap-12 items-start">
                    <!-- Customer flow -->
                    <div>
                        <div class="inline-flex items-center gap-2 bg-orange-100 text-orange-700 text-sm font-semibold px-3 py-1.5 rounded-full mb-6">
                            Untuk Pelanggan
                        </div>
                        <div class="space-y-4">
                            @foreach([
                                ['01', 'Daftar & Cari Kontraktor', 'Buat akun, lalu cari kontraktor yang sesuai kebutuhan dan lokasi Anda.'],
                                ['02', 'Ajukan Permintaan Proyek', 'Isi detail proyek: layanan yang dibutuhkan, alamat, dan deskripsi pekerjaan.'],
                                ['03', 'Pantau Progres Harian', 'Terima laporan foto harian dari kontraktor dan pantau persentase penyelesaian.'],
                                ['04', 'Konfirmasi Pembayaran', 'Konfirmasi setiap log pembayaran dengan mudah langsung dari platform.'],
                            ] as $step)
                                <div class="flex gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-orange-500 text-white flex-shrink-0 flex items-center justify-center font-bold text-sm">
                                        {{ $step[0] }}
                                    </div>
                                    <div>
                                        <div class="font-semibold text-slate-800">{{ $step[1] }}</div>
                                        <div class="text-slate-500 text-sm mt-1">{{ $step[2] }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Contractor flow -->
                    <div>
                        <div class="inline-flex items-center gap-2 bg-navy/10 text-navy text-sm font-semibold px-3 py-1.5 rounded-full mb-6">
                            Untuk Kontraktor
                        </div>
                        <div class="space-y-4">
                            @foreach([
                                ['01', 'Daftar & Verifikasi Identitas', 'Daftar sebagai kontraktor, upload dokumen identitas untuk diverifikasi admin.'],
                                ['02', 'Terima Permintaan Proyek', 'Review detail proyek dari pelanggan dan tentukan apakah akan diterima atau ditolak.'],
                                ['03', 'Kelola Tim & Absensi', 'Tambah pekerja ke proyek, catat absensi harian, dan kelola tim Anda.'],
                                ['04', 'Kirim Laporan Harian', 'Upload foto progres harian dengan catatan untuk transparansi kepada pelanggan.'],
                            ] as $step)
                                <div class="flex gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-navy text-white flex-shrink-0 flex items-center justify-center font-bold text-sm">
                                        {{ $step[0] }}
                                    </div>
                                    <div>
                                        <div class="font-semibold text-slate-800">{{ $step[1] }}</div>
                                        <div class="text-slate-500 text-sm mt-1">{{ $step[2] }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA SECTION -->
        <section class="hero-gradient grid-blueprint py-20">
            <div class="max-w-3xl mx-auto text-center px-4">
                <h2 class="hero-title text-4xl lg:text-5xl text-white mb-4">
                    Siap Mulai Proyek<br>Anda?
                </h2>
                <p class="text-white/70 text-lg mb-8">
                    Bergabung dengan ribuan pelanggan dan kontraktor yang sudah menggunakan Mandorin.
                </p>
                <div class="flex flex-wrap gap-3 justify-center">
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                           class="px-8 py-3 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-xl text-lg transition shadow-lg shadow-orange-500/30">
                            Daftar Sekarang — Gratis
                        </a>
                    @endif
                </div>
            </div>
        </section>

        <!-- FOOTER -->
        <footer class="bg-navy text-white/60 py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <div class="flex items-center justify-center gap-2 mb-3">
                    <svg class="w-5 h-5 text-orange-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 8.25h3m-3 3.75h3M6.75 15h.008v.008H6.75V15z"/>
                    </svg>
                    <span class="text-white font-bold text-lg">Mandorin</span>
                </div>
                <p class="text-sm">Platform Digital Penghubung Kontraktor & Customer</p>
                <p class="text-xs mt-2">&copy; {{ date('Y') }} Mandorin. Menyongsong Generasi Emas 2045.</p>
            </div>
        </footer>

    </body>
</html>
