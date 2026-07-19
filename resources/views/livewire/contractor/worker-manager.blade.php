<div>
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold text-slate-800" style="font-family: 'Big Shoulders Display', sans-serif;">
            Tim Pekerja
        </h2>
        <a href="{{ route('contractor.workers.form', $project) }}" class="px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-xl font-medium transition text-sm">
            Tambah Pekerja
        </a>
    </div>

    @if($workers->isEmpty())
        <div class="bg-white border border-slate-200 shadow-sm rounded-2xl p-8 text-center">
            <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <h3 class="text-lg font-medium text-slate-800 mb-1">Belum Ada Pekerja</h3>
            <p class="text-sm text-slate-500 mb-4">Tambahkan anggota tim untuk proyek ini.</p>
        </div>
    @else
        <div class="bg-white border border-slate-200 shadow-sm rounded-2xl overflow-hidden">
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
                            <td class="px-6 py-4 text-slate-500">{{ $index + 1 }}</td>
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
                                    <button wire:click="deleteWorker({{ $worker->id }})" wire:confirm="Yakin ingin menghapus pekerja ini?" class="text-red-600 hover:text-red-800 text-sm font-medium">
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
    @endif
</div>
