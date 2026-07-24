<div class="max-w-3xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="mb-6">
        <a href="{{ route('leader.programs.show', $program->id) }}" class="text-slate-500 hover:text-navy text-sm flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Program
        </a>
    </div>

    <h1 class="text-2xl font-bold text-slate-800 mb-6" style="font-family: 'Big Shoulders Display', sans-serif;">
        Logbook & Dokumentasi — {{ $program->title }}
    </h1>

    <div class="bg-white border border-slate-200 shadow-sm rounded-2xl p-6">
        <form wire:submit="save">
            <div class="space-y-6">
                <!-- Title -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Judul Kegiatan</label>
                    <input type="text" wire:model="title" class="w-full border-slate-300 rounded-lg text-sm focus:border-navy focus:ring focus:ring-navy focus:ring-opacity-50" placeholder="Contoh: Pelaksanaan Workshop Tahap 1">
                    @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Date & Progress -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Tanggal Kegiatan</label>
                        <input type="date" wire:model="activity_date" class="w-full border-slate-300 rounded-lg text-sm focus:border-navy focus:ring focus:ring-navy focus:ring-opacity-50">
                        @error('activity_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Progress Program (%)</label>
                        <div x-data="{ val: @entangle('progress_percentage') }" class="flex items-center gap-3">
                            <input type="range" x-model="val" wire:model.live="progress_percentage" min="0" max="100" class="w-full h-2 bg-slate-200 rounded-lg appearance-none cursor-pointer accent-navy">
                            <span class="w-12 text-center text-sm font-bold text-navy" x-text="(val ?? 0) + '%'">{{ $progress_percentage }}%</span>
                        </div>
                        @error('progress_percentage') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Deskripsi Kegiatan</label>
                    <textarea wire:model="description" rows="4" class="w-full border-slate-300 rounded-lg text-sm focus:border-navy focus:ring focus:ring-navy focus:ring-opacity-50 placeholder-slate-400" placeholder="Jelaskan detail kegiatan yang telah dilaksanakan..."></textarea>
                    @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Issues & Solutions -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Kendala (Opsional)</label>
                        <textarea wire:model="issues" rows="2" class="w-full border-slate-300 rounded-lg text-sm focus:border-navy focus:ring focus:ring-navy focus:ring-opacity-50" placeholder="Tuliskan kendala jika ada..."></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Solusi / Penanganan (Opsional)</label>
                        <textarea wire:model="solutions" rows="2" class="w-full border-slate-300 rounded-lg text-sm focus:border-navy focus:ring focus:ring-navy focus:ring-opacity-50" placeholder="Solusi yang dilakukan..."></textarea>
                    </div>
                </div>

                <!-- Photos -->
                <div class="pt-4 border-t border-slate-100">
                    <h3 class="text-sm font-bold text-slate-800 mb-3">Foto Dokumentasi Wajib</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                        <!-- Before Photo -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Foto Sebelum (0%) <span class="text-red-500">*</span></label>
                            @if($before_photo)
                                <img src="{{ $before_photo->temporaryUrl() }}" class="h-32 w-full object-cover rounded-lg border border-slate-200 mb-2">
                            @endif
                            <input type="file" wire:model="before_photo" accept="image/*" class="w-full text-xs text-slate-500 file:mr-2 file:py-1 file:px-3 file:rounded-lg file:border-0 file:bg-slate-50 file:text-navy hover:file:bg-slate-100" required>
                            @error('before_photo') <span class="text-red-500 text-[10px] block mt-1">{{ $message }}</span> @enderror
                        </div>

                        <!-- Progress Photo -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Foto Sedang Proses <span class="text-red-500">*</span></label>
                            @if($progress_photo)
                                <img src="{{ $progress_photo->temporaryUrl() }}" class="h-32 w-full object-cover rounded-lg border border-slate-200 mb-2">
                            @endif
                            <input type="file" wire:model="progress_photo" accept="image/*" class="w-full text-xs text-slate-500 file:mr-2 file:py-1 file:px-3 file:rounded-lg file:border-0 file:bg-slate-50 file:text-navy hover:file:bg-slate-100" required>
                            @error('progress_photo') <span class="text-red-500 text-[10px] block mt-1">{{ $message }}</span> @enderror
                        </div>

                        <!-- After Photo -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Foto Sesudah</label>
                            @if($after_photo)
                                <img src="{{ $after_photo->temporaryUrl() }}" class="h-32 w-full object-cover rounded-lg border border-slate-200 mb-2">
                            @endif
                            <input type="file" wire:model="after_photo" accept="image/*" class="w-full text-xs text-slate-500 file:mr-2 file:py-1 file:px-3 file:rounded-lg file:border-0 file:bg-slate-50 file:text-navy hover:file:bg-slate-100">
                            <span class="text-[10px] text-slate-400">Opsional jika belum 100%</span>
                            @error('after_photo') <span class="text-red-500 text-[10px] block mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <h3 class="text-sm font-bold text-slate-800 mb-3">Dokumentasi Tambahan</h3>
                    <div>
                        <label class="block text-xs font-medium text-slate-500 mb-1">Pilih beberapa foto tambahan (Maksimal 5 foto, opsional)</label>
                        <input type="file" wire:model="documentation_photos" multiple accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-slate-50 file:text-navy hover:file:bg-slate-100">
                        @error('documentation_photos.*') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
                        @error('documentation_photos') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
                        
                        @if ($documentation_photos && is_array($documentation_photos) && count($documentation_photos) > 0)
                            <div class="mt-4 grid grid-cols-2 sm:grid-cols-5 gap-4">
                                @foreach ($documentation_photos as $photo)
                                    <div class="relative">
                                        <img src="{{ $photo->temporaryUrl() }}" class="h-24 w-full object-cover rounded-lg border border-slate-200">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <div class="pt-4 flex justify-end">
                    <button type="submit" class="px-6 py-2.5 bg-orange-500 hover:bg-orange-600 text-white rounded-xl font-medium transition flex items-center justify-center gap-2 text-sm shadow-sm">
                        <span wire:loading.remove wire:target="save">Simpan Logbook</span>
                        <span wire:loading wire:target="save">Menyimpan...</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
