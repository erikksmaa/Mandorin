<div>
    <h1 class="text-2xl font-bold text-slate-800 mb-6" style="font-family: 'Big Shoulders Display', sans-serif;">
        Antrian Verifikasi
    </h1>

    <div class="mb-6 flex flex-col sm:flex-row gap-4 justify-between items-start sm:items-center">
        <div class="w-full sm:w-96 relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-slate-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" /></svg>
            </div>
            <input wire:model.live.debounce.300ms="search" type="text" class="w-full pl-10 pr-4 py-2 border border-slate-200 rounded-xl focus:ring-orange-500 focus:border-orange-500" placeholder="Cari nama atau email...">
        </div>

        <div class="flex gap-2 overflow-x-auto pb-2 sm:pb-0 w-full sm:w-auto">
            <button wire:click="$set('filterStatus', '')" class="px-4 py-1.5 rounded-full text-sm font-medium whitespace-nowrap {{ $filterStatus === '' ? 'bg-navy text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                Semua
            </button>
            <button wire:click="$set('filterStatus', 'pending')" class="px-4 py-1.5 rounded-full text-sm font-medium whitespace-nowrap {{ $filterStatus === 'pending' ? 'bg-amber-100 text-amber-800' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                Menunggu
            </button>
            <button wire:click="$set('filterStatus', 'verified')" class="px-4 py-1.5 rounded-full text-sm font-medium whitespace-nowrap {{ $filterStatus === 'verified' ? 'bg-green-100 text-green-800' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                Terverifikasi
            </button>
            <button wire:click="$set('filterStatus', 'rejected')" class="px-4 py-1.5 rounded-full text-sm font-medium whitespace-nowrap {{ $filterStatus === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                Ditolak
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
        @forelse($contractors as $contractor)
            <div class="bg-white border border-slate-200 shadow-sm rounded-2xl p-5 flex flex-col h-full">
                <div class="flex items-start gap-4 mb-4">
                    <div class="w-12 h-12 rounded-full bg-slate-100 flex-shrink-0 overflow-hidden">
                        @if($contractor->user->profile_photo_path)
                            <img src="{{ asset('storage/' . $contractor->user->profile_photo_path) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-500 font-bold text-lg">
                                {{ substr($contractor->user->name ?? '?', 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="font-bold text-slate-800 truncate">{{ $contractor->user->name ?? '-' }}</div>
                        <div class="text-sm text-slate-500 truncate">{{ $contractor->user->email ?? '-' }}</div>
                    </div>
                </div>

                <div class="text-sm text-slate-600 mb-4 flex-1 line-clamp-2">
                    {{ $contractor->address ?? 'Alamat belum diisi' }}
                </div>

                <div class="flex flex-wrap gap-1.5 mb-4">
                    @forelse($contractor->services as $service)
                        <span class="px-2 py-0.5 bg-slate-100 text-slate-600 rounded-full text-xs">
                            {{ $service->name }}
                        </span>
                    @empty
                        <span class="text-xs text-slate-400">Tidak ada layanan</span>
                    @endforelse
                </div>

                <div class="flex items-center justify-between mt-auto pt-4 border-t border-slate-100">
                    <div>
                        <span class="px-2.5 py-1 rounded-full text-xs font-medium 
                            @if($contractor->verification_status === 'verified' || $contractor->verification_status?->value === 'verified') bg-green-100 text-green-700
                            @elseif($contractor->verification_status === 'pending' || $contractor->verification_status?->value === 'pending') bg-amber-100 text-amber-700
                            @elseif($contractor->verification_status === 'rejected' || $contractor->verification_status?->value === 'rejected') bg-red-100 text-red-700
                            @else bg-slate-100 text-slate-700 @endif">
                            {{ is_object($contractor->verification_status) && method_exists($contractor->verification_status, 'label') ? $contractor->verification_status->label() : ucfirst($contractor->verification_status ?? 'Unknown') }}
                        </span>
                    </div>
                    <a href="{{ route('admin.verification.show', $contractor) }}" class="text-orange-500 hover:text-orange-600 text-sm font-medium">
                        Lihat Detail &rarr;
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full py-12 text-center bg-white border border-slate-200 rounded-2xl shadow-sm">
                <svg class="mx-auto h-12 w-12 text-slate-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                </svg>
                <div class="text-slate-500">Tidak ada data kontraktor yang ditemukan.</div>
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $contractors->links() }}
    </div>
</div>
