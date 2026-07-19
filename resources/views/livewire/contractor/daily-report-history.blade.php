<div class="mt-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-slate-800" style="font-family: 'Big Shoulders Display', sans-serif;">
            Riwayat Laporan Harian
        </h2>
        <a href="{{ route('contractor.reports.create', $project->id) }}" class="px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-xl text-sm font-medium transition">
            Tambah Laporan
        </a>
    </div>

    @if($reports->isEmpty())
        <div class="bg-slate-50 border border-slate-200 border-dashed rounded-2xl p-8 text-center">
            <p class="text-slate-500 mb-4">Belum ada laporan harian untuk proyek ini.</p>
        </div>
    @else
        <div class="relative">
            <div class="absolute left-4 top-0 bottom-0 border-l-2 border-dashed border-slate-200"></div>
            
            @foreach($reports as $report)
                <div class="relative mb-6 last:mb-0">
                    <div class="flex gap-4 relative">
                        <!-- Dot -->
                        <div class="w-9 h-9 rounded-full bg-navy text-white flex-shrink-0 flex items-center justify-center z-10 text-xs font-mono shadow-sm">
                            {{ date('d', strtotime($report->date)) }}
                        </div>
                        
                        <!-- Content card -->
                        <div class="flex-grow bg-white border border-slate-200 shadow-sm rounded-2xl p-5">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <div class="font-mono text-sm text-slate-500">{{ date('d M Y', strtotime($report->date)) }}</div>
                                    <div class="text-xs text-slate-400 mt-1">Oleh: {{ $report->creator->name ?? 'Sistem' }}</div>
                                </div>
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-navy/10 text-navy">
                                    Progress: {{ $report->progress_percentage }}%
                                </span>
                            </div>
                            
                            <p class="text-slate-700 text-sm mb-4 whitespace-pre-line">{{ $report->notes }}</p>
                            
                            @if($report->before_photo || $report->after_photo)
                                <div class="flex flex-wrap gap-4 mt-4">
                                    @if($report->before_photo)
                                        <div>
                                            <div class="text-xs text-slate-500 mb-1">Sebelum:</div>
                                            <img src="{{ asset('storage/' . $report->before_photo) }}" class="h-24 w-auto object-cover rounded-lg border border-slate-200" alt="Sebelum">
                                        </div>
                                    @endif
                                    
                                    @if($report->after_photo)
                                        <div>
                                            <div class="text-xs text-slate-500 mb-1">Sesudah:</div>
                                            <img src="{{ asset('storage/' . $report->after_photo) }}" class="h-24 w-auto object-cover rounded-lg border border-slate-200" alt="Sesudah">
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
