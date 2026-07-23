<x-slot:seo>
    <x-public.seo title="Cari Kontraktor Terpercaya — Mandorin"
        description="Temukan mandor & kontraktor terverifikasi di seluruh Indonesia. Filter berdasarkan lokasi, layanan, dan rating di Mandorin." />
</x-slot:seo>

<div>
    <livewire:layout.navigation />

    <main>
        {{-- Page Header --}}
        <div class="bg-navy py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                {{-- Breadcrumb --}}
                <nav class="flex items-center gap-2 text-white/50 text-xs mb-4" aria-label="Breadcrumb">
                    <a href="{{ route('home') }}" wire:navigate class="hover:text-white/80">Beranda</a>
                    <span aria-hidden="true">›</span>
                    <span class="text-white/80">Kontraktor</span>
                </nav>
                <h1 class="text-4xl font-black text-white mb-2"
                    style="font-family: 'Big Shoulders Display', sans-serif;">
                    Cari Kontraktor
                </h1>
                <p class="text-white/60 text-sm">Temukan mandor & kontraktor terverifikasi yang tepat untuk proyek Anda.
                </p>
            </div>
        </div>

        <div class="bg-slate-50 min-h-screen">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="grid lg:grid-cols-4 gap-8">

                    {{-- SIDEBAR FILTER --}}
                    <aside class="lg:col-span-1">
                        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm sticky top-20">
                            <h2 class="font-bold text-slate-800 mb-4 text-sm">Filter</h2>

                            {{-- Search --}}
                            <div class="mb-4">
                                <label for="search-contractor"
                                    class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1.5">Nama
                                    Mandor</label>
                                <div class="relative">
                                    <input wire:model.live.debounce.400ms="search" id="search-contractor" type="text"
                                        placeholder="Cari nama mandor..."
                                        class="w-full pl-9 pr-3 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:border-navy focus:ring-0 outline-none"
                                        aria-label="Cari nama kontraktor">
                                    <svg class="absolute left-2.5 top-2.5 w-4 h-4 text-slate-400" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                            </div>

                            {{-- Lokasi --}}
                            <div class="mb-4">
                                <label for="filter-location"
                                    class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1.5">Lokasi</label>
                                <input wire:model.live.debounce.400ms="location" id="filter-location" type="text"
                                    placeholder="Kota / Kabupaten..."
                                    class="w-full px-3 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:border-navy focus:ring-0 outline-none"
                                    aria-label="Filter berdasarkan lokasi">
                            </div>

                            {{-- Layanan --}}
                            <div class="mb-4">
                                <label for="filter-service"
                                    class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1.5">Kategori
                                    Layanan</label>
                                <select wire:model.live="serviceId" id="filter-service"
                                    class="w-full px-3 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:border-navy focus:ring-0 outline-none"
                                    aria-label="Filter berdasarkan layanan">
                                    <option value="">Semua Layanan</option>
                                    @foreach ($services as $svc)
                                        <option value="{{ $svc->id }}">{{ $svc->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Rating --}}
                            <div class="mb-5">
                                <label
                                    class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2">Rating
                                    Minimum</label>
                                <div class="space-y-1.5">
                                    @foreach ([['', 'Semua Rating'], ['4', '4.0+ ⭐'], ['4.5', '4.5+ ⭐⭐'], ['5', '5.0 ⭐⭐⭐']] as [$val, $label])
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="radio" wire:model.live="minRating"
                                                value="{{ $val }}"
                                                class="w-3.5 h-3.5 text-navy border-slate-300 focus:ring-navy">
                                            <span class="text-sm text-slate-600">{{ $label }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            {{-- Reset --}}
                            @if ($search || $location || $serviceId || $minRating)
                                <button
                                    wire:click="$set('search', ''); $set('location', ''); $set('serviceId', null); $set('minRating', '')"
                                    class="w-full py-2 text-xs font-semibold text-slate-500 hover:text-slate-700 border border-slate-200 rounded-xl transition"
                                    aria-label="Reset semua filter">
                                    Reset Filter
                                </button>
                            @endif
                        </div>
                    </aside>

                    {{-- HASIL --}}
                    <div class="lg:col-span-3">
                        {{-- Count --}}
                        <div class="flex items-center justify-between mb-5">
                            <p class="text-sm text-slate-500">
                                Menampilkan <span
                                    class="font-semibold text-slate-800">{{ $contractors->total() }}</span> kontraktor
                                @if ($search)
                                    untuk "<span class="text-navy">{{ $search }}</span>"
                                @endif
                            </p>
                        </div>

                        @if ($contractors->isEmpty())
                            <div class="bg-white border border-slate-200 rounded-xl">
                                <x-empty-state
                                    icon="contractor"
                                    title="Tidak ada kontraktor ditemukan"
                                    description="Coba ubah kata kunci, lokasi, atau filter pencarian Anda."
                                    :action-wire-navigate="true"
                                />
                            </div>
                        @else
                            <div class="grid sm:grid-cols-2 xl:grid-cols-3 gap-5">
                                @foreach ($contractors as $contractor)
                                    <x-public.contractor-card :contractor="$contractor" />
                                @endforeach
                            </div>

                            {{-- Pagination --}}
                            @if ($contractors->hasPages())
                                <div class="mt-8">
                                    {{ $contractors->links('vendor.pagination.tailwind') }}
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>

    <x-public.footer />
</div>
