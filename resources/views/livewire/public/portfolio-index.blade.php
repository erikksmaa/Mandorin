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

        <div class="bg-slate-50 min-h-screen py-8">
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
                    Menampilkan <span class="font-semibold text-slate-800">{{ $photos->total() }}</span> foto dokumentasi
                </p>

                @if ($photos->isEmpty())
                    <div class="bg-white border border-slate-200 rounded-xl">
                        <x-empty-state
                            icon="image"
                            title="Belum ada dokumentasi"
                            description="Belum ada foto dokumentasi kegiatan yang dapat ditampilkan."
                        />
                    </div>
                @else
                    {{-- Masonry Grid --}}
                    <div class="columns-1 sm:columns-2 lg:columns-3 xl:columns-4 gap-4 space-y-4">
                        @foreach ($photos as $photo)
                            @php
                                $program = $photo->activityLog?->program;
                                $orgName = $program?->organization?->name ?? 'Organisasi';
                            @endphp
                            <div class="break-inside-avoid relative group rounded-2xl overflow-hidden shadow-sm border border-slate-200 bg-white">
                                <img src="{{ asset('storage/' . $photo->photo) }}" alt="Dokumentasi {{ $program?->title }}" class="w-full h-auto object-cover transition duration-500 group-hover:scale-105">
                                
                                {{-- Overlay --}}
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-slate-900/20 to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex flex-col justify-end p-4">
                                    <span class="text-[10px] font-bold tracking-wider text-orange-400 uppercase mb-1">
                                        {{ $photo->photo_type instanceof \BackedEnum ? $photo->photo_type->value : $photo->photo_type }}
                                    </span>
                                    <h3 class="text-white font-semibold text-sm line-clamp-2 leading-tight mb-1">
                                        {{ $program?->title ?? 'Program Tidak Diketahui' }}
                                    </h3>
                                    <p class="text-white/70 text-xs truncate">
                                        {{ $orgName }}
                                    </p>
                                    @if($program)
                                    <a href="{{ route('public.programs.show', $program->id) }}" class="mt-3 inline-flex items-center justify-center w-full py-1.5 bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white text-xs font-semibold rounded-lg transition">
                                        Lihat Program
                                    </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    @if ($photos->hasPages())
                        <div class="mt-8">
                            {{ $photos->links('vendor.pagination.tailwind') }}
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </main>
</div>
