<div>
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800" style="font-family: 'Big Shoulders Display', sans-serif;">
                Kelola Kategori Organisasi
            </h1>
            <p class="text-slate-500 text-sm">Kelola daftar jenis/kategori organisasi kepemudaan yang terdaftar.</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="w-64 relative">
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari kategori organisasi..." class="w-full pl-9 pr-3 py-1.5 text-xs bg-white border border-slate-200 rounded-xl focus:border-navy focus:ring-navy">
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <button wire:click="openModal" class="px-4 py-2 bg-orange-500 hover:bg-orange-600 active:bg-orange-700 text-white text-sm font-semibold rounded-xl transition-all shadow-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Kategori Organisasi
            </button>
        </div>
    </div>

    <div class="mb-4 flex items-center justify-between">
        <div class="flex items-center gap-1.5 text-xs text-slate-500">
            <span>Tampilkan:</span>
            <select wire:model.live="perPage" class="border-slate-200 rounded-lg text-xs py-1 px-2 focus:ring-navy focus:border-navy">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
            <span>data</span>
        </div>
    </div>

    {{-- Data Table --}}
    <div class="bg-white border border-slate-200 shadow-sm rounded-xl overflow-hidden mb-6">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-slate-800 border-b border-slate-200 font-semibold">
                    <tr>
                        <th class="px-6 py-3.5 w-16">No</th>
                        <th class="px-6 py-3.5">Nama Kategori</th>
                        <th class="px-6 py-3.5">Deskripsi</th>
                        <th class="px-6 py-3.5 text-center">Jumlah Organisasi</th>
                        <th class="px-6 py-3.5 text-center w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($categories as $index => $cat)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="px-6 py-4 font-medium text-slate-500">
                                {{ $index + 1 }}
                            </td>
                            <td class="px-6 py-4 font-semibold text-slate-800">
                                {{ $cat->name }}
                            </td>
                            <td class="px-6 py-4 text-slate-500 max-w-xs truncate">
                                {{ $cat->description ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-center font-mono font-semibold">
                                {{ $cat->organizations_count ?? 0 }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <button wire:click="edit({{ $cat->id }})" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Edit">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                    <button @click="Swal.fire({ icon: 'warning', title: 'Hapus Kategori?', text: 'Apakah Anda yakin ingin menghapus kategori organisasi ini?', showCancelButton: true, confirmButtonText: 'Ya, Hapus', cancelButtonText: 'Batal', confirmButtonColor: '#ef4444', cancelButtonColor: '#64748b' }).then(r => { if (r.isConfirmed) $wire.delete({{ $cat->id }}); })" class="p-1.5 text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                Tidak ada data kategori organisasi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div>
        {{ $categories->links() }}
    </div>

    {{-- Modal Form --}}
    @if($isModalOpen)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs transition-opacity" wire:click="closeModal" aria-hidden="true"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-slate-100">
                    <div class="bg-white px-6 pt-6 pb-4">
                        <div class="flex items-center justify-between pb-4 mb-4 border-b border-slate-100">
                            <h3 class="text-lg font-bold text-slate-800" id="modal-title">
                                {{ $editingCategoryId ? 'Edit Kategori Organisasi' : 'Tambah Kategori Organisasi' }}
                            </h3>
                            <button wire:click="closeModal" class="text-slate-400 hover:text-slate-600 transition">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <form wire:submit="save" class="space-y-4">
                            <div>
                                <label for="name" class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1.5">
                                    Nama Kategori <span class="text-red-500">*</span>
                                </label>
                                <input wire:model="name" id="name" type="text" required placeholder="Contoh: Organisasi Kepemudaan (OKP)" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:border-navy outline-none">
                                @error('name') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label for="description" class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1.5">
                                    Deskripsi Kategori
                                </label>
                                <textarea wire:model="description" id="description" rows="3" placeholder="Penjelasan singkat mengenai kategori ini..." class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:border-navy outline-none"></textarea>
                                @error('description') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                                <button type="button" wire:click="closeModal" class="px-4 py-2.5 text-sm font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition">
                                    Batal
                                </button>
                                <button type="submit" class="px-5 py-2.5 text-sm font-semibold text-white bg-navy hover:bg-navy-700 rounded-xl transition">
                                    Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
