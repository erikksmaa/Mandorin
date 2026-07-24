<div>
    <div class="mb-4 flex justify-between items-center">
        <a href="{{ route('leader.profile.show') }}" class="text-sm font-medium text-slate-500 hover:text-slate-800 inline-flex items-center gap-1">
            &larr; Kembali ke Profil Organisasi
        </a>
    </div>

    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 gap-4">
        <h2 class="text-xl font-bold text-slate-800" style="font-family: 'Big Shoulders Display', sans-serif;">
            Anggota Organisasi: {{ $organization->name }}
        </h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Form Tambah/Edit Anggota -->
        <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-5 h-fit">
            <div class="flex justify-between items-center border-b border-slate-100 pb-2 mb-4">
                <h3 class="font-bold text-slate-800">{{ $editingMemberId ? 'Edit Anggota' : 'Tambah Anggota' }}</h3>
                @if($editingMemberId)
                    <button type="button" wire:click="cancelEdit" class="text-xs text-slate-500 hover:text-slate-700 underline">Batal</button>
                @endif
            </div>
            <form wire:submit="addMember" class="space-y-4">
                
                <div class="flex justify-center mb-2">
                    @if($avatar)
                        <img src="{{ $avatar->temporaryUrl() }}" class="w-16 h-16 rounded-full object-cover border-2 border-navy">
                    @else
                        <div class="w-16 h-16 rounded-full bg-slate-100 border-2 border-slate-200 flex items-center justify-center text-slate-400">
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                        </div>
                    @endif
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Foto / Avatar (Opsional)</label>
                    <input type="file" wire:model="avatar" accept="image/*" class="w-full text-xs text-slate-500 file:mr-2 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200">
                    @error('avatar') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" wire:model="name" class="w-full border-slate-300 rounded-lg text-sm focus:border-navy focus:ring focus:ring-navy focus:ring-opacity-50" placeholder="Ketik nama anggota..." required>
                    @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
                
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">No. HP / WhatsApp</label>
                    <input type="text" wire:model="phone" class="w-full border-slate-300 rounded-lg text-sm focus:border-navy focus:ring focus:ring-navy focus:ring-opacity-50" placeholder="081234567890">
                    @error('phone') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
                
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Jabatan <span class="text-red-500">*</span></label>
                    <select wire:model="position" class="w-full border-slate-300 rounded-lg text-sm focus:border-navy focus:ring focus:ring-navy focus:ring-opacity-50" required>
                        <option value="Ketua">Ketua</option>
                        <option value="Sekretaris">Sekretaris</option>
                        <option value="Bendahara">Bendahara</option>
                        <option value="Koordinator">Koordinator</option>
                        <option value="Anggota">Anggota</option>
                    </select>
                    @error('position') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Status Keanggotaan <span class="text-red-500">*</span></label>
                    <select wire:model="status" class="w-full border-slate-300 rounded-lg text-sm focus:border-navy focus:ring focus:ring-navy focus:ring-opacity-50" required>
                        <option value="active">Aktif</option>
                        <option value="inactive">Tidak Aktif</option>
                    </select>
                    @error('status') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Tanggal Bergabung <span class="text-red-500">*</span></label>
                    <input type="date" wire:model="joined_at" class="w-full border-slate-300 rounded-lg text-sm focus:border-navy focus:ring focus:ring-navy focus:ring-opacity-50" required>
                    @error('joined_at') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-2 bg-navy hover:bg-slate-800 text-white rounded-lg text-sm font-medium transition shadow-sm">
                        <span wire:loading.remove wire:target="addMember">+ Tambah Anggota</span>
                        <span wire:loading wire:target="addMember">Menyimpan...</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Tabel Anggota -->
        <div class="md:col-span-2 space-y-4">
            <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-4 flex flex-col sm:flex-row items-center justify-between gap-3">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nama atau email anggota..." class="w-full sm:w-64 border-slate-200 rounded-lg text-xs focus:ring-navy focus:border-navy">
                
                <div class="flex items-center gap-3">
                    <select wire:model.live="positionFilter" class="border-slate-200 rounded-lg text-xs py-1.5 px-2 focus:ring-navy focus:border-navy">
                        <option value="">Semua Jabatan</option>
                        <option value="Ketua">Ketua</option>
                        <option value="Sekretaris">Sekretaris</option>
                        <option value="Bendahara">Bendahara</option>
                        <option value="Koordinator">Koordinator</option>
                        <option value="Anggota">Anggota</option>
                    </select>

                    <div class="flex items-center gap-1.5 text-xs text-slate-500">
                        <span>Tampilkan:</span>
                        <select wire:model.live="perPage" class="border-slate-200 rounded-lg text-xs py-1.5 px-2 focus:ring-navy focus:border-navy">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                </div>
            </div>

            @if($members->isEmpty())
                <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-8 text-center text-slate-500">
                    Belum ada anggota yang terdaftar dalam organisasi ini.
                </div>
            @else
                <div class="bg-white border border-slate-200 shadow-sm rounded-xl overflow-hidden mb-4">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-slate-50 text-slate-600 border-b border-slate-200">
                                <tr>
                                    <th class="px-6 py-3 font-semibold">Anggota</th>
                                    <th class="px-6 py-3 font-semibold">Jabatan</th>
                                    <th class="px-6 py-3 font-semibold">Status</th>
                                    <th class="px-6 py-3 font-semibold text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($members as $member)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            @if($member->user?->avatar)
                                                <img src="{{ asset('storage/' . $member->user->avatar) }}" class="w-10 h-10 rounded-full object-cover">
                                            @else
                                                <div class="w-10 h-10 rounded-full bg-slate-200 text-slate-500 flex items-center justify-center font-bold">
                                                    {{ strtoupper(substr($member->user?->name ?? '?', 0, 1)) }}
                                                </div>
                                            @endif
                                            <div>
                                                <div class="font-bold text-slate-800">{{ $member->user?->name ?? 'Unknown' }}</div>
                                                <div class="text-xs text-slate-500">{{ $member->user?->phone ?? 'Tidak ada No. HP' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-slate-700">{{ $member->position instanceof \BackedEnum ? $member->position->value : $member->position }}</div>
                                        <div class="text-xs text-slate-400">Bergabung: {{ $member->joined_at ? $member->joined_at->format('d M Y') : '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                            $statVal = $member->status instanceof \BackedEnum ? $member->status->value : $member->status;
                                        @endphp
                                        <span class="px-2.5 py-1 rounded-md text-xs font-semibold {{ $statVal === 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                            {{ $statVal === 'active' ? 'Aktif' : 'Tidak Aktif' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right space-x-2">
                                        <button type="button" wire:click="editMember({{ $member->id }})" class="text-navy hover:text-slate-800 hover:underline text-sm font-medium">
                                            Edit
                                        </button>
                                        <button type="button" @click="Swal.fire({ icon: 'warning', title: 'Hapus Anggota?', text: 'Yakin ingin menghapus anggota ini dari organisasi?', showCancelButton: true, confirmButtonText: 'Ya, Hapus', cancelButtonText: 'Batal', confirmButtonColor: '#ef4444', cancelButtonColor: '#64748b' }).then(r => { if (r.isConfirmed) $wire.removeMember({{ $member->id }}); })" class="text-red-500 hover:text-red-700 hover:underline text-sm font-medium">
                                            Hapus
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div>
                    {{ $members->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
