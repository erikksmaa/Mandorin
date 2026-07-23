<div>
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 gap-4">
        <h2 class="text-xl font-bold text-slate-800" style="font-family: 'Big Shoulders Display', sans-serif;">
            Tim Pekerja
        </h2>
        <div class="flex items-center gap-3 w-full sm:w-auto">
            <div class="relative w-full sm:w-64">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-slate-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" /></svg>
                </div>
                <input wire:model.live.debounce.300ms="search" type="text" class="w-full pl-9 pr-4 py-2 border border-slate-200 rounded-xl text-sm focus:ring-orange-500 focus:border-orange-500" placeholder="Cari nama atau peran...">
            </div>
            <a href="{{ route('contractor.workers.form', $project) }}" class="px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-xl font-medium transition text-sm flex-shrink-0">
                + Tambah
            </a>
        </div>
    </div>

    @if($workers->isEmpty())
        <div class="bg-white border border-slate-200 shadow-sm rounded-xl">
            <x-empty-state
                icon="worker"
                title="Belum ada pekerja"
                description="Tambahkan anggota tim untuk proyek ini agar pengelolaan lebih mudah."
            />
        </div>
    @else
        <div class="bg-white border border-slate-200 shadow-sm rounded-xl overflow-hidden mb-6">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50 text-slate-600 border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-3 font-medium">No</th>
                            <th class="px-6 py-3 font-medium">Nama</th>
                            <th class="px-6 py-3 font-medium">No. HP</th>
                            <th class="px-6 py-3 font-medium">Peran</th>
                            <th class="px-6 py-3 font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($workers as $index => $worker)
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4 text-slate-500">{{ $workers->firstItem() + $index }}</td>
                            <td class="px-6 py-4 font-medium text-slate-800">{{ $worker->name }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $worker->phone ?? '-' }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 rounded-md text-xs font-medium bg-slate-100 text-slate-700">
                                    {{ $worker->role }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <a href="{{ route('contractor.workers.form', ['project' => $project, 'worker' => $worker]) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                        Edit
                                    </a>
                                    <button @click="Swal.fire({ icon: 'warning', title: 'Hapus Pekerja?', text: 'Yakin ingin menghapus pekerja ini dari tim?', showCancelButton: true, confirmButtonText: 'Ya, Hapus', cancelButtonText: 'Batal', confirmButtonColor: '#ef4444', cancelButtonColor: '#64748b' }).then(r => { if (r.isConfirmed) $wire.deleteWorker({{ $worker->id }}); })" class="text-red-600 hover:text-red-800 text-sm font-medium">
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
        <div>
            {{ $workers->links() }}
        </div>
    @endif
</div>
