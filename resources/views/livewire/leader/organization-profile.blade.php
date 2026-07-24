<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800" style="font-family: 'Big Shoulders Display', sans-serif;">
                Profil Organisasi Kepemudaan
            </h1>
            <p class="text-slate-500 text-sm">Kelola informasi resmi organisasi Anda di SIPORA.</p>
        </div>
        <button type="submit" form="organization-form" class="px-5 py-2.5 bg-orange-500 hover:bg-orange-600 text-white rounded-xl text-sm font-semibold transition flex items-center gap-2 shadow-sm">
            <span wire:loading.remove wire:target="save">✓ Simpan Profil</span>
            <span wire:loading wire:target="save">Menyimpan...</span>
        </button>
    </div>

    <div class="bg-white border border-slate-200 shadow-sm rounded-2xl p-6">
        <form id="organization-form" wire:submit="save" class="space-y-6">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1.5">
                        Nama Organisasi <span class="text-red-500">*</span>
                    </label>
                    <input wire:model="name" type="text" required placeholder="Contoh: Karang Taruna Bina Pemuda"
                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:border-navy outline-none">
                    @error('name') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1.5">
                        Kategori Organisasi <span class="text-red-500">*</span>
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
                        Email Kontak
                    </label>
                    <input wire:model="email" type="email" placeholder="organisasi@email.com"
                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:border-navy outline-none">
                    @error('email') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1.5">
                        Nomor HP / WhatsApp
                    </label>
                    <input wire:model="phone" type="text" placeholder="081234567890"
                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:border-navy outline-none">
                    @error('phone') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1.5">
                        Website (Opsional)
                    </label>
                    <input wire:model="website" type="text" placeholder="https://..."
                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:border-navy outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1.5">
                        Tanggal Berdiri (Opsional)
                    </label>
                    <input wire:model="established_at" type="date"
                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:border-navy outline-none">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1.5">
                        Alamat Lengkap
                    </label>
                    <textarea wire:model="address" rows="2" placeholder="Alamat domisili sekretariat..."
                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:border-navy outline-none"></textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1.5">
                        Deskripsi Profil / Visi Misi
                    </label>
                    <textarea wire:model="description" rows="4" placeholder="Jelaskan mengenai sejarah singkat, visi, dan misi organisasi..."
                        class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:border-navy outline-none"></textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1.5">
                        Logo Organisasi
                    </label>
                    <div class="flex items-center gap-4">
                        @if($existing_logo && !$logo)
                            <img src="{{ asset('storage/' . $existing_logo) }}" alt="Logo" class="w-16 h-16 rounded-xl object-cover border border-slate-200">
                        @elseif($logo)
                            <img src="{{ $logo->temporaryUrl() }}" alt="Preview" class="w-16 h-16 rounded-xl object-cover border border-slate-200">
                        @endif
                        <input wire:model="logo" type="file" accept="image/*"
                            class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-navy file:text-white hover:file:bg-slate-800">
                    </div>
                    @error('logo') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="md:col-span-2 border-t border-slate-100 pt-6 mt-2">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1.5">
                        Dokumen Legalitas (SK, AD/ART)
                    </label>
                    
                    @if(count($existing_docs) > 0)
                        <div class="mb-4 bg-slate-50 rounded-xl p-4 border border-slate-200">
                            <h4 class="text-sm font-semibold text-slate-700 mb-3">Dokumen Tersimpan:</h4>
                            <ul class="space-y-2">
                                @foreach($existing_docs as $doc)
                                    <li class="flex items-center justify-between bg-white px-3 py-2 rounded-lg border border-slate-100 shadow-sm">
                                        <a href="{{ asset('storage/' . $doc) }}" target="_blank" class="text-sm text-navy hover:underline flex items-center gap-2 truncate">
                                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                            {{ basename($doc) }}
                                        </a>
                                        <button type="button" wire:click="deleteDocument('{{ $doc }}')" class="text-red-500 hover:text-red-700 p-1" title="Hapus Dokumen">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <input wire:model="legal_docs" type="file" multiple accept=".pdf,.doc,.docx,.jpg,.png"
                        class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200">
                    <p class="text-[11px] text-slate-400 mt-1">Anda dapat memilih beberapa file sekaligus (Maksimal 5MB/file).</p>
                    @error('legal_docs.*') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex justify-end">
                <button type="submit" class="px-6 py-2.5 bg-navy hover:bg-slate-800 text-white rounded-xl text-sm font-semibold transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
