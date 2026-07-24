<div>
    <div class="mb-4">
        <a href="{{ route('leader.programs.index') }}" class="text-sm font-medium text-slate-500 hover:text-slate-800 inline-flex items-center gap-1">
            &larr; Kembali ke Daftar Program
        </a>
    </div>

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800" style="font-family: 'Big Shoulders Display', sans-serif;">
            Ajukan Proposal Program Baru
        </h1>
        <p class="text-slate-500 text-sm">Isi formulir pengajuan proposal program kepemudaan ke Dinas Dindikpora.</p>
    </div>

    <div class="bg-white border border-slate-200 shadow-sm rounded-2xl p-6">
        <form class="space-y-6">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1.5">
                        Judul Program / Kegiatan <span class="text-red-500">*</span>
                    </label>
                    <input wire:model="title" type="text" required placeholder="Contoh: Pelatihan Kewirausahaan Pemuda Pemalang 2026"
                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:border-navy outline-none">
                    @error('title') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1.5">
                        Organisasi Pelaksana <span class="text-red-500">*</span>
                    </label>
                    <select wire:model="organization_id" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:border-navy outline-none">
                        <option value="">-- Pilih Organisasi --</option>
                        @foreach($organizations as $org)
                            <option value="{{ $org->id }}">{{ $org->name }}</option>
                        @endforeach
                    </select>
                    @error('organization_id') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1.5">
                        Kategori Program <span class="text-red-500">*</span>
                    </label>
                    <select wire:model="category_id" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:border-navy outline-none">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1.5">
                        Tanggal Mulai <span class="text-red-500">*</span>
                    </label>
                    <input wire:model="start_date" type="date" required
                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:border-navy outline-none">
                    @error('start_date') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1.5">
                        Tanggal Selesai <span class="text-red-500">*</span>
                    </label>
                    <input wire:model="end_date" type="date" required
                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:border-navy outline-none">
                    @error('end_date') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1.5">
                        Anggaran yang Diajukan (Rp) <span class="text-red-500">*</span>
                    </label>
                    <input wire:model="budget" type="number" required min="0" placeholder="5000000"
                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:border-navy outline-none">
                    @error('budget') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1.5">
                        Lokasi Pelaksanaan
                    </label>
                    <input wire:model="location" type="text" placeholder="Contoh: Gedung Pemuda Kab. Pemalang"
                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:border-navy outline-none">
                    @error('location') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1.5">
                        Deskripsi Program <span class="text-red-500">*</span>
                    </label>
                    <textarea wire:model="description" rows="3" required placeholder="Jelaskan latar belakang dan gambaran umum program..."
                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:border-navy outline-none"></textarea>
                    @error('description') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1.5">
                        Tujuan Program
                    </label>
                    <textarea wire:model="objective" rows="2" placeholder="Tujuan utama pelaksanaan program..."
                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:border-navy outline-none"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1.5">
                        Sasaran Peserta / Target
                    </label>
                    <textarea wire:model="target" rows="2" placeholder="Contoh: 100 Pemuda Usia 17-25 Tahun..."
                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:border-navy outline-none"></textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1.5">
                        Upload Proposal (PDF/DOC)
                    </label>
                    <input wire:model="proposal_file" type="file" accept=".pdf,.doc,.docx,.zip"
                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:border-navy outline-none file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-navy file:text-white hover:file:bg-slate-800">
                    <p class="text-[11px] text-slate-400 mt-1">Maksimal 10MB. Jika kosong, bisa diunggah nanti.</p>
                    @error('proposal_file') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex flex-wrap justify-end gap-3">
                <a href="{{ route('leader.programs.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-sm font-semibold transition">
                    Batal
                </a>
                <button type="button" wire:click="saveDraft" class="px-5 py-2.5 border border-slate-300 bg-white hover:bg-slate-50 text-slate-700 rounded-xl text-sm font-semibold transition">
                    <span wire:loading.remove wire:target="saveDraft">Simpan Draft</span>
                    <span wire:loading wire:target="saveDraft">Menyimpan...</span>
                </button>
                <button type="button" wire:click="submit" class="px-6 py-2.5 bg-orange-500 hover:bg-orange-600 active:bg-orange-700 text-white rounded-xl text-sm font-semibold transition shadow-sm">
                    <span wire:loading.remove wire:target="submit">Kirim Proposal</span>
                    <span wire:loading wire:target="submit">Mengirimkan...</span>
                </button>
            </div>
        </form>
    </div>
</div>
