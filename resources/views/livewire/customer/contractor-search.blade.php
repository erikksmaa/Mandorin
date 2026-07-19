<div>
    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <h1 class="text-2xl font-bold text-slate-800" style="font-family: 'Big Shoulders Display', sans-serif;">
            Cari Kontraktor
        </h1>
        <div class="w-full md:w-1/3">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nama kontraktor..." class="w-full rounded-xl border-slate-300 focus:border-navy focus:ring-navy shadow-sm">
        </div>
    </div>

    {{-- Filter Chips --}}
    <div class="flex flex-wrap gap-2 mb-8">
        <button wire:click="setFilterService(null)" class="px-4 py-1.5 rounded-full text-sm font-medium transition {{ $filterService === null ? 'bg-navy text-white' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
            Semua
        </button>
        @foreach ($services as $service)
            <button wire:click="setFilterService({{ $service->id }})" class="px-4 py-1.5 rounded-full text-sm font-medium transition {{ $filterService === $service->id ? 'bg-navy text-white' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
                {{ $service->name }}
            </button>
        @endforeach
    </div>

    {{-- Card Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($contractors as $contractor)
            <div class="bg-white border border-slate-200 shadow-sm rounded-2xl p-5 flex flex-col hover:shadow-md transition-shadow">
                <div class="flex items-start gap-4 mb-4">
                    <div class="w-16 h-16 rounded-full overflow-hidden bg-slate-100 shrink-0">
                        @if ($contractor->profile_photo)
                            <img src="{{ asset('storage/' . $contractor->profile_photo) }}" alt="{{ $contractor->user->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-navy text-white font-bold text-xl">
                                {{ substr($contractor->user->name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800 text-lg flex items-center gap-2">
                            {{ $contractor->user->name }}
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-medium bg-green-100 text-green-700">Verified</span>
                        </h3>
                        <div class="flex items-center text-sm mt-1">
                            <span class="text-amber-500 mr-1">⭐</span>
                            <span class="font-mono text-slate-800 font-medium">{{ number_format($contractor->rating ?? 0, 1) }}</span>
                            <span class="text-slate-400 ml-1">({{ $contractor->total_reviews ?? 0 }} ulasan)</span>
                        </div>
                        <p class="text-xs text-slate-500 mt-1">{{ $contractor->total_projects ?? 0 }} proyek selesai</p>
                    </div>
                </div>
                
                <div class="mb-4 flex-grow">
                    <div class="flex flex-wrap gap-1 mb-2">
                        @foreach ($contractor->services->take(3) as $svc)
                            <span class="px-2 py-1 bg-slate-100 text-slate-600 text-xs rounded-md">{{ $svc->name }}</span>
                        @endforeach
                        @if($contractor->services->count() > 3)
                            <span class="px-2 py-1 bg-slate-100 text-slate-600 text-xs rounded-md">+{{ $contractor->services->count() - 3 }}</span>
                        @endif
                    </div>
                    <p class="text-sm text-slate-600 line-clamp-2">
                        📍 {{ $contractor->address ?? 'Alamat tidak tersedia' }}
                    </p>
                </div>
                
                <div class="grid grid-cols-2 gap-2 mt-auto">
                    <a href="{{ route('customer.contractors.show', $contractor) }}" class="px-3 py-2 border-2 border-orange-500 text-orange-500 hover:bg-orange-50 text-center rounded-xl font-medium transition text-sm">
                        Lihat Profil
                    </a>
                    <a href="{{ route('customer.hire.create', $contractor) }}" class="px-3 py-2 bg-orange-500 hover:bg-orange-600 text-white text-center rounded-xl font-medium transition text-sm">
                        Sewa Sekarang
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-1 md:col-span-2 lg:col-span-3 bg-white border border-slate-200 shadow-sm rounded-2xl p-8 text-center text-slate-500">
                Tidak ada kontraktor yang ditemukan untuk pencarian atau filter ini.
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $contractors->links() }}
    </div>
</div>
