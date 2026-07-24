@php
    /**
     * Query Organisasi Pilihan (Data Real)
     */
    $featuredOrganizations = \App\Models\Organization::with(['category', 'creator'])
        ->where('status', \App\Enums\OrganizationStatus::Active)
        ->latest()
        ->take(4)
        ->get();

    /**
     * Master Kategori Program
     */
    $allServices = \App\Models\ProgramCategory::orderBy('name')->get();

    /**
     * Query Program Pilihan (Terbaru)
     */
    $featuredPrograms = \App\Models\Program::with(['organization', 'category'])
        ->latest()
        ->take(4)
        ->get();
@endphp

<x-layouts.guest-public>

    {{-- ============================================================
     NAVBAR PUBLIK
     ============================================================ --}}
    <livewire:layout.navigation />


    {{-- ============================================================
     SECTION 1: HERO
     ============================================================ --}}
    <section class="relative bg-navy overflow-hidden min-h-[90vh] flex items-center">
        {{-- Background Blueprint Grid --}}
        <div class="absolute inset-0 pointer-events-none" aria-hidden="true">
            <div class="absolute inset-0"
                style="background-image: linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px); background-size: 36px 36px;">
            </div>
            {{-- Glow oranye --}}
            <div class="absolute -top-20 -right-20 w-96 h-96 bg-orange-500/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-1/4 w-80 h-80 bg-navy-400/20 rounded-full blur-3xl"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32 w-full">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                {{-- Left: Text & Search --}}
                <div>
                    {{-- Badge --}}
                    <div
                        class="inline-flex items-center gap-2 bg-orange-500/15 border border-orange-500/25 text-orange-300 text-xs font-semibold px-3 py-1.5 rounded-full mb-6">
                        <span class="w-1.5 h-1.5 rounded-full bg-orange-400 animate-pulse" aria-hidden="true"></span>
                        Platform Program Kepemudaan & Olahraga
                    </div>

                    <h1 class="text-5xl sm:text-6xl lg:text-7xl font-black text-white mb-6 leading-[1.05] tracking-tight"
                        style="font-family: 'Big Shoulders Display', sans-serif;">
                        Temukan<br>
                        <span class="text-orange-400">Organisasi</span><br>
                        Pemuda Terbaik
                    </h1>

                    <p class="text-white/70 text-lg leading-relaxed mb-10 max-w-md">
                        SIPORA menghubungkan Dindikpora dengan organisasi kepemudaan terverifikasi.
                        Pantau progres kegiatan, kelola e-lpj — semua dalam satu platform.
                    </p>

                    {{-- Search Bar (fungsional via form GET) --}}
                    <form action="{{ route('public.organizations.index') }}" method="GET"
                        class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-2 flex flex-col sm:flex-row gap-2 max-w-xl"
                        role="search">
                        {{-- Select Layanan (ID) --}}
                        <div class="flex items-center gap-2 flex-1 bg-white rounded-xl px-3 py-3">
                            <svg class="w-5 h-5 text-slate-400 shrink-0" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <select name="layanan" id="hero-search-service"
                                class="flex-1 text-sm text-slate-800 bg-transparent border-0 outline-none ring-0 focus:ring-0 focus:border-0 p-0 cursor-pointer">
                                <option value="">Semua Kategori</option>
                                @foreach ($allServices as $svc)
                                    <option value="{{ $svc->id }}">{{ $svc->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- Input Lokasi --}}
                        <div class="flex items-center gap-2 sm:w-40 bg-white rounded-xl px-3 py-3">
                            <svg class="w-5 h-5 text-slate-400 shrink-0" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <input type="text" name="lokasi" placeholder="Lokasi" aria-label="Lokasi"
                                class="flex-1 text-sm text-slate-800 placeholder-slate-400 bg-transparent border-0 outline-none ring-0 focus:ring-0 focus:border-0 p-0"
                                id="hero-search-location">
                        </div>
                        {{-- Search Button --}}
                        <button type="submit"
                            class="flex items-center justify-center gap-2 px-5 py-3 bg-orange-500 hover:bg-orange-600 text-white text-sm font-semibold rounded-xl transition shadow-lg shadow-orange-500/30 whitespace-nowrap"
                            aria-label="Cari organisasi">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            Cari Sekarang
                        </button>
                    </form>

                    {{-- Quick Tags --}}
                    <div class="flex flex-wrap gap-2 mt-4">
                        <span class="text-white/50 text-xs mt-1 self-center">Populer:</span>
                        @foreach ($allServices->take(4) as $svc)
                            <a href="{{ route('public.organizations.index') }}?layanan={{ $svc->id }}" wire:navigate
                                class="px-3 py-1 bg-white/10 hover:bg-white/20 text-white/80 hover:text-white text-xs rounded-full border border-white/15 transition">
                                {{ $svc->name }}
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- Right: Stats Cards --}}
                <div class="hidden lg:grid grid-cols-2 gap-4">
                    @foreach ([['value' => '500+', 'label' => 'Organisasi Terdaftar', 'icon' => 'users', 'color' => 'from-orange-500/20 to-orange-500/5'], ['value' => '1.2k+', 'label' => 'Program Selesai', 'icon' => 'check', 'color' => 'from-verified-500/20 to-verified-500/5'], ['value' => '98%', 'label' => 'Program Sukses', 'icon' => 'star', 'color' => 'from-amber-500/20 to-amber-500/5'], ['value' => '34', 'label' => 'Kecamatan Terjangkau', 'icon' => 'map', 'color' => 'from-navy-400/30 to-navy-400/5']] as $stat)
                        <div
                            class="bg-gradient-to-br {{ $stat['color'] }} border border-white/10 rounded-2xl p-5 backdrop-blur-sm">
                            <div class="text-3xl font-black text-white mb-1"
                                style="font-family: 'Big Shoulders Display', sans-serif;">
                                {{ $stat['value'] }}
                            </div>
                            <div class="text-white/60 text-sm">{{ $stat['label'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Wave Divider --}}
        <div class="absolute bottom-0 left-0 right-0 h-12 overflow-hidden" aria-hidden="true">
            <svg viewBox="0 0 1440 48" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full"
                preserveAspectRatio="none">
                <path
                    d="M0 24L60 28C120 32 240 40 360 42.7C480 45 600 43 720 38.7C840 35 960 29 1080 28C1200 27 1320 31 1380 33.3L1440 35.6V48H0V24Z"
                    fill="#f8fafc" />
            </svg>
        </div>
    </section>

    {{-- ============================================================
     SECTION 2: KATEGORI PROGRAM POPULER
     ============================================================ --}}
    <section class="bg-slate-50 py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl lg:text-5xl font-black text-slate-900 mb-3"
                    style="font-family: 'Big Shoulders Display', sans-serif;">
                    Kategori Program
                </h2>
                <p class="text-slate-500 text-base max-w-lg mx-auto">
                    Dari turnamen olahraga hingga pelatihan kepemudaan — temukan bidang program yang Anda butuhkan.
                </p>
            </div>

            {{-- Grid Kategori --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
                @foreach ($allServices as $svc)
                    <a href="{{ route('public.organizations.index') }}?layanan={{ $svc->id }}" wire:navigate
                        class="group bg-white border border-slate-200 shadow-sm rounded-2xl p-5 flex flex-col items-center gap-3 hover:-translate-y-1 hover:shadow-md transition-all duration-200 cursor-pointer">
                        <div
                            class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center group-hover:bg-orange-200 transition-colors">
                            <svg class="w-6 h-6 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-slate-700 text-center leading-tight">{{ $svc->name }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============================================================
     SECTION 3: ORGANISASI PILIHAN / TERVERIFIKASI
     ============================================================ --}}
    <section class="bg-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4 mb-12">
                <div>
                    <h2 class="text-4xl lg:text-5xl font-black text-slate-900 mb-2"
                        style="font-family: 'Big Shoulders Display', sans-serif;">
                        Organisasi Pilihan
                    </h2>
                    <p class="text-slate-500 text-base">
                        Terverifikasi legalitasnya, terbukti integritasnya.
                    </p>
                </div>
                <a href="{{ route('public.organizations.index') }}" wire:navigate
                    class="flex items-center gap-1.5 text-sm font-semibold text-orange-500 hover:text-orange-600 transition shrink-0">
                    Lihat Semua
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            @if ($featuredOrganizations->isEmpty())
                <div class="text-center py-12 text-slate-400">
                    <svg class="w-12 h-12 mx-auto mb-3 text-slate-300" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <p>Belum ada organisasi terdaftar.</p>
                </div>
            @else
                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach ($featuredOrganizations as $org)
                        <x-public.contractor-card :organization="$org" />
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    {{-- ============================================================
     SECTION 3.5: PROGRAM TERBARU
     ============================================================ --}}
    <section class="bg-slate-50 py-20 border-t border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4 mb-12">
                <div>
                    <h2 class="text-4xl lg:text-5xl font-black text-slate-900 mb-2"
                        style="font-family: 'Big Shoulders Display', sans-serif;">
                        Program Sukses
                    </h2>
                    <p class="text-slate-500 text-base">
                        Inspirasi dari program-program terbaru yang telah diselesaikan.
                    </p>
                </div>
                <a href="{{ route('public.programs.index') }}" wire:navigate
                    class="flex items-center gap-1.5 text-sm font-semibold text-orange-500 hover:text-orange-600 transition shrink-0">
                    Lihat Semua Program
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            @if ($featuredPrograms->isEmpty())
                <div class="text-center py-12 text-slate-400 bg-white border border-slate-200 rounded-2xl shadow-sm">
                    <svg class="w-12 h-12 mx-auto mb-3 text-slate-300" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p>Belum ada program yang diselesaikan.</p>
                </div>
            @else
                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach ($featuredPrograms as $program)
                        <x-public.portfolio-card :program="$program" />
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    {{-- ============================================================
     SECTION 4: CARA KERJA (How It Works)
     ============================================================ --}}
    <section id="cara-kerja" class="bg-slate-50 py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-14">
                <h2 class="text-4xl lg:text-5xl font-black text-slate-900 mb-3"
                    style="font-family: 'Big Shoulders Display', sans-serif;">
                    Alur Program SIPORA
                </h2>
                <p class="text-slate-500 text-base max-w-lg mx-auto">
                    Tiga langkah transparansi pelaksanaan program dari awal hingga pelaporan akhir.
                </p>
            </div>

            {{-- 3 Steps Horizontal --}}
            <div class="grid md:grid-cols-3 gap-8 relative">
                {{-- Connector line (desktop only) --}}
                <div class="hidden md:block absolute top-10 left-[calc(16.66%+1rem)] right-[calc(16.66%+1rem)] h-px bg-slate-200"
                    aria-hidden="true">
                    <div class="absolute inset-0 bg-gradient-to-r from-orange-200 via-orange-400 to-orange-200"></div>
                </div>

                @foreach ([['num' => '01', 'title' => 'Cari & Verifikasi', 'desc' => 'Dindikpora menemukan organisasi yang sesuai kebutuhan. Lihat dokumentasi program, rekam jejak, dan legalitas organisasi.', 'bg' => 'bg-orange-500', 'icon' => 'search'], ['num' => '02', 'title' => 'Ajukan Program', 'desc' => 'Ketua Pelaksana mengajukan proposal kegiatan. Verifikator Dindikpora mereview dan menyetujui program sebelum dimulai.', 'bg' => 'bg-navy', 'icon' => 'clipboard'], ['num' => '03', 'title' => 'Pantau Logbook & E-LPJ', 'desc' => 'Ketua mengupload laporan foto harian dan E-LPJ. Dindikpora memantau seluruh proses secara transparan.', 'bg' => 'bg-verified-600', 'icon' => 'chart']] as $step)
                    <div class="flex flex-col items-center text-center">
                        {{-- Circle Number --}}
                        <div
                            class="w-20 h-20 {{ $step['bg'] }} rounded-2xl flex items-center justify-center mb-6 shadow-lg relative z-10">
                            @if ($step['icon'] === 'search')
                                <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            @elseif($step['icon'] === 'clipboard')
                                <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                </svg>
                            @else
                                <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            @endif
                        </div>
                        <span class="text-xs font-bold text-slate-400 tracking-widest mb-2">LANGKAH
                            {{ $step['num'] }}</span>
                        <h3 class="text-xl font-bold text-slate-800 mb-3"
                            style="font-family: 'Big Shoulders Display', sans-serif;">
                            {{ $step['title'] }}
                        </h3>
                        <p class="text-slate-500 text-sm leading-relaxed max-w-xs">{{ $step['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============================================================
     SECTION 5: FITUR UNGGULAN (Feature Cards)
     ============================================================ --}}
    <section class="bg-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl lg:text-5xl font-black text-slate-900 mb-3"
                    style="font-family: 'Big Shoulders Display', sans-serif;">
                    Semua yang Anda Butuhkan
                </h2>
                <p class="text-slate-500 text-base max-w-xl mx-auto">
                    Dari pengajuan proposal hingga pelaporan akhir kegiatan — SIPORA mendigitalisasi seluruh program kepemudaan.
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach ([
        ['bg' => 'bg-orange-100', 'color' => 'text-orange-600', 'title' => 'Organisasi Terverifikasi', 'desc' => 'Hanya organisasi dengan legalitas & SKT terverifikasi yang dapat mengajukan program.'],
        ['bg' => 'bg-navy-100', 'color' => 'text-navy', 'title' => 'Laporan Foto Harian', 'desc' => 'Organisasi mengisi logbook progres dan dokumentasi rutin. Verifikator memantau real-time.'],
        ['bg' => 'bg-green-100', 'color' => 'text-green-700', 'title' => 'Manajemen Tim Anggota', 'desc' => 'Ketua mengelola data pengurus & presensi anggota per program dengan mudah.'],
        ['bg' => 'bg-amber-100', 'color' => 'text-amber-700', 'title' => 'E-LPJ Keuangan Terpadu', 'desc' => 'Catat seluruh item pengeluaran bertahap dengan bukti struk. Dindikpora konfirmasi langsung via platform.'],
        ['bg' => 'bg-purple-100', 'color' => 'text-purple-700', 'title' => 'Galeri Dokumentasi Program', 'desc' => 'Organisasi bangun kredibilitas dan transparansi publik lewat galeri kegiatan yang sudah diselesaikan.'],
        ['bg' => 'bg-blue-100', 'color' => 'text-blue-700', 'title' => 'Transparansi Dindikpora', 'desc' => 'Memastikan seluruh laporan tersentralisasi di Dindikpora secara rapi dan paperless.'],
    ] as $feat)
                    <div
                        class="group bg-white border border-slate-200 rounded-2xl p-6 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
                        <div class="w-12 h-12 {{ $feat['bg'] }} rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 {{ $feat['color'] }}" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-base font-bold text-slate-800 mb-2">{{ $feat['title'] }}</h3>
                        <p class="text-slate-500 text-sm leading-relaxed">{{ $feat['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============================================================
     SECTION 6: CTA GANDA
     ============================================================ --}}
    <section class="bg-navy py-20 relative overflow-hidden">
        {{-- Blueprint grid --}}
        <div class="absolute inset-0 pointer-events-none" aria-hidden="true"
            style="background-image: linear-gradient(rgba(255,255,255,0.025) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.025) 1px, transparent 1px); background-size: 36px 36px;">
        </div>
        <div class="absolute top-0 right-0 w-64 h-64 bg-orange-500/10 rounded-full blur-3xl pointer-events-none"
            aria-hidden="true"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl lg:text-5xl font-black text-white mb-3"
                    style="font-family: 'Big Shoulders Display', sans-serif;">
                    Siap Mengembangkan Kepemudaan?
                </h2>
                <p class="text-white/60 text-base">
                    Pilih peran Anda dan jadilah bagian dari transformasi digital kepemudaan SIPORA.
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-6 max-w-4xl mx-auto">
                {{-- Card Verifikator --}}
                <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-8 flex flex-col">
                    <div class="w-14 h-14 bg-orange-500/20 rounded-2xl flex items-center justify-center mb-5">
                        <svg class="w-7 h-7 text-orange-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-black text-white mb-2"
                        style="font-family: 'Big Shoulders Display', sans-serif;">
                        Dinas & Verifikator
                    </h3>
                    <p class="text-white/60 text-sm leading-relaxed mb-6 flex-1">
                        Temukan rekam jejak organisasi dan pantau progres program yang Anda danai secara real-time.
                    </p>
                    <a href="{{ route('register') }}" wire:navigate
                        class="block text-center py-3 px-6 bg-orange-500 hover:bg-orange-600 text-white font-bold rounded-xl transition shadow-lg shadow-orange-500/30">
                        Cari Organisasi Sekarang
                    </a>
                </div>

                {{-- Card Organisasi --}}
                <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-8 flex flex-col">
                    <div class="w-14 h-14 bg-white/10 rounded-2xl flex items-center justify-center mb-5">
                        <svg class="w-7 h-7 text-white/80" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-black text-white mb-2"
                        style="font-family: 'Big Shoulders Display', sans-serif;">
                        Organisasi Pemuda
                    </h3>
                    <p class="text-white/60 text-sm leading-relaxed mb-6 flex-1">
                        Daftarkan organisasi Anda, ajukan program inovatif, dan laporkan kegiatan Anda langsung dari SIPORA.
                    </p>
                    <a href="{{ route('register') }}" wire:navigate
                        class="block text-center py-3 px-6 bg-white/15 hover:bg-white/25 border border-white/30 text-white font-bold rounded-xl transition">
                        Daftar Sebagai Organisasi
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================================================
     SECTION 7: FOOTER
     ============================================================ --}}
    <x-public.footer />

</x-layouts.guest-public>
