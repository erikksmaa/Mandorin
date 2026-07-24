<div>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800" style="font-family: 'Big Shoulders Display', sans-serif;">
            Selamat datang, {{ auth()->user()->name }}!
        </h1>
        <p class="text-slate-500 text-sm">Pantau dan verifikasi program kepemudaan yang diajukan ke SIPORA.</p>
    </div>

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-8">
        <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-5 border-l-4 border-l-amber-500">
            <h3 class="text-sm font-medium text-slate-500">Proposal Menunggu</h3>
            <p class="text-3xl font-bold font-mono text-slate-800 mt-2">{{ $pendingProposalsCount }}</p>
        </div>
        <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-5 border-l-4 border-l-navy">
            <h3 class="text-sm font-medium text-slate-500">Program Aktif</h3>
            <p class="text-3xl font-bold font-mono text-slate-800 mt-2">{{ $activeProgramsCount }}</p>
        </div>
        <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-5 border-l-4 border-l-orange-500">
            <h3 class="text-sm font-medium text-slate-500">E-LPJ Menunggu</h3>
            <p class="text-3xl font-bold font-mono text-slate-800 mt-2">{{ $pendingElpjCount }}</p>
        </div>
        <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-5 border-l-4 border-l-green-500">
            <h3 class="text-sm font-medium text-slate-500">Program Selesai</h3>
            <p class="text-3xl font-bold font-mono text-slate-800 mt-2">{{ $completedProgramsCount }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Proposal Menunggu Verifikasi -->
        <div>
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-bold text-slate-800" style="font-family: 'Big Shoulders Display', sans-serif;">Proposal Menunggu</h2>
                <a href="{{ route('verifier.proposals.index') }}" class="text-sm text-orange-500 hover:underline">Lihat Semua →</a>
            </div>
            <div class="space-y-3">
                @forelse($recentProposals as $program)
                    <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-4">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <span class="text-xs font-mono text-slate-400">{{ $program->program_code }}</span>
                                <h3 class="font-bold text-slate-800">{{ $program->title }}</h3>
                                <p class="text-xs text-slate-500 mt-1">
                                    🏢 {{ $program->organization?->name ?? '-' }}
                                    · 📂 {{ $program->category?->name ?? '-' }}
                                </p>
                                <p class="text-xs text-slate-400">👤 Ketua: {{ $program->leader?->name ?? '-' }}</p>
                            </div>
                            <a href="{{ route('verifier.proposals.show', $program) }}" class="shrink-0 px-3 py-1.5 bg-orange-50 text-orange-600 hover:bg-orange-100 rounded-lg text-sm font-medium transition">
                                Review
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-6 text-center text-sm text-slate-500">
                        Tidak ada proposal menunggu verifikasi.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- E-LPJ Menunggu -->
        <div>
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-bold text-slate-800" style="font-family: 'Big Shoulders Display', sans-serif;">E-LPJ Menunggu</h2>
                <a href="{{ route('verifier.elpj.index') }}" class="text-sm text-orange-500 hover:underline">Lihat Semua →</a>
            </div>
            <div class="space-y-3">
                @forelse($recentElpjs as $elpj)
                    <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-4">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <span class="text-xs font-mono text-slate-400">{{ $elpj->report_number }}</span>
                                <h3 class="font-bold text-slate-800">{{ $elpj->program?->title ?? 'Program' }}</h3>
                                <p class="text-xs text-slate-500 mt-1">
                                    🏢 {{ $elpj->program?->organization?->name ?? '-' }}
                                </p>
                                <p class="text-xs text-slate-400">
                                    💰 Rp {{ number_format($elpj->total_expense ?? 0, 0, ',', '.') }}
                                </p>
                            </div>
                            <a href="{{ route('verifier.elpj.show', $elpj) }}" class="shrink-0 px-3 py-1.5 bg-blue-50 text-blue-600 hover:bg-blue-100 rounded-lg text-sm font-medium transition">
                                Verifikasi
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-6 text-center text-sm text-slate-500">
                        Tidak ada E-LPJ menunggu verifikasi.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>