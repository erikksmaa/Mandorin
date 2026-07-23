<x-slot:seo>
    <x-public.seo title="Galeri Portfolio Kontraktor — Mandorin"
        description="Lihat portofolio sebelum & sesudah dari kontraktor terverifikasi di Mandorin. Temukan inspirasi dan mandor yang tepat untuk proyek Anda." />
</x-slot:seo>

<div>
    <livewire:layout.navigation />

    <main>
        {{-- Page Header --}}
        <div class="bg-navy py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <nav class="flex items-center gap-2 text-white/50 text-xs mb-4" aria-label="Breadcrumb">
                    <a href="{{ route('home') }}" wire:navigate class="hover:text-white/80">Beranda</a>
                    <span aria-hidden="true">›</span>
                    <span class="text-white/80">Portfolio</span>
                </nav>
                <h1 class="text-4xl font-black text-white mb-2"
                    style="font-family: 'Big Shoulders Display', sans-serif;">
                    Galeri Portfolio
                </h1>
                <p class="text-white/60 text-sm">Lihat hasil kerja nyata dari kontraktor terverifikasi Mandorin.</p>
            </div>
        </div>

        <div class="bg-slate-50 min-h-screen py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                {{-- Filter Bar --}}
                <div
                    class="bg-white border border-slate-200 rounded-2xl p-4 mb-6 shadow-sm flex flex-col sm:flex-row gap-3">
                    {{-- Search --}}
                    <div class="relative flex-1">
                        <input wire:model.live.debounce.400ms="search" type="text"
                            placeholder="Cari portfolio, nama mandor..."
                            class="w-full pl-9 pr-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:border-navy focus:ring-0 outline-none"
                            id="portfolio-search" aria-label="Cari portfolio">
                        <svg class="absolute left-2.5 top-3 w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>

                    {{-- Filter Layanan --}}
                    <select wire:model.live="serviceId"
                        class="px-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:border-navy focus:ring-0 outline-none min-w-[160px]"
                        id="portfolio-service-filter" aria-label="Filter berdasarkan layanan">
                        <option value="">Semua Kategori</option>
                        @foreach ($services as $svc)
                            <option value="{{ $svc->id }}">{{ $svc->name }}</option>
                        @endforeach
                    </select>

                    {{-- Reset --}}
                    @if ($search || $serviceId)
                        <button wire:click="$set('search', ''); $set('serviceId', null)"
                            class="px-4 py-2.5 text-sm text-slate-500 hover:text-slate-700 border border-slate-200 rounded-xl transition"
                            aria-label="Reset filter">
                            Reset
                        </button>
                    @endif
                </div>

                {{-- Count --}}
                <p class="text-sm text-slate-500 mb-5">
                    Menampilkan <span class="font-semibold text-slate-800">{{ $portfolios->total() }}</span> portfolio
                </p>

                @if ($portfolios->isEmpty())
                    <div class="bg-white border border-slate-200 rounded-xl">
                        <x-empty-state
                            icon="portfolio"
                            title="Belum ada portfolio tersedia"
                            description="Portfolio dari kontraktor terverifikasi akan muncul di sini."
                        />
                    </div>
                @else
                    {{-- Grid --}}
                    <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                        @foreach ($portfolios as $portfolio)
                            <x-public.portfolio-card :portfolio="$portfolio" />
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    @if ($portfolios->hasPages())
                        <div class="mt-8">
                            {{ $portfolios->links('vendor.pagination.tailwind') }}
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </main>

    <x-public.footer />
</div>
