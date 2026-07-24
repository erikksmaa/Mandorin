<div x-data="{ selectedPhoto: null }">
    @php
        $isVerifier = auth()->user()?->role?->slug === 'verifier' || auth()->user()?->role?->slug === 'verifikator';
        $backRoute = $isVerifier ? route('verifier.logbook.index') : route('leader.programs.show', $activityLog->program_id);
    @endphp
    <div class="mb-4 flex items-center justify-between">
        <a href="{{ $backRoute }}" class="text-sm font-medium text-slate-500 hover:text-slate-800 inline-flex items-center gap-1">
            &larr; {{ $isVerifier ? 'Kembali ke Monitoring Logbook' : 'Kembali ke Detail Program' }}
        </a>
        <span class="px-3 py-1 rounded-full text-xs font-semibold 
            {{ match($activityLog->status?->value ?? $activityLog->status) {
                'Approved' => 'bg-green-100 text-green-700',
                'Submitted' => 'bg-blue-100 text-blue-700',
                'Revised' => 'bg-amber-100 text-amber-700',
                default => 'bg-slate-100 text-slate-700'
            } }}">
            Status: {{ $activityLog->status?->label() ?? $activityLog->status }}
        </span>
    </div>

    <!-- Header Card -->
    <div class="bg-white border border-slate-200 shadow-sm rounded-2xl p-6 mb-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-slate-100 pb-4 mb-4">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="text-xs font-mono text-slate-400">{{ $activityLog->program->program_code }}</span>
                    <span class="text-xs font-bold text-navy bg-navy/10 px-2 py-0.5 rounded-full">{{ $activityLog->program->category?->name ?? 'Program' }}</span>
                </div>
                <h1 class="text-2xl font-bold text-slate-800" style="font-family: 'Big Shoulders Display', sans-serif;">
                    {{ $activityLog->title }}
                </h1>
                <p class="text-xs text-slate-500 mt-1">Program: <span class="font-semibold text-slate-700">{{ $activityLog->program->title }}</span></p>
            </div>
            <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 flex items-center gap-4">
                <div>
                    <span class="text-xs text-slate-400 block">Progress Dilaporkan</span>
                    <span class="text-xl font-bold text-navy">{{ $activityLog->progress_percentage }}%</span>
                </div>
                <div class="w-24 bg-slate-200 rounded-full h-2">
                    <div class="bg-navy h-2 rounded-full" style="width: {{ $activityLog->progress_percentage }}%"></div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-xs">
            <div>
                <span class="text-slate-400 block">Organisasi</span>
                <span class="font-semibold text-slate-800">{{ $activityLog->program->organization?->name ?? '-' }}</span>
            </div>
            <div>
                <span class="text-slate-400 block">Ketua Pelaksana</span>
                <span class="font-semibold text-slate-800">{{ $activityLog->program->leader?->name ?? '-' }}</span>
            </div>
            <div>
                <span class="text-slate-400 block">Tanggal Kegiatan</span>
                <span class="font-semibold text-slate-800">{{ $activityLog->activity_date ? $activityLog->activity_date->format('d M Y') : '-' }}</span>
            </div>
            <div>
                <span class="text-slate-400 block">Lokasi Program</span>
                <span class="font-semibold text-slate-800">{{ $activityLog->program->location ?? '-' }}</span>
            </div>
        </div>
    </div>

    <!-- Verifier Notes (If any) -->
    @if($activityLog->verifier_notes)
        <div class="bg-amber-50 border border-amber-200 rounded-2xl p-5 mb-6 text-amber-900">
            <h3 class="font-bold text-sm mb-1 flex items-center gap-2">
                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                Catatan Verifikator Dindikpora
            </h3>
            <p class="text-sm leading-relaxed whitespace-pre-line">{{ $activityLog->verifier_notes }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Content Details -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white border border-slate-200 shadow-sm rounded-2xl p-6 space-y-4">
                <h3 class="font-bold text-slate-800 border-b border-slate-100 pb-2">Deskripsi & Rincian Kegiatan</h3>
                <p class="text-slate-700 text-sm leading-relaxed whitespace-pre-line">{{ $activityLog->description }}</p>

                @if($activityLog->issues)
                    <div class="pt-4 border-t border-slate-100">
                        <h4 class="text-xs font-bold text-red-600 uppercase tracking-wider mb-1">Kendala di Lapangan</h4>
                        <p class="text-slate-700 text-sm leading-relaxed whitespace-pre-line">{{ $activityLog->issues }}</p>
                    </div>
                @endif

                @if($activityLog->solutions)
                    <div class="pt-4 border-t border-slate-100">
                        <h4 class="text-xs font-bold text-green-600 uppercase tracking-wider mb-1">Solusi & Penanganan</h4>
                        <p class="text-slate-700 text-sm leading-relaxed whitespace-pre-line">{{ $activityLog->solutions }}</p>
                    </div>
                @endif
            </div>

            <!-- Dokumentasi Foto / Gallery -->
            <div class="bg-white border border-slate-200 shadow-sm rounded-2xl p-6">
                <h3 class="font-bold text-slate-800 border-b border-slate-100 pb-3 mb-4">Dokumentasi Foto Kegiatan</h3>
                @if($activityLog->photos && $activityLog->photos->isNotEmpty())
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                        @foreach($activityLog->photos as $photo)
                            <div @click="selectedPhoto = '{{ asset('storage/' . $photo->photo) }}'" 
                                class="group relative rounded-xl overflow-hidden border border-slate-200 aspect-video cursor-pointer bg-slate-100">
                                <img src="{{ asset('storage/' . $photo->photo) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center text-white text-xs font-semibold">
                                    Klik untuk Perbesar 🔍
                                </div>
                                <span class="absolute bottom-2 left-2 px-2 py-0.5 bg-black/60 text-white text-[10px] font-semibold rounded-md backdrop-blur-sm">
                                    {{ $photo->photo_type instanceof \BackedEnum ? $photo->photo_type->value : $photo->photo_type }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-slate-400 text-sm">
                        Tidak ada foto dokumentasi terlampir.
                    </div>
                @endif
            </div>
        </div>

        <!-- Right Timeline Sidebar -->
        <div class="space-y-6">
            <div class="bg-white border border-slate-200 shadow-sm rounded-2xl p-6 space-y-4">
                <h3 class="font-bold text-slate-800 border-b border-slate-100 pb-2">Timeline Pelaporan</h3>
                <div class="relative pl-6 border-l-2 border-slate-200 space-y-4 text-xs">
                    <div class="relative">
                        <div class="absolute -left-[31px] top-0 w-4 h-4 rounded-full bg-navy border-2 border-white"></div>
                        <p class="font-bold text-slate-800">Logbook Dibuat</p>
                        <p class="text-slate-500">{{ $activityLog->created_at ? $activityLog->created_at->format('d M Y, H:i') : '-' }}</p>
                        <p class="text-slate-600 mt-0.5">Oleh {{ $activityLog->creator?->name ?? 'Ketua Pelaksana' }}</p>
                    </div>

                    @if($activityLog->updated_at && $activityLog->updated_at != $activityLog->created_at)
                        <div class="relative">
                            <div class="absolute -left-[31px] top-0 w-4 h-4 rounded-full bg-slate-400 border-2 border-white"></div>
                            <p class="font-bold text-slate-800">Terakhir Diperbarui</p>
                            <p class="text-slate-500">{{ $activityLog->updated_at->format('d M Y, H:i') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

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
