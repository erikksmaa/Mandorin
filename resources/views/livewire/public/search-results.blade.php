<x-slot:seo>
    <x-public.seo title="Hasil Pencarian — SIPORA"
        description="Cari organisasi kepemudaan dan program terintegrasi di SIPORA." />
</x-slot:seo>

<div>
    <main class="bg-slate-50 min-h-screen">
        {{-- Search Header --}}
        <div class="bg-navy py-12 lg:py-16 relative overflow-hidden">
            <div class="relative max-w-3xl mx-auto px-4 sm:px-6 text-center">
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white mb-6"
                    style="font-family: 'Big Shoulders Display', sans-serif;">
                    Cari Organisasi & Program
                </h1>

                {{-- Big Search Bar --}}
                <div
                    class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-2 flex flex-col sm:flex-row gap-2 shadow-xl">
                    <div class="flex-1 flex items-center bg-white rounded-xl px-4 py-3 gap-3">
                        <svg class="w-5 h-5 text-slate-400 shrink-0" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input wire:model.live.debounce.400ms="query" type="text"
                            placeholder="Cari organisasi, program, atau kata kunci..."
                            class="w-full text-slate-800 bg-transparent border-none focus:ring-0 p-0 text-sm md:text-base outline-none placeholder-slate-400"
                            autofocus>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

            {{-- Jika query kosong --}}
            @if (empty(trim($query)))
                <div class="text-center py-16">
                    <div class="w-16 h-16 bg-white border border-slate-200 rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm">
                        <svg class="w-8 h-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 mb-1">Mulai Pencarian</h3>
                    <p class="text-slate-500 text-sm max-w-sm mx-auto">Ketikkan kata kunci di atas untuk mencari organisasi atau program kepemudaan.</p>
                </div>
            @else
                {{-- Hasil Organisasi --}}
                <div class="mb-12">
                    <div class="flex items-end justify-between mb-6">
                        <div>
                            <h2 class="text-2xl font-black text-slate-900"
                                style="font-family: 'Big Shoulders Display', sans-serif;">Organisasi Terkait</h2>
                            <p class="text-sm text-slate-500 mt-1">Ditemukan {{ $organizations->count() }} organisasi untuk "{{ $query }}"</p>
                        </div>
                    </div>

                    @if ($organizations->isEmpty())
                        <div class="bg-white border border-slate-200 rounded-2xl p-8 text-center text-slate-500 text-sm">
                            Tidak ada organisasi yang cocok dengan kata kunci ini.
                        </div>
                    @else
                        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
                            @foreach ($organizations as $organization)
                                <x-public.contractor-card :organization="$organization" />
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Hasil Program --}}
                <div>
                    <div class="flex items-end justify-between mb-6">
                        <div>
                            <h2 class="text-2xl font-black text-slate-900"
                                style="font-family: 'Big Shoulders Display', sans-serif;">Program Terkait</h2>
                            <p class="text-sm text-slate-500 mt-1">Ditemukan {{ $programs->count() }} program untuk "{{ $query }}"</p>
                        </div>
                    </div>

                    @if ($programs->isEmpty())
                        <div class="bg-white border border-slate-200 rounded-2xl p-8 text-center text-slate-500 text-sm">
                            Tidak ada program yang cocok dengan kata kunci ini.
                        </div>
                    @else
                        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
                            @foreach ($programs as $program)
                                <x-public.portfolio-card :program="$program" />
                            @endforeach
                        </div>
                    @endif
                </div>
            @endif

        </div>
    </main>

</div>
