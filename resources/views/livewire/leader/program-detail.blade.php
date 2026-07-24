<div>
    <div class="mb-4">
        <a href="{{ route('leader.programs.index') }}" class="text-sm font-medium text-slate-500 hover:text-slate-800 inline-flex items-center gap-1">
            &larr; Kembali ke Daftar Program
        </a>
    </div>

    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-4">
        <div>
            <span class="text-xs font-mono text-slate-400">{{ $program->program_code }}</span>
            <h1 class="text-2xl font-bold text-slate-800" style="font-family: 'Big Shoulders Display', sans-serif;">
                {{ $program->title }}
            </h1>
        </div>
        <div class="flex flex-col items-end gap-2">
            <span class="px-3 py-1 rounded-full text-xs font-semibold 
                {{ $program->proposal_status instanceof \BackedEnum ? ($program->proposal_status->value === 'Approved' ? 'bg-green-100 text-green-700' : ($program->proposal_status->value === 'Rejected' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700')) : ($program->proposal_status === 'Approved' ? 'bg-green-100 text-green-700' : ($program->proposal_status === 'Rejected' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700')) }}">
                Proposal: {{ $program->proposal_status instanceof \BackedEnum ? $program->proposal_status->value : $program->proposal_status }}
            </span>
        </div>
    </div>

    <!-- Progress Pelaksanaan & Timeline Administrasi -->
    <div class="bg-white border border-slate-200 shadow-sm rounded-2xl p-6 mb-6">
        <div class="flex items-center justify-between mb-3">
            <h3 class="font-bold text-slate-800 text-base">Progress Pelaksanaan</h3>
            <span class="text-2xl font-black text-navy">{{ $program->progress }}%</span>
        </div>
        
        <!-- Progress Bar -->
        <div class="w-full bg-slate-100 rounded-full h-3 mb-6">
            <div class="bg-navy h-3 rounded-full transition-all duration-500" style="width: {{ $program->progress }}%"></div>
        </div>

        <!-- Status Administrasi & Process Timeline -->
        <div class="pt-4 border-t border-slate-100">
            <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Status Administrasi & Timeline Proses</h4>
            <div class="grid grid-cols-2 sm:grid-cols-5 gap-3">
                @php
                    $propVal = $program->proposal_status instanceof \BackedEnum ? $program->proposal_status->value : $program->proposal_status;
                    $statusVal = $program->status instanceof \BackedEnum ? $program->status->value : $program->status;
                    $lpjVal = $program->financialReport ? ($program->financialReport->status instanceof \BackedEnum ? $program->financialReport->status->value : $program->financialReport->status) : null;
                    $latestLog = $program->activityLogs()->orderBy('activity_date', 'desc')->orderBy('id', 'desc')->first();
                    $logProgress = $latestLog ? (int) $latestLog->progress_percentage : 0;

                    $isPropOk = in_array($propVal, ['Verified', 'Approved']);
                    $isLogbookOk = $program->activityLogs()->exists();
                    $isRunningOk = in_array($statusVal, ['Running', 'Completed', 'Approved']) || $isPropOk || $isLogbookOk;
                    $isLpjOk = in_array($lpjVal, ['Submitted', 'Approved']);
                    $isFinalOk = ($statusVal === 'Completed' && $isPropOk && $isLpjOk && $logProgress >= 90 && $lpjVal === 'Approved');
                @endphp

                <!-- Step 1: Proposal -->
                <div class="p-3 rounded-xl border text-xs text-center {{ $isPropOk ? 'bg-green-50 border-green-200 text-green-800' : 'bg-slate-50 border-slate-200 text-slate-500' }}">
                    <span class="text-base block mb-1">{{ $isPropOk ? '✓' : '⏳' }}</span>
                    <span class="font-bold block">Proposal</span>
                    <span class="text-[10px] opacity-75">{{ $isPropOk ? 'Terverifikasi' : 'Pengajuan' }}</span>
                </div>

                <!-- Step 2: Program Berjalan -->
                <div class="p-3 rounded-xl border text-xs text-center {{ $isRunningOk ? 'bg-green-50 border-green-200 text-green-800' : 'bg-slate-50 border-slate-200 text-slate-500' }}">
                    <span class="text-base block mb-1">{{ $isRunningOk ? '✓' : '⏳' }}</span>
                    <span class="font-bold block">Program Berjalan</span>
                    <span class="text-[10px] opacity-75">{{ $isRunningOk ? 'Aktif (30%)' : 'Belum Berjalan' }}</span>
                </div>

                <!-- Step 3: Logbook -->
                <div class="p-3 rounded-xl border text-xs text-center {{ $isLogbookOk ? 'bg-green-50 border-green-200 text-green-800' : 'bg-slate-50 border-slate-200 text-slate-500' }}">
                    <span class="text-base block mb-1">{{ $isLogbookOk ? '✓' : '⏳' }}</span>
                    <span class="font-bold block">Logbook</span>
                    <span class="text-[10px] opacity-75">{{ $isLogbookOk ? ($logProgress . '% Terisi') : 'Belum Ada Log' }}</span>
                </div>

                <!-- Step 4: E-LPJ -->
                <div class="p-3 rounded-xl border text-xs text-center {{ $isLpjOk ? 'bg-green-50 border-green-200 text-green-800' : 'bg-slate-50 border-slate-200 text-slate-500' }}">
                    <span class="text-base block mb-1">{{ $isLpjOk ? '✓' : '⏳' }}</span>
                    <span class="font-bold block">E-LPJ</span>
                    <span class="text-[10px] opacity-75">{{ $isLpjOk ? ($lpjVal === 'Approved' ? 'Disetujui' : 'Submitted (95%)') : 'Belum LPJ' }}</span>
                </div>

                <!-- Step 5: Verifikasi Akhir -->
                <div class="p-3 rounded-xl border text-xs text-center {{ $isFinalOk ? 'bg-green-50 border-green-200 text-green-800' : 'bg-slate-50 border-slate-200 text-slate-500' }}">
                    <span class="text-base block mb-1">{{ $isFinalOk ? '✓' : '⏳' }}</span>
                    <span class="font-bold block">Verifikasi Akhir</span>
                    <span class="text-[10px] opacity-75">{{ $isFinalOk ? 'Selesai (100%)' : 'Menunggu Syarat' }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white border border-slate-200 shadow-sm rounded-2xl p-6 space-y-4">
                <h3 class="font-bold text-slate-800 border-b border-slate-100 pb-2">Deskripsi & Tujuan Program</h3>
                <div>
                    <div class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Gambaran Umum</div>
                    <p class="text-slate-700 text-sm leading-relaxed whitespace-pre-line">{{ $program->description }}</p>
                </div>
                @if($program->objective)
                    <div>
                        <div class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Tujuan Program</div>
                        <p class="text-slate-700 text-sm leading-relaxed">{{ $program->objective }}</p>
                    </div>
                @endif
                @if($program->target)
                    <div>
                        <div class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Target Peserta</div>
                        <p class="text-slate-700 text-sm leading-relaxed">{{ $program->target }}</p>
                    </div>
                @endif
            </div>

            <!-- Daftar Logbook Kegiatan -->
            <div class="bg-white border border-slate-200 shadow-sm rounded-2xl p-6">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3 mb-4">
                    <h3 class="font-bold text-slate-800">Logbook Kegiatan Program</h3>
                    <a href="{{ route('leader.logbook.create', $program->id) }}" class="text-xs font-semibold text-navy hover:underline">+ Tambah Logbook</a>
                </div>
                @if($program->activityLogs && $program->activityLogs->isNotEmpty())
                    <div class="space-y-3">
                        @foreach($program->activityLogs as $log)
                            @php
                                $logDetailRoute = auth()->user()?->role?->slug === 'verifier' || auth()->user()?->role?->slug === 'verifikator'
                                    ? route('verifier.logbook.show', $log->id)
                                    : route('leader.logbook.show', $log->id);
                            @endphp
                            <a href="{{ $logDetailRoute }}" class="block p-4 bg-slate-50 hover:bg-slate-100 border border-slate-200 rounded-xl transition group">
                                <div class="flex justify-between items-start mb-1">
                                    <div>
                                        <h4 class="font-bold text-slate-800 text-sm group-hover:text-navy transition">{{ $log->title }}</h4>
                                        <span class="text-xs text-slate-400 font-mono">{{ $log->activity_date ? $log->activity_date->format('d M Y') : '-' }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-navy/10 text-navy">
                                            {{ $log->progress_percentage }}%
                                        </span>
                                        <span class="text-xs text-navy group-hover:translate-x-0.5 transition">&rarr;</span>
                                    </div>
                                </div>
                                <p class="text-xs text-slate-600 line-clamp-2">{{ $log->description }}</p>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="p-6 bg-slate-50 border border-dashed border-slate-200 rounded-xl text-center text-slate-500 text-sm">
                        Belum ada logbook kegiatan yang diisi.
                    </div>
                @endif
            </div>

            <div class="bg-white border border-slate-200 shadow-sm rounded-2xl p-6">
                <h3 class="font-bold text-slate-800 border-b border-slate-100 pb-3 mb-4">E-LPJ & Laporan Pertanggungjawaban</h3>
                @if($program->financialReport)
                    <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl flex items-center justify-between">
                        <div>
                            <div class="font-semibold text-slate-800 text-sm">Status E-LPJ: {{ $program->financialReport->status }}</div>
                            <div class="text-xs text-slate-500">Total Pengeluaran: Rp {{ number_format($program->financialReport->total_expense ?? $program->financialReport->items()->sum('amount') ?? 0, 0, ',', '.') }}</div>
                        </div>
                        <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                            {{ $program->financialReport->status }}
                        </span>
                    </div>
                @else
                    <div class="p-6 bg-slate-50 border border-dashed border-slate-200 rounded-xl text-center text-slate-500 text-sm">
                        E-LPJ belum dibuat untuk program ini.
                    </div>
                @endif
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white border border-slate-200 shadow-sm rounded-2xl p-6 space-y-4">
                <h3 class="font-bold text-slate-800 border-b border-slate-100 pb-2">Aksi Pelaksanaan</h3>
                <div class="space-y-3">
                    <a href="{{ route('leader.members.index') }}" class="flex items-center justify-between p-3 rounded-xl border border-slate-200 hover:border-navy hover:bg-slate-50 transition group">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-orange-100 flex items-center justify-center text-orange-600 group-hover:bg-navy group-hover:text-white transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <div class="text-left">
                                <p class="text-sm font-semibold text-slate-800">Anggota Organisasi</p>
                                <p class="text-xs text-slate-500">Kelola tim untuk program Anda</p>
                            </div>
                        </div>
                        <svg class="w-4 h-4 text-slate-400 group-hover:text-navy transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>

                    <a href="{{ route('leader.attendance.index', $program->id) }}" class="flex items-center justify-between p-3 rounded-xl border border-slate-200 hover:border-navy hover:bg-slate-50 transition group">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-green-50 text-green-600 flex items-center justify-center group-hover:bg-navy group-hover:text-white transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <span class="block text-sm font-bold text-slate-700">Presensi</span>
                                <span class="block text-xs text-slate-500">Catat kehadiran kegiatan</span>
                            </div>
                        </div>
                        <svg class="w-5 h-5 text-slate-400 group-hover:text-navy" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>

                    <a href="{{ route('leader.logbook.create', $program->id) }}" class="flex items-center justify-between p-3 rounded-xl border border-slate-200 hover:border-navy hover:bg-slate-50 transition group">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center group-hover:bg-navy group-hover:text-white transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <span class="block text-sm font-bold text-slate-700">Logbook</span>
                                <span class="block text-xs text-slate-500">Upload foto & dokumentasi</span>
                            </div>
                        </div>
                        <svg class="w-5 h-5 text-slate-400 group-hover:text-navy" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>

                    <a href="{{ route('leader.elpj.form', $program->id) }}" class="flex items-center justify-between p-3 rounded-xl border border-slate-200 hover:border-navy hover:bg-slate-50 transition group">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center group-hover:bg-navy group-hover:text-white transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <span class="block text-sm font-bold text-slate-700">E-LPJ</span>
                                <span class="block text-xs text-slate-500">Laporan pertanggungjawaban</span>
                            </div>
                        </div>
                        <svg class="w-5 h-5 text-slate-400 group-hover:text-navy" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>
            </div>

            <div class="bg-white border border-slate-200 shadow-sm rounded-2xl p-6 space-y-4 text-sm">
                <h3 class="font-bold text-slate-800 border-b border-slate-100 pb-2">Informasi Rincian</h3>
                <div>
                    <span class="text-xs text-slate-400 block">Kategori</span>
                    <span class="font-semibold text-slate-800">{{ $program->category?->name ?? 'Program Kepemudaan' }}</span>
                </div>
                <div>
                    <span class="text-xs text-slate-400 block">Organisasi Pelaksana</span>
                    <span class="font-semibold text-slate-800">{{ $program->organization?->name ?? '-' }}</span>
                </div>
                <div>
                    <span class="text-xs text-slate-400 block">Anggaran Disetujui</span>
                    <span class="font-bold text-navy text-base">Rp {{ number_format($program->approved_budget ?? $program->budget ?? 0, 0, ',', '.') }}</span>
                </div>
                <div>
                    <span class="text-xs text-slate-400 block">Lokasi</span>
                    <span class="font-medium text-slate-700">{{ $program->location ?? '-' }}</span>
                </div>
                <div>
                    <span class="text-xs text-slate-400 block">Periode Pelaksanaan</span>
                    <span class="font-mono text-xs text-slate-700">
                        {{ $program->start_date ? $program->start_date->format('d M Y') : '-' }} s/d {{ $program->end_date ? $program->end_date->format('d M Y') : '-' }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
