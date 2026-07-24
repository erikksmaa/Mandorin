<div>
    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800" style="font-family: 'Big Shoulders Display', sans-serif;">
                Monitoring Logbook Kegiatan Program
            </h1>
            <p class="text-xs text-slate-500 mt-1">Verifikasi dan pantau seluruh laporan harian organisasi kepemudaan</p>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="bg-white border border-slate-200 shadow-sm rounded-2xl p-4 mb-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-3">
            <div class="lg:col-span-2">
                <label class="block text-[11px] font-bold text-slate-400 uppercase mb-1">Pencarian</label>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari logbook atau program..." class="w-full border-slate-300 rounded-xl text-xs focus:border-navy focus:ring focus:ring-navy focus:ring-opacity-50">
            </div>

            <div>
                <label class="block text-[11px] font-bold text-slate-400 uppercase mb-1">Organisasi</label>
                <select wire:model.live="organization_id" class="w-full border-slate-300 rounded-xl text-xs focus:border-navy focus:ring focus:ring-navy focus:ring-opacity-50">
                    <option value="">Semua Organisasi</option>
                    @foreach($organizations as $org)
                        <option value="{{ $org->id }}">{{ $org->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-[11px] font-bold text-slate-400 uppercase mb-1">Kategori Program</label>
                <select wire:model.live="category_id" class="w-full border-slate-300 rounded-xl text-xs focus:border-navy focus:ring focus:ring-navy focus:ring-opacity-50">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-[11px] font-bold text-slate-400 uppercase mb-1">Status Verifikasi</label>
                <select wire:model.live="status" class="w-full border-slate-300 rounded-xl text-xs focus:border-navy focus:ring focus:ring-navy focus:ring-opacity-50">
                    <option value="">Semua Status</option>
                    <option value="Draft">Draft</option>
                    <option value="Submitted">Submitted (Diajukan)</option>
                    <option value="Approved">Approved (Disetujui)</option>
                    <option value="Revised">Revised (Revisi)</option>
                </select>
            </div>

            <div>
                <label class="block text-[11px] font-bold text-slate-400 uppercase mb-1">Tampilkan Data</label>
                <select wire:model.live="perPage" class="w-full border-slate-300 rounded-xl text-xs focus:border-navy focus:ring focus:ring-navy focus:ring-opacity-50">
                    <option value="10">10 Data</option>
                    <option value="25">25 Data</option>
                    <option value="50">50 Data</option>
                    <option value="100">100 Data</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Logbook Cards / Grid -->
    @if($logs->isEmpty())
        <div class="bg-white border border-slate-200 shadow-sm rounded-2xl p-12 text-center text-slate-400">
            <svg class="w-12 h-12 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            <p class="font-medium text-slate-600">Tidak ada logbook ditemukan</p>
            <p class="text-xs text-slate-400 mt-1">Coba sesuaikan filter pencarian Anda.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
            @foreach($logs as $log)
                <div class="bg-white border border-slate-200 shadow-sm rounded-2xl p-5 flex flex-col justify-between hover:border-slate-300 transition">
                    <div>
                        <div class="flex items-center justify-between gap-2 mb-2">
                            <span class="text-[10px] font-mono text-slate-400">{{ $log->program?->program_code }}</span>
                            @php
                                $statVal = $log->status instanceof \BackedEnum ? $log->status->value : $log->status;
                            @endphp
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold
                                {{ match($statVal) {
                                    'Approved' => 'bg-green-100 text-green-700',
                                    'Submitted' => 'bg-blue-100 text-blue-700',
                                    'Revised' => 'bg-amber-100 text-amber-700',
                                    default => 'bg-slate-100 text-slate-700'
                                } }}">
                                {{ $log->status instanceof \BackedEnum ? $log->status->label() : $log->status }}
                            </span>
                        </div>

                        <h3 class="font-bold text-slate-800 text-base mb-1 line-clamp-1">{{ $log->title }}</h3>
                        <p class="text-xs text-navy font-semibold mb-3 line-clamp-1">Program: {{ $log->program?->title ?? '-' }}</p>

                        <div class="flex items-center justify-between text-xs text-slate-500 mb-3 bg-slate-50 p-2.5 rounded-xl border border-slate-100">
                            <div>
                                <span class="text-slate-400 block text-[10px]">Organisasi:</span>
                                <span class="font-semibold text-slate-700 truncate max-w-[120px] block">{{ $log->program?->organization?->name ?? '-' }}</span>
                            </div>
                            <div class="text-right">
                                <span class="text-slate-400 block text-[10px]">Progress:</span>
                                <span class="font-bold text-navy">{{ $log->progress_percentage }}%</span>
                            </div>
                        </div>

                        <p class="text-xs text-slate-600 line-clamp-2 mb-4 whitespace-pre-line">{{ $log->description }}</p>

                        <!-- Photos Preview Count -->
                        <div class="flex items-center gap-2 mb-4 text-xs text-slate-500">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span>{{ $log->photos ? $log->photos->count() : 0 }} Foto Dokumentasi</span>
                        </div>
                    </div>

                    <div class="pt-3 border-t border-slate-100 flex items-center gap-2">
                        <a href="{{ route('verifier.logbook.show', $log->id) }}" class="flex-1 text-center py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition">
                            Lihat Detail
                        </a>
                        <button type="button" wire:click="openStatusModal({{ $log->id }})" class="py-2 px-3 bg-navy hover:bg-slate-800 text-white text-xs font-semibold rounded-xl transition shadow-sm">
                            Ubah Status
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <div>
            {{ $logs->links() }}
        </div>
    @endif

    <!-- Update Status Modal -->
    @if($selectedLogId)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4 backdrop-blur-sm">
            <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-2xl space-y-4">
                <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                    <h3 class="font-bold text-slate-800">Verifikasi Logbook Kegiatan</h3>
                    <button wire:click="closeModal" class="text-slate-400 hover:text-slate-600 font-bold">✕</button>
                </div>

                <form wire:submit="updateLogStatus" class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Pilih Status Baru</label>
                        <select wire:model="selectedStatus" class="w-full border-slate-300 rounded-xl text-sm focus:border-navy focus:ring focus:ring-navy focus:ring-opacity-50">
                            <option value="Draft">Draft</option>
                            <option value="Submitted">Submitted (Diajukan)</option>
                            <option value="Approved">Approved (Disetujui)</option>
                            <option value="Revised">Revised (Perlu Revisi)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Catatan Verifikator Dindikpora</label>
                        <textarea wire:model="verifier_notes" rows="3" class="w-full border-slate-300 rounded-xl text-xs focus:border-navy focus:ring focus:ring-navy focus:ring-opacity-50" placeholder="Tuliskan alasan atau instruksi revisi jika ada..."></textarea>
                    </div>

                    <div class="flex items-center gap-2 pt-2">
                        <button type="button" wire:click="closeModal" class="flex-1 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition">
                            Batal
                        </button>
                        <button type="submit" class="flex-1 py-2 bg-navy hover:bg-slate-800 text-white text-xs font-semibold rounded-xl transition shadow-sm">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
