<div>
    <h1 class="text-2xl font-bold text-slate-800 mb-6" style="font-family: 'Big Shoulders Display', sans-serif;">
        Manajemen Pengguna
    </h1>

    <div class="mb-6 flex flex-col sm:flex-row gap-4 justify-between items-start sm:items-center">
        <div class="w-full sm:w-96 relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-slate-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" /></svg>
            </div>
            <input wire:model.live.debounce.300ms="search" type="text" class="w-full pl-10 pr-4 py-2 border border-slate-200 rounded-xl focus:ring-orange-500 focus:border-orange-500 text-sm" placeholder="Cari nama atau email...">
        </div>

        <div class="flex items-center gap-3 overflow-x-auto pb-2 sm:pb-0 w-full sm:w-auto">
            <div class="flex items-center gap-1.5 text-xs text-slate-500 shrink-0">
                <span>Tampilkan:</span>
                <select wire:model.live="perPage" class="border-slate-200 rounded-lg text-xs py-1 px-2 focus:ring-navy focus:border-navy">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>

            <button wire:click="$set('filterRole', '')" class="px-3.5 py-1.5 rounded-full text-xs font-medium whitespace-nowrap {{ $filterRole === '' ? 'bg-slate-800 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                Semua
            </button>
            <button wire:click="$set('filterRole', 'administrator')" class="px-3.5 py-1.5 rounded-full text-xs font-medium whitespace-nowrap {{ $filterRole === 'administrator' ? 'bg-navy text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                Admin
            </button>
            <button wire:click="$set('filterRole', 'leader')" class="px-3.5 py-1.5 rounded-full text-xs font-medium whitespace-nowrap {{ $filterRole === 'leader' ? 'bg-orange-500 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                Ketua Pelaksana
            </button>
            <button wire:click="$set('filterRole', 'verifikator')" class="px-3.5 py-1.5 rounded-full text-xs font-medium whitespace-nowrap {{ $filterRole === 'verifikator' ? 'bg-blue-500 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                Verifikator
            </button>
        </div>
    </div>

    <div class="bg-white border border-slate-200 shadow-sm rounded-xl overflow-hidden mb-6">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-slate-800 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4 font-medium">No</th>
                        <th class="px-6 py-4 font-medium">Pengguna</th>
                        <th class="px-6 py-4 font-medium">Telepon</th>
                        <th class="px-6 py-4 font-medium">Role</th>
                        <th class="px-6 py-4 font-medium">Tgl Daftar</th>
                        <th class="px-6 py-4 font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $index => $user)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4">{{ $users->firstItem() + $index }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-navy flex-shrink-0 flex items-center justify-center">
                                        <span class="text-white font-bold text-xs">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                    </div>
                                    <div>
                                        <div class="font-medium text-slate-800">{{ $user->name }}</div>
                                        <div class="text-xs text-slate-500">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">{{ $user->phone ?? '-' }}</td>
                            <td class="px-6 py-4">
                                @if($user->role?->slug === 'administrator')
                                    <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-navy text-white">Admin</span>
                                @elseif($user->role?->slug === 'leader')
                                    <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-orange-500 text-white">Ketua Pelaksana</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700">Verifikator</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $user->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4 flex gap-2">
                                <button @click="Swal.fire({ icon: 'warning', title: 'Hapus Pengguna?', text: 'Apakah Anda yakin ingin menghapus pengguna ini?', showCancelButton: true, confirmButtonText: 'Ya, Hapus', cancelButtonText: 'Batal', confirmButtonColor: '#ef4444', cancelButtonColor: '#64748b' }).then(r => { if (r.isConfirmed) $wire.deleteUser({{ $user->id }}); })" class="text-slate-400 hover:text-red-500 p-1 rounded-lg transition" title="Hapus Pengguna">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-slate-500 text-sm">
                                Tidak ada pengguna ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div>
        {{ $users->links() }}
    </div>
</div>
