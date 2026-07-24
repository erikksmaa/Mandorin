<div>
    <h1 class="text-2xl font-bold text-slate-800 mb-6" style="font-family: 'Big Shoulders Display', sans-serif;">
        Kelola Program
    </h1>

    <div class="flex flex-col sm:flex-row gap-3 mb-6">
        <div class="relative flex-grow sm:max-w-xs">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-4 w-4 text-slate-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" /></svg>
            </div>
            <input wire:model.live.debounce.300ms="search" type="text" class="w-full pl-9 pr-4 py-2 text-sm border border-slate-200 rounded-xl focus:ring-navy focus:border-navy" placeholder="Cari judul atau kode program...">
        </div>
        <a href="{{ route('leader.programs.create') }}" class="px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white text-sm font-semibold rounded-xl transition whitespace-nowrap">
            + Ajukan Program Baru
        </a>
    </div>

    <!-- Program List -->
    <div class="space-y-4">
        @forelse ($programs as $program)
            <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-5">
                <div class="flex flex-col md:flex-row md:items-center gap-4">
                    <div class="flex-grow">
                        <span class="text-xs font-mono text-slate-400">{{ $program->program_code }}</span>
                        <h3 class="font-bold text-lg text-slate-800">{{ $program->title }}</h3>
                        <div class="flex flex-wrap gap-3 mt-2 text-xs text-slate-500">
                            <span>📂 {{ $program->category?->name ?? '-' }}</span>
                            <span>🏢 {{ $program->organization?->name ?? '-' }}</span>
                            @if($program->start_date)
                                <span>📅 {{ $program->start_date->format('d M Y') }}
                                    @if($program->end_date) – {{ $program->end_date->format('d M Y') }} @endif
                                </span>
                            @endif
                        </div>
                        <div class="flex items-center gap-2 mt-3 pt-3 border-t border-slate-100">
                            @php
                                $logbookCount = $program->activityLogs()->count();
                                $logbookApproved = $program->activityLogs()->where('status', 'Approved')->count();
                                $lpjStatus = $program->financialReport ? ($program->financialReport->status instanceof \BackedEnum ? $program->financialReport->status->value : $program->financialReport->status) : 'Belum Ada';
                            @endphp
                            <div class="text-[11px] font-medium px-2 py-1 bg-slate-50 border border-slate-200 rounded text-slate-600 flex items-center gap-1">
                                <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                Logbook: {{ $logbookApproved }}/{{ $logbookCount }} Disetujui
                            </div>
                            <div class="text-[11px] font-medium px-2 py-1 {{ $lpjStatus === 'Approved' ? 'bg-green-50 text-green-700 border-green-200' : ($lpjStatus === 'Submitted' ? 'bg-blue-50 text-blue-700 border-blue-200' : 'bg-slate-50 text-slate-600 border-slate-200') }} border rounded flex items-center gap-1">
                                <svg class="w-3 h-3 {{ $lpjStatus === 'Approved' ? 'text-green-500' : ($lpjStatus === 'Submitted' ? 'text-blue-500' : 'text-slate-400') }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                E-LPJ: {{ $lpjStatus }}
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row items-center gap-3 shrink-0">
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
                        <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $statusColor }}">
                            {{ $statusLabel }}
                        </span>
                        @php
                            $propStatus = $program->proposal_status instanceof \BackedEnum ? $program->proposal_status->value : $program->proposal_status;
                        @endphp
                        @if($statusVal === 'Draft' || $propStatus === 'Revision')
                            <a href="{{ route('leader.programs.edit', $program) }}" class="px-4 py-2 text-sm border-2 border-orange-500 text-orange-500 hover:bg-orange-50 rounded-xl font-medium transition whitespace-nowrap">
                                Lanjutkan Pengajuan
                            </a>
                        @else
                            <a href="{{ route('leader.programs.show', $program) }}" class="px-4 py-2 text-sm border-2 border-orange-500 text-orange-500 hover:bg-orange-50 rounded-xl font-medium transition whitespace-nowrap">
                                Kelola
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-8 text-center text-sm text-slate-500">
                Belum ada program. Klik <strong>+ Ajukan Program Baru</strong> untuk memulai.
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $programs->links() }}
    </div>
</div>
