@php
    /**
     * Query Kontraktor Pilihan (Data Real)
     */
    $featuredContractors = \App\Models\ContractorProfile::with(['user', 'services'])
        ->where('verification_status', 'verified')
        ->orderByDesc('rating')
        ->take(4)
        ->get();

    /**
     * Master Layanan
     */
    $allServices = \App\Models\Service::orderBy('name')->get();

    /**
     * Query Portfolio Pilihan (Terbaru)
     */
    $featuredPortfolios = \App\Models\Portfolio::with(['contractorProfile.user', 'contractorProfile.services'])
        ->whereHas('contractorProfile', fn($q) => $q->where('verification_status', 'verified'))
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
                        Platform Konstruksi Digital #1 Indonesia
                    </div>

                    <h1 class="text-5xl sm:text-6xl lg:text-7xl font-black text-white mb-6 leading-[1.05] tracking-tight"
                        style="font-family: 'Big Shoulders Display', sans-serif;">
                        Temukan<br>
                        <span class="text-orange-400">Kontraktor</span><br>
                        Terpercaya
                    </h1>

                    <p class="text-white/70 text-lg leading-relaxed mb-10 max-w-md">
                        Mandorin menghubungkan pemilik properti dengan mandor berpengalaman & terverifikasi.
                        Pantau progres harian, kelola pembayaran — semua dalam satu platform.
                    </p>

                    {{-- Search Bar (fungsional via form GET) --}}
                    <form action="{{ route('public.contractors.index') }}" method="GET"
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
                                <option value="">Semua Layanan</option>
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
                            aria-label="Cari kontraktor">
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
                            <a href="{{ route('public.contractors.index') }}?layanan={{ $svc->id }}" wire:navigate
                                class="px-3 py-1 bg-white/10 hover:bg-white/20 text-white/80 hover:text-white text-xs rounded-full border border-white/15 transition">
                                {{ $svc->name }}
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- Right: Stats Cards --}}
                <div class="hidden lg:grid grid-cols-2 gap-4">
                    @foreach ([['value' => '500+', 'label' => 'Kontraktor Terdaftar', 'icon' => 'users', 'color' => 'from-orange-500/20 to-orange-500/5'], ['value' => '1.2k+', 'label' => 'Proyek Selesai', 'icon' => 'check', 'color' => 'from-verified-500/20 to-verified-500/5'], ['value' => '98%', 'label' => 'Kepuasan Pelanggan', 'icon' => 'star', 'color' => 'from-amber-500/20 to-amber-500/5'], ['value' => '34', 'label' => 'Kab/Kota Terlayani', 'icon' => 'map', 'color' => 'from-navy-400/30 to-navy-400/5']] as $stat)
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
     SECTION 2: KATEGORI LAYANAN POPULER
     ============================================================ --}}
    <section class="bg-slate-50 py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl lg:text-5xl font-black text-slate-900 mb-3"
                    style="font-family: 'Big Shoulders Display', sans-serif;">
                    Layanan Populer
                </h2>
                <p class="text-slate-500 text-base max-w-lg mx-auto">
                    Dari renovasi hingga instalasi — temukan keahlian yang Anda butuhkan.
                </p>
            </div>

            {{-- Grid Kategori --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
                @foreach ($allServices as $svc)
                    <a href="{{ route('public.contractors.index') }}?layanan={{ $svc->id }}" wire:navigate
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
     SECTION 3: KONTRAKTOR PILIHAN / TERVERIFIKASI
     Data disambungkan ke ContractorProfile real (query di atas)
     ============================================================ --}}
    <section class="bg-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4 mb-12">
                <div>
                    <h2 class="text-4xl lg:text-5xl font-black text-slate-900 mb-2"
                        style="font-family: 'Big Shoulders Display', sans-serif;">
                        Kontraktor Pilihan
                    </h2>
                    <p class="text-slate-500 text-base">
                        Terverifikasi identitasnya, terbukti prestasinya.
                    </p>
                </div>
                <a href="{{ route('public.contractors.index') }}" wire:navigate
                    class="flex items-center gap-1.5 text-sm font-semibold text-orange-500 hover:text-orange-600 transition shrink-0">
                    Lihat Semua
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            @if ($featuredContractors->isEmpty())
                <div class="text-center py-12 text-slate-400">
                    <svg class="w-12 h-12 mx-auto mb-3 text-slate-300" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <p>Belum ada kontraktor terverifikasi.</p>
                </div>
            @else
                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach ($featuredContractors as $cp)
                        <div
                            class="bg-white border border-slate-200 shadow-sm rounded-2xl p-5 flex flex-col hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
                            {{-- Avatar --}}
                            <div class="flex items-start justify-between mb-4">
                                <div
                                    class="w-14 h-14 rounded-2xl overflow-hidden bg-slate-100 shrink-0 border border-slate-200">
                                    @if ($cp->profile_photo)
                                        <img src="{{ asset('storage/' . $cp->profile_photo) }}"
                                            alt="Foto profil {{ $cp->user->name }}"
                                            class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-navy text-white font-bold text-xl"
                                            aria-label="Inisial {{ $cp->user->name }}">
                                            {{ strtoupper(substr($cp->user->name ?? '?', 0, 1)) }}
                                        </div>
                                    @endif
                                </div>
                                {{-- Badge Terverifikasi --}}
                                <span
                                    class="px-2.5 py-1 rounded-full text-xs font-semibold bg-verified-100 text-verified-700 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Terverifikasi
                                </span>
                            </div>

                            {{-- Info --}}
                            <h3 class="font-bold text-slate-800 mb-1 truncate">{{ $cp->user->name }}</h3>

                            {{-- Rating --}}
                            <div class="flex items-center gap-1.5 mb-3">
                                <div class="flex text-amber-400">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <svg class="w-3.5 h-3.5 {{ $i <= round($cp->rating ?? 0) ? 'text-amber-400' : 'text-slate-200' }}"
                                            fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @endfor
                                </div>
                                <span
                                    class="text-xs font-semibold text-slate-700">{{ number_format($cp->rating ?? 0, 1) }}</span>
                                <span class="text-xs text-slate-400">({{ $cp->total_reviews ?? 0 }} ulasan)</span>
                            </div>

                            {{-- Lokasi --}}
                            @if ($cp->address)
                                <div class="flex items-start gap-1 text-xs text-slate-500 mb-3">
                                    <svg class="w-3.5 h-3.5 shrink-0 mt-0.5 text-slate-400" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span class="truncate">{{ $cp->address }}</span>
                                </div>
                            @endif

                            {{-- Badge Layanan --}}
                            @if ($cp->services->isNotEmpty())
                                <div class="flex flex-wrap gap-1 mb-4">
                                    @foreach ($cp->services->take(3) as $svc)
                                        <span
                                            class="px-2 py-0.5 bg-slate-100 text-slate-600 text-[10px] font-medium rounded-full">
                                            {{ $svc->name }}
                                        </span>
                                    @endforeach
                                    @if ($cp->services->count() > 3)
                                        <span class="px-2 py-0.5 bg-slate-100 text-slate-400 text-[10px] rounded-full">
                                            +{{ $cp->services->count() - 3 }} lainnya
                                        </span>
                                    @endif
                                </div>
                            @else
                                <div class="mb-4"></div>
                            @endif

                            {{-- CTA --}}
                            <div class="mt-auto">
                                <a href="{{ route('public.contractors.show', $cp) }}" wire:navigate
                                    class="block w-full text-center py-2 px-4 bg-navy hover:bg-navy-700 text-white text-sm font-semibold rounded-xl transition">
                                    Lihat Profil
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    {{-- ============================================================
     SECTION 3.5: PORTFOLIO TERBARU
     ============================================================ --}}
    <section class="bg-slate-50 py-20 border-t border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4 mb-12">
                <div>
                    <h2 class="text-4xl lg:text-5xl font-black text-slate-900 mb-2"
                        style="font-family: 'Big Shoulders Display', sans-serif;">
                        Hasil Kerja Nyata
                    </h2>
                    <p class="text-slate-500 text-base">
                        Inspirasi dari proyek-proyek terbaru yang telah diselesaikan.
                    </p>
                </div>
                <a href="{{ route('public.portfolios.index') }}" wire:navigate
                    class="flex items-center gap-1.5 text-sm font-semibold text-orange-500 hover:text-orange-600 transition shrink-0">
                    Lihat Semua Portfolio
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            @if ($featuredPortfolios->isEmpty())
                <div class="text-center py-12 text-slate-400 bg-white border border-slate-200 rounded-2xl shadow-sm">
                    <svg class="w-12 h-12 mx-auto mb-3 text-slate-300" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p>Belum ada portfolio yang dibagikan.</p>
                </div>
            @else
                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach ($featuredPortfolios as $portfolio)
                        <x-public.portfolio-card :portfolio="$portfolio" />
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
                    Cara Kerja Mandorin
                </h2>
                <p class="text-slate-500 text-base max-w-lg mx-auto">
                    Tiga langkah mudah untuk memulai proyek konstruksi impian Anda.
                </p>
            </div>

            {{-- 3 Steps Horizontal --}}
            <div class="grid md:grid-cols-3 gap-8 relative">
                {{-- Connector line (desktop only) --}}
                <div class="hidden md:block absolute top-10 left-[calc(16.66%+1rem)] right-[calc(16.66%+1rem)] h-px bg-slate-200"
                    aria-hidden="true">
                    <div class="absolute inset-0 bg-gradient-to-r from-orange-200 via-orange-400 to-orange-200"></div>
                </div>

                @foreach ([['num' => '01', 'title' => 'Cari & Bandingkan', 'desc' => 'Temukan kontraktor sesuai kebutuhan & lokasi. Lihat portofolio, rating, dan layanan yang ditawarkan.', 'bg' => 'bg-orange-500', 'icon' => 'search'], ['num' => '02', 'title' => 'Ajukan Proyek', 'desc' => 'Kirim detail kebutuhan Anda. Kontraktor akan merespons dan menyetujui pesanan sebelum memulai.', 'bg' => 'bg-navy', 'icon' => 'clipboard'], ['num' => '03', 'title' => 'Pantau Progres', 'desc' => 'Terima laporan harian dengan foto. Konfirmasi pembayaran dan pantau kemajuan secara transparan.', 'bg' => 'bg-verified-600', 'icon' => 'chart']] as $step)
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
                    Dari pencarian hingga pelaporan harian — Mandorin digitalisasi seluruh proses konstruksi Anda.
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach ([
        ['bg' => 'bg-orange-100', 'color' => 'text-orange-600', 'title' => 'Kontraktor Terverifikasi', 'desc' => 'Hanya kontraktor dengan dokumen identitas terverifikasi admin yang dapat menerima proyek.'],
        ['bg' => 'bg-navy-100', 'color' => 'text-navy', 'title' => 'Laporan Foto Harian', 'desc' => 'Kontraktor kirim laporan progres + foto before/after setiap hari. Customer pantau real-time.'],
        ['bg' => 'bg-green-100', 'color' => 'text-green-700', 'title' => 'Manajemen Tim Pekerja', 'desc' => 'Kontraktor kelola data pekerja & absensi harian per proyek dengan mudah.'],
        ['bg' => 'bg-amber-100', 'color' => 'text-amber-700', 'title' => 'Log Pembayaran Termin', 'desc' => 'Catat setiap pembayaran bertahap dengan bukti. Customer konfirmasi langsung di platform.'],
        ['bg' => 'bg-purple-100', 'color' => 'text-purple-700', 'title' => 'Portofolio Proyek', 'desc' => 'Kontraktor bangun reputasi lewat foto before/after proyek yang sudah diselesaikan.'],
        ['bg' => 'bg-blue-100', 'color' => 'text-blue-700', 'title' => 'Chat via WhatsApp', 'desc' => 'Hubungi mandor langsung via WhatsApp dengan pesan berisi detail proyek yang otomatis terformat.'],
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
                    Siap Bergabung?
                </h2>
                <p class="text-white/60 text-base">
                    Pilih peran Anda dan mulai pengalaman konstruksi digital bersama Mandorin.
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-6 max-w-4xl mx-auto">
                {{-- Card Customer --}}
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
                        Butuh Jasa Konstruksi?
                    </h3>
                    <p class="text-white/60 text-sm leading-relaxed mb-6 flex-1">
                        Temukan dan pesan kontraktor terpercaya. Pantau progres proyek Anda kapan saja, di mana saja.
                    </p>
                    <a href="{{ route('register') }}" wire:navigate
                        class="block text-center py-3 px-6 bg-orange-500 hover:bg-orange-600 text-white font-bold rounded-xl transition shadow-lg shadow-orange-500/30">
                        Cari Kontraktor Sekarang
                    </a>
                </div>

                {{-- Card Kontraktor --}}
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
                        Punya Keahlian Konstruksi?
                    </h3>
                    <p class="text-white/60 text-sm leading-relaxed mb-6 flex-1">
                        Daftarkan diri sebagai mandor/kontraktor. Dapatkan proyek, bangun reputasi, dan kelola tim
                        dengan mudah.
                    </p>
                    <a href="{{ route('register') }}" wire:navigate
                        class="block text-center py-3 px-6 bg-white/15 hover:bg-white/25 border border-white/30 text-white font-bold rounded-xl transition">
                        Daftar Jadi Mandor
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
