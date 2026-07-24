<div>
    <h1 class="text-2xl font-bold text-slate-800 mb-6" style="font-family: 'Big Shoulders Display', sans-serif;">
        Daftar Proposal Program
    </h1>

    <div class="flex flex-wrap items-center gap-3 mb-6">
        <div class="relative flex-grow sm:max-w-xs">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-4 w-4 text-slate-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" /></svg>
            </div>
            <input wire:model.live.debounce.300ms="search" type="text" class="w-full pl-9 pr-4 py-2 text-sm border border-slate-200 rounded-xl focus:ring-navy focus:border-navy" placeholder="Cari judul, kode, organisasi...">
        </div>

        <select wire:model.live="statusFilter" class="px-3 py-2 text-sm border border-slate-200 rounded-xl focus:ring-navy focus:border-navy">
            <option value="all">Semua Proposal</option>
            <option value="Pending">Menunggu</option>
            <option value="Verified">Disetujui</option>
            <option value="Revision">Perlu Revisi</option>
            <option value="Rejected">Ditolak</option>
        </select>

        <select wire:model.live="categoryFilter" class="px-3 py-2 text-sm border border-slate-200 rounded-xl focus:ring-navy focus:border-navy">
            <option value="">Semua Kategori</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
            @endforeach
        </select>

        <select wire:model.live="yearFilter" class="px-3 py-2 text-sm border border-slate-200 rounded-xl focus:ring-navy focus:border-navy">
            <option value="">Semua Tahun</option>
            <option value="2026">2026</option>
            <option value="2025">2025</option>
            <option value="2024">2024</option>
        </select>

        <div class="flex items-center gap-1.5 text-xs text-slate-500 ml-auto">
            <span>Tampilkan:</span>
            <select wire:model.live="perPage" class="border-slate-200 rounded-lg text-xs py-1.5 px-2 focus:ring-navy focus:border-navy">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
            <span>data</span>
        </div>
    </div>

    <!-- Proposal List -->
    <div class="space-y-4">
        @forelse ($proposals as $program)
            <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-5">
                <div class="flex flex-col md:flex-row md:items-center gap-4">
                    <div class="flex-grow">
                        <span class="text-xs font-mono text-slate-400">{{ $program->program_code }}</span>
                        <h3 class="font-bold text-lg text-slate-800">{{ $program->title }}</h3>
                        <div class="flex flex-wrap gap-3 mt-2 text-xs text-slate-500">
                            <span>📂 {{ $program->category?->name ?? '-' }}</span>
                            <span>🏢 {{ $program->organization?->name ?? '-' }}</span>
                            <span>👤 {{ $program->leader?->name ?? '-' }}</span>
                            @if($program->budget)
                                <span>💰 Rp {{ number_format($program->budget, 0, ',', '.') }}</span>
                            @endif
                        </div>
                        <div class="text-xs text-slate-400 mt-1">
                            Diajukan: {{ $program->created_at->format('d M Y, H:i') }}
                        </div>
                    </div>

                    <div class="flex items-center gap-3 shrink-0">
                        @php
                            $proposalMap = [
                                'Pending'  => 'bg-amber-100 text-amber-700',
                                'Verified' => 'bg-green-100 text-green-700',
                                'Revision' => 'bg-blue-100 text-blue-700',
                                'Rejected' => 'bg-red-100 text-red-700',
                            ];
                            $propVal   = $program->proposal_status instanceof \BackedEnum ? $program->proposal_status->value : $program->proposal_status;
                            $propColor = $proposalMap[$propVal] ?? 'bg-slate-100 text-slate-700';
                            $propLabel = $program->proposal_status instanceof \BackedEnum ? $program->proposal_status->label() : ucfirst($propVal);
                        @endphp
                        <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $propColor }}">
                            {{ $propLabel }}
                        </span>
                        <a href="{{ route('verifier.proposals.show', $program) }}" class="px-4 py-2 text-sm border-2 border-orange-500 text-orange-500 hover:bg-orange-50 rounded-xl font-medium transition">
                            Review
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-8 text-center text-sm text-slate-500">
                Tidak ada proposal ditemukan.
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $proposals->links() }}
    </div>
</div>