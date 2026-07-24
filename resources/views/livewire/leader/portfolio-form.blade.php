<div class="max-w-3xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="mb-6">
        <a href="{{ route('leader.profile.show') }}" class="text-slate-500 hover:text-navy text-sm flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Profil
        </a>
    </div>

    <h1 class="text-2xl font-bold text-slate-800 mb-6" style="font-family: 'Big Shoulders Display', sans-serif;">
        {{ $isEditing ? 'Edit Portfolio' : 'Tambah Portfolio' }}
    </h1>

    <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-6">
        <form wire:submit="save">
            <div class="space-y-6">
                <!-- Title -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Judul Anggotaan</label>
                    <input type="text" wire:model="title" class="w-full border-slate-300 rounded-lg text-sm focus:border-navy focus:ring focus:ring-navy focus:ring-opacity-50" placeholder="Contoh: Renovasi Dapur Modern">
                    @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Deskripsi Singkat</label>
                    <textarea wire:model="description" rows="4" class="w-full border-slate-300 rounded-lg text-sm focus:border-navy focus:ring focus:ring-navy focus:ring-opacity-50 placeholder-slate-400" placeholder="Jelaskan apa yang Anda kerjakan..."></textarea>
                    @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Photos -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Foto Sebelum</label>
                        <input type="file" wire:model="beforePhoto" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-slate-50 file:text-navy hover:file:bg-slate-100">
                        @error('beforePhoto') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        
                        @if ($beforePhoto)
                            <div class="mt-2">
                                <img src="{{ $beforePhoto->temporaryUrl() }}" class="h-32 object-cover rounded-lg border border-slate-200">
                            </div>
                        @elseif($isEditing && $portfolio->before_photo)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $portfolio->before_photo) }}" class="h-32 object-cover rounded-lg border border-slate-200">
                            </div>
                        @endif
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Foto Sesudah (Hasil)</label>
                        <input type="file" wire:model="afterPhoto" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-slate-50 file:text-navy hover:file:bg-slate-100">
                        @error('afterPhoto') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        
                        @if ($afterPhoto)
                            <div class="mt-2">
                                <img src="{{ $afterPhoto->temporaryUrl() }}" class="h-32 object-cover rounded-lg border border-slate-200">
                            </div>
                        @elseif($isEditing && $portfolio->after_photo)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $portfolio->after_photo) }}" class="h-32 object-cover rounded-lg border border-slate-200">
                            </div>
                        @endif
                    </div>
                </div>

                <div class="pt-4 flex justify-between items-center border-t border-slate-100">
                    @if($isEditing)
                        <button type="button" @click="Swal.fire({ icon: 'warning', title: 'Hapus Portfolio?', text: 'Apakah Anda yakin ingin menghapus portfolio ini?', showCancelButton: true, confirmButtonText: 'Ya, Hapus', cancelButtonText: 'Batal', confirmButtonColor: '#ef4444', cancelButtonColor: '#64748b' }).then(r => { if (r.isConfirmed) $wire.deletePortfolio(); })" class="px-4 py-2 bg-red-100 text-red-700 hover:bg-red-200 rounded-xl text-sm font-medium transition">
                            Hapus Portfolio
                        </button>
                    @else
                        <div></div>
                    @endif
                    
                    <button type="submit" class="px-6 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-xl font-medium transition flex items-center justify-center gap-2">
                        <span wire:loading.remove wire:target="save">Simpan</span>
                        <span wire:loading wire:target="save">Menyimpan...</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
