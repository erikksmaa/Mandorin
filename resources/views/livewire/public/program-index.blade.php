<x-slot:seo>
    <x-public.seo title="Daftar Program Kepemudaan — SIPORA"
        description="Jelajahi program-program kepemudaan dan olahraga Kabupaten Pemalang di SIPORA." />
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
                    <span class="text-white/80">Program</span>
                </nav>
                <h1 class="text-4xl font-black text-white mb-2"
                    style="font-family: 'Big Shoulders Display', sans-serif;">
                    Daftar Program Kepemudaan
                </h1>
                <p class="text-white/60 text-sm">Temukan dan pantau pelaksanaan program kepemudaan dan olahraga.
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
                                <label for="search-prog"
                                    class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1.5">Judul Program</label>
                                <div class="relative">
                                    <input wire:model.live.debounce.400ms="search" id="search-prog" type="text"
                                        placeholder="Cari program..."
                                        class="w-full pl-9 pr-3 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:border-navy focus:ring-0 outline-none">
                                    <svg class="absolute left-2.5 top-2.5 w-4 h-4 text-slate-400" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                            </div>

                            {{-- Kategori --}}
                            <div class="mb-4">
                                <label for="filter-prog-category"
                                    class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1.5">Kategori Program</label>
                                <select wire:model.live="category" id="filter-prog-category"
                                    class="w-full px-3 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:border-navy focus:ring-0 outline-none">
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
                                    class="w-full py-2 text-xs font-semibold text-slate-500 hover:text-slate-700 border border-slate-200 rounded-xl transition">
                                    Reset Filter
                                </button>
                            @endif
                        </div>
                    </aside>

                    {{-- HASIL --}}
                    <div class="lg:col-span-3">
                        <div class="flex items-center justify-between mb-5">
                            <p class="text-sm text-slate-500">
                                Menampilkan <span class="font-semibold text-slate-800">{{ $programs->total() }}</span> program
                                @if ($search)
                                    untuk "<span class="text-navy">{{ $search }}</span>"
                                @endif
                            </p>
                        </div>

                        @if ($programs->isEmpty())
                            <div class="bg-white border border-slate-200 rounded-xl p-8 text-center text-sm text-slate-500">
                                Tidak ada program ditemukan.
                            </div>
                        @else
                            <div class="grid sm:grid-cols-2 xl:grid-cols-3 gap-5">
                                @foreach ($programs as $program)
                                    <x-public.portfolio-card :program="$program" />
                                @endforeach
                            </div>

                            {{-- Pagination --}}
                            @if ($programs->hasPages())
                                <div class="mt-8">
                                    {{ $programs->links() }}
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
