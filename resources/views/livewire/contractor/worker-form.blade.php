<div>
    <a href="{{ route('contractor.projects.show', $project) }}" class="text-sm font-medium text-slate-500 hover:text-slate-800 mb-6 inline-flex items-center gap-1">
        &larr; Kembali ke Detail Proyek
    </a>

    <h1 class="text-2xl font-bold text-slate-800 mb-6" style="font-family: 'Big Shoulders Display', sans-serif;">
        {{ $worker ? 'Edit Pekerja' : 'Tambah Pekerja' }}
    </h1>

    <div class="bg-white border border-slate-200 shadow-sm rounded-2xl p-6 max-w-2xl">
        <form wire:submit="save">
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap</label>
                <input type="text" id="name" wire:model="name" class="w-full rounded-xl border-slate-300 shadow-sm focus:border-orange-500 focus:ring-orange-500" required>
                @error('name') <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label for="phone" class="block text-sm font-medium text-slate-700 mb-1">Nomor HP</label>
                <input type="text" id="phone" wire:model="phone" class="w-full rounded-xl border-slate-300 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                @error('phone') <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="mb-6">
                <label for="role" class="block text-sm font-medium text-slate-700 mb-1">Peran (Role)</label>
                <input type="text" id="role" wire:model="role" placeholder="Contoh: Tukang Kayu, Kenek, Mandor" class="w-full rounded-xl border-slate-300 shadow-sm focus:border-orange-500 focus:ring-orange-500" required>
                @error('role') <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('contractor.projects.show', $project) }}" class="px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50 rounded-xl transition border border-transparent">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-xl font-medium transition text-sm">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
