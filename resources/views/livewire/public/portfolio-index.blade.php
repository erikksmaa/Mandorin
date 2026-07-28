<x-slot:seo>
    <x-public.seo title="Galeri Dokumentasi Program — SIPORA"
        description="Lihat dokumentasi kegiatan dan program kepemudaan yang diselenggarakan di SIPORA." />
</x-slot:seo>

<div>
    <main>
        {{-- Page Header --}}
        <div class="bg-navy py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <nav class="flex items-center gap-2 text-white/50 text-xs mb-4" aria-label="Breadcrumb">
                    <a href="{{ route('home') }}" wire:navigate class="hover:text-white/80">Beranda</a>
                    <span aria-hidden="true">›</span>
                    <span class="text-white/80">Galeri</span>
                </nav>
                <h1 class="text-4xl font-black text-white mb-2"
                    style="font-family: 'Big Shoulders Display', sans-serif;">
                    Galeri Dokumentasi
                </h1>
                <p class="text-white/60 text-sm">Lihat hasil dan proses pelaksanaan program kepemudaan di SIPORA.</p>
            </div>
        </div>

        <div class="bg-slate-50 min-h-screen py-8" x-data="{ activeModal: null }">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                {{-- Filter Bar --}}
                <div
                    class="bg-white border border-slate-200 rounded-2xl p-4 mb-6 shadow-sm flex flex-col sm:flex-row gap-3">
                    {{-- Search --}}
                    <div class="relative flex-1">
                        <input wire:model.live.debounce.400ms="search" type="text"
                            placeholder="Cari berdasarkan nama program..."
                            class="w-full pl-9 pr-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:border-navy focus:ring-0 outline-none"
                            id="gallery-search" aria-label="Cari program">
                        <svg class="absolute left-2.5 top-3 w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>

                    {{-- Reset --}}
                    @if ($search)
                        <button wire:click="$set('search', '')"
                            class="px-4 py-2.5 text-sm text-slate-500 hover:text-slate-700 border border-slate-200 rounded-xl transition"
                            aria-label="Reset pencarian">
                            Reset
                        </button>
                    @endif
                </div>

                {{-- Count --}}
                <p class="text-sm text-slate-500 mb-5">
                    Menampilkan <span class="font-semibold text-slate-800">{{ $photos->total() }}</span> foto dokumentasi kegiatan selesai
                </p>

                @if ($photos->isEmpty())
                    <div class="bg-white border border-slate-200 rounded-xl">
                        <x-empty-state
                            icon="image"
                            title="Belum ada dokumentasi"
                            description="Belum ada foto dokumentasi dari program yang telah selesai."
                        />
                    </div>
                @else
                    {{-- Masonry Grid --}}
                    <div class="columns-1 sm:columns-2 lg:columns-3 xl:columns-4 gap-4 space-y-4">
                        @foreach ($photos as $photo)
                            @php
                                $program = $photo->activityLog?->program;
                                $orgName = $program?->organization?->name ?? 'Organisasi Pemuda';
                                $catName = $program?->category?->name ?? 'Umum';
                                $dateStr = $photo->activityLog?->activity_date ? $photo->activityLog->activity_date->format('d M Y') : $photo->created_at->format('d M Y');
                                $imgSrc  = asset('storage/' . $photo->photo);
                            @endphp
                            <div @click="activeModal = {{ $photo->id }}" class="break-inside-avoid relative group rounded-2xl overflow-hidden shadow-sm border border-slate-200 bg-white cursor-pointer">
                                <img src="{{ $imgSrc }}" alt="Dokumentasi {{ $program?->title }}" class="w-full h-auto object-cover transition duration-500 group-hover:scale-105">
                                
                                {{-- Card Footer Content --}}
                                <div class="p-3 bg-white border-t border-slate-100">
                                    <div class="flex items-center justify-between text-[11px] text-orange-500 font-semibold mb-1">
                                        <span>📂 {{ $catName }}</span>
                                        <span>📅 {{ $dateStr }}</span>
                                    </div>
                                    <h3 class="text-slate-800 font-bold text-sm line-clamp-1 group-hover:text-orange-500 transition">
                                        {{ $program?->title ?? 'Program Selesai' }}
                                    </h3>
                                    <p class="text-slate-500 text-xs truncate mt-0.5">
                                        🏢 {{ $orgName }}
                                    </p>
                                </div>

                                {{-- Hover Overlay Indicator --}}
                                <div class="absolute inset-0 bg-slate-900/40 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center pointer-events-none">
                                    <span class="px-3 py-1.5 bg-white/90 backdrop-blur-sm text-slate-800 text-xs font-bold rounded-xl shadow">
                                        🔍 Lihat Detail
                                    </span>
                                </div>
                            </div>

                            {{-- Lightbox Modal --}}
                            <div x-show="activeModal === {{ $photo->id }}" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/80 backdrop-blur-md" x-cloak>
                                <div @click.outside="activeModal = null" class="bg-white rounded-2xl max-w-2xl w-full overflow-hidden shadow-2xl">
                                    <div class="relative bg-black flex justify-center items-center max-h-[60vh]">
                                        <img src="{{ $imgSrc }}" alt="{{ $program?->title }}" class="max-h-[60vh] w-auto object-contain">
                                        <button @click="activeModal = null" class="absolute top-3 right-3 w-8 h-8 rounded-full bg-black/60 text-white flex items-center justify-center hover:bg-black transition">
                                            ✕
                                        </button>
                                    </div>
                                    <div class="p-6">
                                        <div class="flex items-center gap-2 mb-2">
                                            <span class="px-2.5 py-0.5 bg-orange-100 text-orange-700 rounded-full text-xs font-bold">
                                                {{ $catName }}
                                            </span>
                                            <span class="text-xs text-slate-400 font-mono">📅 {{ $dateStr }}</span>
                                        </div>
                                        <h3 class="text-xl font-bold text-slate-800 mb-1" style="font-family: 'Big Shoulders Display', sans-serif;">
                                            {{ $program?->title }}
                                        </h3>
                                        <p class="text-xs font-semibold text-slate-600 mb-3">
                                            🏢 {{ $orgName }}
                                        </p>
                                        @if($photo->caption)
                                            <p class="text-sm text-slate-600 bg-slate-50 p-3 rounded-xl mb-4 italic">
                                                "{{ $photo->caption }}"
                                            </p>
                                        @endif
                                        <div class="flex justify-between items-center pt-3 border-t border-slate-100">
                                            @if($program)
                                                <a href="{{ route('public.programs.show', $program->id) }}" class="px-4 py-2 bg-navy text-white hover:bg-slate-800 rounded-xl text-xs font-semibold transition">
                                                    Lihat Detail Program &rarr;
                                                </a>
                                            @endif
                                            <button @click="activeModal = null" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-semibold transition">
                                                Tutup
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    @if ($photos->hasPages())
                        <div class="mt-8">
                            {{ $photos->links() }}
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </main>
</div>
