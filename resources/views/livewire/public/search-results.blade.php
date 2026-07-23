<x-slot:seo>
    <x-public.seo title="Hasil Pencarian — Mandorin"
        description="Cari kontraktor terpercaya, mandor, dan portfolio inspiratif di seluruh Indonesia lewat Mandorin." />
</x-slot:seo>

<div>
    <livewire:layout.navigation />

    <main class="bg-slate-50 min-h-screen">
        {{-- Search Header --}}
        <div class="bg-navy py-12 lg:py-16 relative overflow-hidden">
            {{-- Background Blueprint Grid --}}
            <div class="absolute inset-0 pointer-events-none" aria-hidden="true">
                <div class="absolute inset-0"
                    style="background-image: linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px); background-size: 36px 36px;">
                </div>
            </div>

            <div class="relative max-w-3xl mx-auto px-4 sm:px-6 text-center">
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white mb-6"
                    style="font-family: 'Big Shoulders Display', sans-serif;">
                    Cari Kontraktor & Portfolio
                </h1>

                {{-- Big Search Bar --}}
                <div
                    class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-2 flex flex-col sm:flex-row gap-2 shadow-xl shadow-navy-900/50">
                    <div class="flex-1 flex items-center bg-white rounded-xl px-4 py-3 gap-3">
                        <svg class="w-5 h-5 text-slate-400 shrink-0" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input wire:model.live.debounce.400ms="query" type="text"
                            placeholder="Cari nama mandor, layanan, atau lokasi..."
                            class="w-full text-slate-800 bg-transparent border-none focus:ring-0 p-0 text-sm md:text-base outline-none placeholder-slate-400"
                            autofocus>
                    </div>
                </div>

                {{-- Filter Tabs --}}
                <div class="flex flex-wrap justify-center gap-2 mt-6">
                    <button wire:click="$set('type', 'all')"
                        class="px-4 py-1.5 rounded-full text-sm font-semibold transition-all border {{ $type === 'all' ? 'bg-orange-500 border-orange-500 text-white' : 'bg-white/10 border-white/20 text-white/80 hover:bg-white/20' }}">
                        Semua
                    </button>
                    <button wire:click="$set('type', 'contractors')"
                        class="px-4 py-1.5 rounded-full text-sm font-semibold transition-all border {{ $type === 'contractors' ? 'bg-orange-500 border-orange-500 text-white' : 'bg-white/10 border-white/20 text-white/80 hover:bg-white/20' }}">
                        Kontraktor
                    </button>
                    <button wire:click="$set('type', 'portfolios')"
                        class="px-4 py-1.5 rounded-full text-sm font-semibold transition-all border {{ $type === 'portfolios' ? 'bg-orange-500 border-orange-500 text-white' : 'bg-white/10 border-white/20 text-white/80 hover:bg-white/20' }}">
                        Portfolio
                    </button>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

            {{-- Jika query kosong --}}
            @if (empty(trim($query)))
                <div class="text-center py-16">
                    <div
                        class="w-16 h-16 bg-white border border-slate-200 rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm">
                        <svg class="w-8 h-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-1">Mulai Pencarian</h3>
                    <p class="text-slate-500 text-sm max-w-sm mx-auto">Ketikkan kata kunci di atas untuk mencari
                        kontraktor, layanan, lokasi, atau judul portfolio.</p>
                </div>
            @else
                {{-- Hasil Kontraktor --}}
                @if (in_array($type, ['all', 'contractors']))
                    <div class="mb-12">
                        <div class="flex items-end justify-between mb-6">
                            <div>
                                <h2 class="text-2xl font-black text-slate-900"
                                    style="font-family: 'Big Shoulders Display', sans-serif;">Kontraktor Terkait</h2>
                                <p class="text-sm text-slate-500 mt-1">Ditemukan {{ $contractors->count() }} kontraktor
                                    untuk "{{ $query }}"</p>
                            </div>
                            @if ($contractors->count() >= 8)
                                <a href="{{ route('public.contractors.index', ['q' => $query]) }}" wire:navigate
                                    class="text-sm font-bold text-orange-500 hover:text-orange-600 transition flex items-center gap-1">
                                    Lihat Semua
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            @endif
                        </div>

                        @if ($contractors->isEmpty())
                            <div
                                class="bg-white border border-slate-200 rounded-2xl p-8 text-center text-slate-500 text-sm">
                                Tidak ada kontraktor yang cocok dengan kata kunci ini.
                            </div>
                        @else
                            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
                                @foreach ($contractors as $contractor)
                                    <x-public.contractor-card :contractor="$contractor" />
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endif

                {{-- Divider --}}
                @if ($type === 'all' && $contractors->isNotEmpty() && $portfolios->isNotEmpty())
                    <div class="border-t border-slate-200 my-10 relative">
                        <div class="absolute inset-0 flex items-center justify-center -top-3">
                            <span
                                class="bg-slate-50 px-4 text-xs font-bold text-slate-400 tracking-widest uppercase">Dan</span>
                        </div>
                    </div>
                @endif

                {{-- Hasil Portfolio --}}
                @if (in_array($type, ['all', 'portfolios']))
                    <div>
                        <div class="flex items-end justify-between mb-6">
                            <div>
                                <h2 class="text-2xl font-black text-slate-900"
                                    style="font-family: 'Big Shoulders Display', sans-serif;">Portfolio Terkait</h2>
                                <p class="text-sm text-slate-500 mt-1">Ditemukan {{ $portfolios->count() }} portfolio
                                    untuk "{{ $query }}"</p>
                            </div>
                            @if ($portfolios->count() >= 9)
                                <a href="{{ route('public.portfolios.index', ['q' => $query]) }}" wire:navigate
                                    class="text-sm font-bold text-orange-500 hover:text-orange-600 transition flex items-center gap-1">
                                    Lihat Semua
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            @endif
                        </div>

                        @if ($portfolios->isEmpty())
                            <div
                                class="bg-white border border-slate-200 rounded-2xl p-8 text-center text-slate-500 text-sm">
                                Tidak ada portfolio yang cocok dengan kata kunci ini.
                            </div>
                        @else
                            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
                                @foreach ($portfolios as $portfolio)
                                    <x-public.portfolio-card :portfolio="$portfolio" />
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endif
            @endif

        </div>
    </main>

    <x-public.footer />
</div>
