<div>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800" style="font-family: 'Big Shoulders Display', sans-serif;">
            Selamat datang, {{ auth()->user()->name }}!
        </h1>
        <p class="text-slate-500 text-sm">Kelola proposal dan program kepemudaan Anda di SIPORA.</p>
    </div>

    @if($organization && $organization->status?->value === 'inactive')
        <div class="mb-6 px-4 py-3 bg-amber-100 text-amber-700 rounded-xl border border-amber-200">
            <div class="flex justify-between items-center">
                <span>Organisasi Anda belum diverifikasi. Beberapa fitur mungkin dibatasi sampai profil diverifikasi Admin.</span>
                <a href="{{ route('leader.profile.show') }}" class="text-sm font-medium underline ml-4 whitespace-nowrap">Lihat Profil</a>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-8">
        <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-5 border-l-4 border-l-orange-500">
            <h3 class="text-sm font-medium text-slate-500 mb-1">Total Program</h3>
            <div class="text-3xl font-bold font-mono text-slate-800">{{ $myProgramsCount }}</div>
        </div>
        <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-5 border-l-4 border-l-amber-400">
            <h3 class="text-sm font-medium text-slate-500 mb-1">Disetujui</h3>
            <div class="text-3xl font-bold font-mono text-slate-800">{{ $approvedProgramsCount }}</div>
        </div>
        <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-5 border-l-4 border-l-navy">
            <h3 class="text-sm font-medium text-slate-500 mb-1">Program Aktif</h3>
            <div class="text-3xl font-bold font-mono text-slate-800">{{ $activeProgramsCount }}</div>
        </div>
        <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-5 border-l-4 border-l-green-500">
            <h3 class="text-sm font-medium text-slate-500 mb-1">Selesai</h3>
            <div class="text-3xl font-bold font-mono text-slate-800">{{ $completedProgramsCount }}</div>
        </div>
    </div>

    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-bold text-slate-800" style="font-family: 'Big Shoulders Display', sans-serif;">Program Terbaru</h2>
        <a href="{{ route('leader.programs.create') }}" class="px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white text-sm font-semibold rounded-xl transition">
            + Ajukan Program
        </a>
    </div>

    <div class="space-y-4">
        @forelse($recentPrograms as $program)
            <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-5">
                <div class="flex flex-col md:flex-row md:items-center gap-4 justify-between">
                    <div class="flex-grow">
                        <span class="text-xs font-mono text-slate-400">{{ $program->program_code }}</span>
                        <h3 class="font-bold text-slate-800 text-lg">{{ $program->title }}</h3>
                        <div class="text-sm text-slate-500 mt-1">
                            <span>📂 {{ $program->category?->name ?? '-' }}</span>
                            <span class="mx-2">·</span>
                            <span>🏢 {{ $program->organization?->name ?? '-' }}</span>
                        </div>
                        <div class="text-xs text-slate-400 mt-1">
                            📅 {{ $program->start_date?->format('d M Y') ?? 'Belum ditentukan' }}
                            @if($program->end_date) – {{ $program->end_date->format('d M Y') }} @endif
                        </div>
                    </div>
                    <div class="flex items-center gap-3 shrink-0">
                        @php
                            $statusMap = [
                                'Draft'     => 'bg-slate-100 text-slate-700',
                                'Submitted' => 'bg-amber-100 text-amber-700',
                                'Approved'  => 'bg-blue-100 text-blue-700',
                                'Running'   => 'bg-indigo-100 text-indigo-700',
                                'Completed' => 'bg-green-100 text-green-700',
                                'Cancelled' => 'bg-red-100 text-red-700',
                            ];
                            $statusVal   = $program->status instanceof \BackedEnum ? $program->status->value : $program->status;
                            $statusColor = $statusMap[$statusVal] ?? 'bg-slate-100 text-slate-700';
                            $statusLabel = $program->status instanceof \BackedEnum ? $program->status->label() : ucfirst($statusVal);
                        @endphp
                        <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $statusColor }}">
                            {{ $statusLabel }}
                        </span>
                        <a href="{{ route('leader.programs.show', $program) }}" class="px-4 py-2 text-sm border-2 border-orange-500 text-orange-500 hover:bg-orange-50 rounded-xl font-medium transition">
                            Detail
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-8 text-center text-sm text-slate-500">
                Belum ada program. Klik <strong>+ Ajukan Program</strong> untuk memulai.
            </div>
        @endforelse
    </div>
</div>
