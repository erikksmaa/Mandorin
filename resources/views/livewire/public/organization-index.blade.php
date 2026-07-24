<x-slot:seo>
    <x-public.seo title="Cari Organisasi Terpercaya — SIPORA"
        description="Temukan organisasi pemuda terverifikasi di seluruh wilayah di SIPORA." />
</x-slot:seo>

<div>
    <main>
        {{-- Page Header --}}
        <div class="bg-navy py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                {{-- Breadcrumb --}}
                <nav class="flex items-center gap-2 text-white/50 text-xs mb-4" aria-label="Breadcrumb">
                    <a href="{{ route('home') }}" wire:navigate class="hover:text-white/80">Beranda</a>
                    <span aria-hidden="true">›</span>
                    <span class="text-white/80">Organisasi</span>
                </nav>
                <h1 class="text-4xl font-black text-white mb-2"
                    style="font-family: 'Big Shoulders Display', sans-serif;">
                    Cari Organisasi
                </h1>
                <p class="text-white/60 text-sm">Temukan organisasi kepemudaan terverifikasi yang tepat untuk program Anda.
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
                                <label for="search-org"
                                    class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1.5">Nama / Deskripsi</label>
                                <div class="relative">
                                    <input wire:model.live.debounce.400ms="search" id="search-org" type="text"
                                        placeholder="Cari organisasi..."
                                        class="w-full pl-9 pr-3 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:border-navy focus:ring-0 outline-none"
                                        aria-label="Cari organisasi">
                                    <svg class="absolute left-2.5 top-2.5 w-4 h-4 text-slate-400" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                            </div>

                            {{-- Kategori --}}
                            <div class="mb-4">
                                <label for="filter-category"
                                    class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1.5">Kategori Organisasi</label>
                                <select wire:model.live="category" id="filter-category"
                                    class="w-full px-3 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:border-navy focus:ring-0 outline-none"
                                    aria-label="Filter berdasarkan kategori">
                                    <option value="">Semua Kategori</option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Reset --}}
                            @if ($search || $category)
                                <button
                                    wire:click="$set('search', ''); $set('category', '')"
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
                                    class="font-semibold text-slate-800">{{ $organizations->total() }}</span> organisasi
                                @if ($search)
                                    untuk "<span class="text-navy">{{ $search }}</span>"
                                @endif
                            </p>
                        </div>

                        @if ($organizations->isEmpty())
                            <div class="bg-white border border-slate-200 rounded-xl p-8 text-center text-sm text-slate-500">
                                tidak ada organisasi ditemukan.
                            </div>
                        @else
                            <div class="grid sm:grid-cols-2 xl:grid-cols-3 gap-5">
                                @foreach ($organizations as $organization)
                                    <x-public.contractor-card :organization="$organization" />
                                @endforeach
                            </div>

                            {{-- Pagination --}}
                            @if ($organizations->hasPages())
                                <div class="mt-8">
                                    {{ $organizations->links() }}
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
