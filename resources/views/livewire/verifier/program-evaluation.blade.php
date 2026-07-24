<div>
    <div class="mb-4">
        <a href="{{ route('verifier.proposals.index') }}" class="text-sm font-medium text-slate-500 hover:text-slate-800 inline-flex items-center gap-1">
            &larr; Kembali ke Daftar Proposal
        </a>
    </div>

    <div class="flex items-center justify-between mb-6">
        <div>
            <span class="text-xs font-mono text-slate-400">{{ $program->program_code }}</span>
            <h1 class="text-2xl font-bold text-slate-800" style="font-family: 'Big Shoulders Display', sans-serif;">
                Evaluasi Program: {{ $program->title }}
            </h1>
        </div>
        @php
            $st = $program->status instanceof \BackedEnum ? $program->status->value : $program->status;
        @endphp
        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $st === 'Completed' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
            Status: {{ $st }}
        </span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white border border-slate-200 shadow-sm rounded-2xl p-6">
                <h3 class="font-bold text-slate-800 border-b border-slate-100 pb-2 mb-4">Detail Pengajuan & Hasil Evaluasi</h3>
                <div class="space-y-4 text-sm">
                    <div>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Organisasi Pelaksana</span>
                        <p class="font-semibold text-slate-800">{{ $program->organization?->name ?? '-' }}</p>
                    </div>
                    <div>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Ketua Pelaksana</span>
                        <p class="font-medium text-slate-800">{{ $program->leader?->name ?? '-' }}</p>
                    </div>
                    <div>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Deskripsi Kegiatan</span>
                        <p class="text-slate-700 leading-relaxed whitespace-pre-line">{{ $program->description }}</p>
                    </div>
                    <div>
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">Tujuan & Target</span>
                        <p class="text-slate-700 leading-relaxed">{{ $program->objective }} | Target: {{ $program->target }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white border border-slate-200 shadow-sm rounded-2xl p-6">
                <div class="flex items-center justify-between border-b border-slate-100 pb-2 mb-4">
                    <h3 class="font-bold text-slate-800">Status Pertanggungjawaban E-LPJ</h3>
                    <a href="{{ route('verifier.elpj.index') }}" class="text-xs font-semibold text-navy hover:text-orange-500 transition">
                        Cek & Verifikasi E-LPJ &rarr;
                    </a>
                </div>
                @if($program->financialReport)
                    <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl flex items-center justify-between">
                        <div>
                            <div class="font-semibold text-slate-800 text-sm">No. LPJ: {{ $program->financialReport->report_number }}</div>
                            <div class="text-xs text-slate-500">Total Pengeluaran: Rp {{ number_format($program->financialReport->total_expense ?? $program->financialReport->items()->sum('amount') ?? 0, 0, ',', '.') }}</div>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                            {{ $program->financialReport->status }}
                        </span>
                    </div>
                @else
                    <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl text-slate-500 text-xs text-center">
                        E-LPJ belum diajukan oleh organisasi.
                    </div>
                @endif
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white border border-slate-200 shadow-sm rounded-2xl p-6 space-y-4">
                <h3 class="font-bold text-slate-800 border-b border-slate-100 pb-2">Aksi Verifikator</h3>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Tandai program ini sebagai selesai secara resmi setelah melalui proses evaluasi lapangan & pertanggungjawaban.
                </p>
                <button
                    @click="Swal.fire({ icon: 'question', title: 'Selesaikan & Evaluasi?', text: 'Apakah Anda yakin ingin menyatakan program ini Selesai & Ter-evaluasi?', showCancelButton: true, confirmButtonText: '✓ Ya, Evaluasi Selesai', cancelButtonText: 'Batal', confirmButtonColor: '#059669', cancelButtonColor: '#64748b' }).then(r => { if (r.isConfirmed) { $wire.completeProgram(); } })"
                    class="w-full py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-sm font-semibold transition shadow-sm">
                    ✓ Selesaikan Evaluasi Program
                </button>
            </div>
        </div>
    </div>

    <!-- Review Logbook -->
    <div class="bg-white border border-slate-200 shadow-sm rounded-2xl p-6 mt-8">
        <h3 class="font-bold text-slate-800 border-b border-slate-100 pb-2 mb-6 text-lg">Review Logbook & Dokumentasi Harian</h3>
        
        @if($program->activityLogs->isEmpty())
            <div class="text-center py-8 text-slate-500 text-sm">
                Belum ada logbook yang disubmit oleh ketua pelaksana.
            </div>
        @else
            <div class="space-y-8 relative before:absolute before:inset-0 before:ml-5 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-slate-200 before:to-transparent">
                @foreach($program->activityLogs as $log)
                <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                    <!-- Icon -->
                    <div class="flex items-center justify-center w-10 h-10 rounded-full border border-white bg-slate-100 text-slate-500 shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 z-10">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <!-- Card -->
                    <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] p-4 rounded-xl border border-slate-200 bg-white shadow-sm hover:shadow-md transition">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-semibold text-navy">{{ $log->activity_date?->format('d M Y') ?? '-' }}</span>
                            <span class="px-2 py-0.5 text-[10px] font-bold rounded-md bg-slate-100 text-slate-600">{{ $log->status }}</span>
                        </div>
                        <h4 class="font-bold text-slate-800 text-sm mb-1">{{ $log->title }}</h4>
                        <p class="text-xs text-slate-600 mb-3 line-clamp-2">{{ $log->description }}</p>
                        
                        @if($log->photos && $log->photos->count() > 0)
                        <div class="flex gap-2 overflow-x-auto pb-2 mb-3">
                            @foreach($log->photos as $photo)
                                <img src="{{ asset('storage/' . $photo->photo) }}" class="h-16 w-16 object-cover rounded border border-slate-200 shrink-0">
                            @endforeach
                        </div>
                        @endif

                        <div class="flex items-center gap-2 pt-3 border-t border-slate-100">
                            @if($log->status->value === 'Submitted')
                                <button @click="Swal.fire({ title: 'Setujui Logbook?', icon: 'question', showCancelButton: true, confirmButtonText: 'Setujui', cancelButtonText: 'Batal' }).then(r => { if(r.isConfirmed) $wire.approveLogbook({{ $log->id }}) })" class="px-3 py-1.5 bg-green-500 hover:bg-green-600 text-white text-xs font-medium rounded-lg transition">Setujui</button>
                                <button @click="Swal.fire({ title: 'Catatan Revisi', input: 'textarea', inputPlaceholder: 'Masukkan catatan...', showCancelButton: true, confirmButtonText: 'Kirim Revisi', cancelButtonText: 'Batal', preConfirm: (notes) => { if(!notes) { Swal.showValidationMessage('Catatan wajib diisi!'); } return notes; } }).then(r => { if(r.isConfirmed) $wire.reviseLogbook({{ $log->id }}, r.value) })" class="px-3 py-1.5 bg-orange-100 text-orange-700 hover:bg-orange-200 text-xs font-medium rounded-lg transition">Revisi</button>
                            @else
                                <span class="text-xs text-slate-500 italic">Telah direview</span>
                            @endif
                        </div>
                        @if($log->verifier_notes)
                            <div class="mt-2 p-2 bg-red-50 border border-red-100 rounded-lg text-xs text-red-700">
                                <strong>Catatan Verifikator:</strong> {{ $log->verifier_notes }}
                            </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
