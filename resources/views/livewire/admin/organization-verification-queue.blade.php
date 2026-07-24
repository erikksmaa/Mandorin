<div>
    <h1 class="text-2xl font-bold text-slate-800 mb-6" style="font-family: 'Big Shoulders Display', sans-serif;">
        Antrian Verifikasi Organisasi
    </h1>

    <div class="mb-6 flex flex-col sm:flex-row gap-4 justify-between items-start sm:items-center">
        <div class="w-full sm:w-96 relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-slate-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" /></svg>
            </div>
            <input wire:model.live.debounce.300ms="search" type="text" class="w-full pl-10 pr-4 py-2 border border-slate-200 rounded-xl focus:ring-orange-500 focus:border-orange-500 text-sm" placeholder="Cari nama organisasi atau kode...">
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
            <button wire:click="$set('filterStatus', '')" class="px-3.5 py-1.5 rounded-full text-xs font-medium whitespace-nowrap {{ $filterStatus === '' ? 'bg-navy text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                Semua
            </button>
            <button wire:click="$set('filterStatus', 'inactive')" class="px-3.5 py-1.5 rounded-full text-xs font-medium whitespace-nowrap {{ $filterStatus === 'inactive' ? 'bg-amber-100 text-amber-800' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                Belum Aktif
            </button>
            <button wire:click="$set('filterStatus', 'active')" class="px-3.5 py-1.5 rounded-full text-xs font-medium whitespace-nowrap {{ $filterStatus === 'active' ? 'bg-green-100 text-green-800' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                Aktif / Terverifikasi
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
        @forelse($organizations as $organization)
            <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-5 flex flex-col h-full">
                <div class="flex items-start gap-4 mb-4">
                    <div class="w-12 h-12 rounded-full bg-slate-100 flex-shrink-0 overflow-hidden border border-slate-200">
                        @if($organization->logo)
                            <img src="{{ asset('storage/' . $organization->logo) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-navy text-white font-bold text-lg">
                                {{ strtoupper(substr($organization->name ?? '?', 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <span class="text-xs font-mono text-slate-400">{{ $organization->organization_code }}</span>
                        <div class="font-bold text-slate-800 truncate">{{ $organization->name ?? '-' }}</div>
                        <div class="text-xs text-orange-600 font-semibold truncate">{{ $organization->category?->name ?? 'Organisasi Kepemudaan' }}</div>
                    </div>
                </div>

                <div class="text-sm text-slate-600 mb-4 flex-1 line-clamp-2">
                    {{ $organization->address ?? 'Alamat belum diisi' }}
                </div>

                <div class="flex items-center justify-between mt-auto pt-4 border-t border-slate-100">
                    <div>
                        @php
                            $statusVal = $organization->status instanceof \BackedEnum ? $organization->status->value : $organization->status;
                        @endphp
                        <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $statusVal === 'active' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">
                            {{ $statusVal === 'active' ? 'Terverifikasi' : 'Belum Aktif' }}
                        </span>
                    </div>
                    <a href="{{ route('admin.verification.show', $organization) }}" class="text-orange-500 hover:text-orange-600 text-sm font-medium">
                        Lihat Detail &rarr;
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white border border-slate-200 rounded-xl shadow-sm p-8 text-center text-sm text-slate-500">
                Belum ada data organisasi yang sesuai dengan filter.
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $organizations->links() }}
    </div>
</div>
