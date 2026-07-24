<x-slot:seo>
    <x-public.seo
        :title="$program->title . ' — Program Kepemudaan | SIPORA'"
        :description="Str::limit($program->description, 150)"
    />
</x-slot:seo>

<div x-data="{ selectedPhoto: null }">
    <main>
        {{-- Breadcrumb --}}
        <div class="bg-slate-50 border-b border-slate-200 py-3">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <nav class="flex items-center gap-2 text-sm text-slate-500" aria-label="Breadcrumb">
                    <a href="{{ route('home') }}" wire:navigate class="hover:text-navy transition">Beranda</a>
                    <span aria-hidden="true">›</span>
                    <a href="{{ route('public.programs.index') }}" wire:navigate class="hover:text-navy transition">Program</a>
                    <span aria-hidden="true">›</span>
                    <span class="text-slate-800 font-medium truncate">{{ $program->title }}</span>
                </nav>
            </div>
        </div>

        <div class="bg-slate-50 min-h-screen py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-3 gap-8">

                    {{-- LEFT/MAIN: Program Detail --}}
                    <div class="lg:col-span-2 space-y-6">

                        {{-- Header Card --}}
                        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                            <div class="flex items-center justify-between gap-3 mb-2">
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-mono text-slate-400">{{ $program->program_code }}</span>
                                    <span class="px-2.5 py-0.5 bg-navy/10 text-navy text-xs font-bold rounded-full">
                                        {{ $program->category?->name ?? 'Program' }}
                                    </span>
                                </div>
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">
                                    Progress {{ $program->progress }}%
                                </span>
                            </div>
                            <h1 class="text-2xl font-bold text-slate-800 mb-4">{{ $program->title }}</h1>

                            <div class="w-full bg-slate-100 rounded-full h-2.5 mb-4">
                                <div class="bg-navy h-2.5 rounded-full transition-all duration-500" style="width: {{ $program->progress }}%"></div>
                            </div>

                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 py-4 border-t border-slate-100 text-xs text-slate-600">
                                <div>
                                    <span class="text-slate-400 block">Status:</span>
                                    <span class="font-bold text-slate-800">{{ $program->status?->label() ?? $program->status }}</span>
                                </div>
                                <div>
                                    <span class="text-slate-400 block">Lokasi:</span>
                                    <span class="font-semibold text-slate-800">{{ $program->location ?? '-' }}</span>
                                </div>
                                <div>
                                    <span class="text-slate-400 block">Tanggal Mulai:</span>
                                    <span class="font-medium">{{ $program->start_date?->format('d M Y') ?? '-' }}</span>
                                </div>
                                <div>
                                    <span class="text-slate-400 block">Tanggal Selesai:</span>
                                    <span class="font-medium">{{ $program->end_date?->format('d M Y') ?? '-' }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- Deskripsi & Tujuan --}}
                        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm space-y-4">
                            <div>
                                <h2 class="font-bold text-slate-800 text-base mb-2">Deskripsi Program</h2>
                                <p class="text-slate-600 text-sm whitespace-pre-line leading-relaxed">{{ $program->description }}</p>
                            </div>

                            @if($program->objective)
                                <div class="pt-4 border-t border-slate-100">
                                    <h3 class="font-bold text-slate-800 text-sm mb-1">Tujuan Program</h3>
                                    <p class="text-slate-600 text-sm whitespace-pre-line leading-relaxed">{{ $program->objective }}</p>
                                </div>
                            @endif

                            @if($program->target)
                                <div class="pt-4 border-t border-slate-100">
                                    <h3 class="font-bold text-slate-800 text-sm mb-1">Sasaran & Target Peserta</h3>
                                    <p class="text-slate-600 text-sm">{{ $program->target }}</p>
                                </div>
                            @endif
                        </div>

                        {{-- Ringkasan Hasil Program --}}
                        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm space-y-3">
                            <h2 class="font-bold text-slate-800 text-base border-b border-slate-100 pb-2">Ringkasan Hasil Program</h2>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 text-xs">
                                <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                                    <span class="text-slate-400 block mb-0.5">Total Kegiatan</span>
                                    <span class="text-lg font-bold text-navy">{{ $program->activityLogs ? $program->activityLogs->count() : 0 }} Logbook</span>
                                </div>
                                <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                                    <span class="text-slate-400 block mb-0.5">Status LPJ</span>
                                    <span class="text-sm font-bold text-green-700">{{ $program->financialReport?->status ?? 'Terverifikasi' }}</span>
                                </div>
                                <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                                    <span class="text-slate-400 block mb-0.5">Cakupan Tim</span>
                                    <span class="text-lg font-bold text-navy">{{ $program->members ? $program->members->count() : 0 }} Pengurus</span>
                                </div>
                            </div>
                        </div>

                        {{-- Galeri Dokumentasi Foto --}}
                        @php
                            $allPhotos = \App\Models\ActivityPhoto::whereHas('activityLog', fn($q) => $q->where('program_id', $program->id))->get();
                        @endphp
                        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                            <h2 class="font-bold text-slate-800 text-base mb-4 border-b border-slate-100 pb-2">Galeri Dokumentasi Program</h2>
                            @if($allPhotos->isNotEmpty())
                                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                    @foreach($allPhotos as $photo)
                                        <div @click="selectedPhoto = '{{ asset('storage/' . $photo->photo) }}'" class="group relative aspect-video rounded-xl overflow-hidden border border-slate-200 cursor-pointer bg-slate-100">
                                            <img src="{{ asset('storage/' . $photo->photo) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center text-white text-xs font-semibold">
                                                🔍 Perbesar
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-slate-400 text-xs text-center py-6">Belum ada foto dokumentasi terlampir.</p>
                            @endif
                        </div>

                        {{-- Timeline Logbook Kegiatan --}}
                        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                            <h2 class="font-bold text-slate-800 text-base mb-4 border-b border-slate-100 pb-2">Timeline Pelaksanaan Kegiatan</h2>
                            @if($program->activityLogs && $program->activityLogs->isNotEmpty())
                                <div class="relative pl-6 border-l-2 border-slate-200 space-y-6">
                                    @foreach($program->activityLogs as $log)
                                        <div class="relative">
                                            <div class="absolute -left-[31px] top-0 w-4 h-4 rounded-full bg-navy border-2 border-white"></div>
                                            <div class="flex justify-between items-start mb-1">
                                                <h3 class="font-bold text-slate-800 text-sm">{{ $log->title }}</h3>
                                                <span class="text-xs text-slate-400 font-mono">{{ $log->activity_date ? $log->activity_date->format('d M Y') : '-' }}</span>
                                            </div>
                                            <p class="text-xs text-slate-600 whitespace-pre-line leading-relaxed mb-2">{{ $log->description }}</p>
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-navy/10 text-navy">
                                                Progress: {{ $log->progress_percentage }}%
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-slate-400 text-xs">Belum ada catatan logbook kegiatan publik.</p>
                            @endif
                        </div>

                    </div>

                    {{-- RIGHT SIDEBAR: Organisasi & Ketua --}}
                    <aside class="lg:col-span-1 space-y-6">

                        {{-- Card Organisasi --}}
                        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Pelaksana Program</h3>
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-12 h-12 rounded-xl bg-navy text-white flex items-center justify-center font-bold text-lg shrink-0">
                                    {{ strtoupper(substr($program->organization?->name ?? 'O', 0, 1)) }}
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-800 text-sm">{{ $program->organization?->name ?? 'Organisasi' }}</h4>
                                    <p class="text-xs text-slate-500">{{ $program->organization?->category?->name ?? '-' }}</p>
                                </div>
                            </div>
                            @if($program->organization)
                                <a href="{{ route('public.organizations.show', $program->organization) }}" wire:navigate class="block w-full text-center py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition">
                                    Lihat Profil Organisasi
                                </a>
                            @endif
                        </div>

                        {{-- Card Ketua Pelaksana --}}
                        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Ketua Pelaksana</h3>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-orange-500 text-white flex items-center justify-center font-bold text-sm shrink-0">
                                    {{ strtoupper(substr($program->leader?->name ?? 'K', 0, 1)) }}
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-800 text-sm">{{ $program->leader?->name ?? '-' }}</h4>
                                    <p class="text-xs text-slate-500">{{ $program->leader?->email ?? '-' }}</p>
                                </div>
                            </div>
                        </div>

                    </aside>

                </div>
            </div>
        </div>
    </main>

    <!-- Modal Lightbox Preview -->
    <div x-show="selectedPhoto" 
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @keydown.escape.window="selectedPhoto = null"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 p-4 backdrop-blur-sm"
        style="display: none;">
        
        <div class="relative max-w-4xl max-h-[90vh] w-full flex flex-col items-center">
            <button @click="selectedPhoto = null" class="absolute -top-10 right-0 text-white hover:text-slate-300 font-bold text-xl">
                ✕ Tutup
            </button>
            <img :src="selectedPhoto" class="max-w-full max-h-[85vh] rounded-2xl object-contain shadow-2xl">
        </div>
    </div>
</div>
