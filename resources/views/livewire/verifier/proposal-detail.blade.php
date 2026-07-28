<div>
    <div class="mb-4">
        <a href="{{ route('verifier.proposals.index') }}" class="text-sm text-slate-500 hover:text-navy inline-flex items-center gap-1">
            &larr; Kembali ke Daftar Proposal
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white border border-slate-200 shadow-sm rounded-2xl p-6 mb-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
            <div>
                <div class="flex items-center gap-3 mb-1">
                    <h1 class="text-2xl font-bold text-slate-800" style="font-family: 'Big Shoulders Display', sans-serif;">
                        {{ $program->title }}
                    </h1>
                    @php
                        $propMap = [
                            'Pending'  => 'bg-amber-100 text-amber-700',
                            'Verified' => 'bg-green-100 text-green-700',
                            'Revision' => 'bg-blue-100 text-blue-700',
                            'Rejected' => 'bg-red-100 text-red-700',
                        ];
                        $propVal   = $program->proposal_status instanceof \BackedEnum ? $program->proposal_status->value : $program->proposal_status;
                        $propColor = $propMap[$propVal] ?? 'bg-slate-100 text-slate-700';
                        $propLabel = $program->proposal_status instanceof \BackedEnum ? $program->proposal_status->label() : ucfirst($propVal);
                    @endphp
                    <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $propColor }}">{{ $propLabel }}</span>
                </div>
                <span class="text-sm font-mono text-slate-500">{{ $program->program_code }}</span>
            </div>
        </div>

        <div x-data="{ tab: 'detail' }">
            <div class="border-b border-slate-200 mb-6 flex overflow-x-auto">
                <button @click="tab = 'detail'" :class="{ 'border-b-2 border-navy text-navy font-semibold': tab === 'detail', 'text-slate-500 hover:text-slate-700': tab !== 'detail' }" class="px-4 py-3 whitespace-nowrap text-sm">
                    Detail Program
                </button>
                <button @click="tab = 'logbook'" :class="{ 'border-b-2 border-navy text-navy font-semibold': tab === 'logbook', 'text-slate-500 hover:text-slate-700': tab !== 'logbook' }" class="px-4 py-3 whitespace-nowrap text-sm">
                    Logbook Kegiatan
                </button>
                <button @click="tab = 'elpj'" :class="{ 'border-b-2 border-navy text-navy font-semibold': tab === 'elpj', 'text-slate-500 hover:text-slate-700': tab !== 'elpj' }" class="px-4 py-3 whitespace-nowrap text-sm">
                    Laporan E-LPJ
                </button>
            </div>

            {{-- Tab Detail --}}
            <div x-show="tab === 'detail'" x-cloak>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-4">
                        <div>
                            <h3 class="text-sm font-medium text-slate-500 mb-1">Kategori Program</h3>
                            <p class="font-medium text-slate-800">{{ $program->category?->name ?? '-' }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-slate-500 mb-1">Deskripsi</h3>
                            <p class="text-slate-700 text-sm whitespace-pre-wrap">{{ $program->description }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-slate-500 mb-1">Tujuan</h3>
                            <p class="text-slate-700 text-sm whitespace-pre-wrap">{{ $program->objective ?? '-' }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-slate-500 mb-1">Sasaran</h3>
                            <p class="text-slate-700 text-sm">{{ $program->target ?? '-' }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-slate-500 mb-1">Lokasi</h3>
                            <p class="text-slate-700 text-sm">{{ $program->location ?? '-' }}</p>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <h3 class="text-sm font-medium text-slate-500 mb-1">Tanggal Mulai</h3>
                                <p class="text-slate-700 text-sm font-mono">{{ $program->start_date ? $program->start_date->format('d M Y') : '-' }}</p>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-slate-500 mb-1">Tanggal Selesai</h3>
                                <p class="text-slate-700 text-sm font-mono">{{ $program->end_date ? $program->end_date->format('d M Y') : '-' }}</p>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-slate-500 mb-1">Anggaran</h3>
                            <p class="text-slate-700 text-lg font-bold">Rp {{ number_format($program->budget ?? 0, 0, ',', '.') }}</p>
                        </div>
                        
                        <div>
                            <h3 class="text-sm font-medium text-slate-500 mb-1">Dokumen Proposal</h3>
                            @if($program->proposal_file)
                                <a href="{{ asset('storage/' . $program->proposal_file) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-navy text-sm font-medium rounded-xl transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    Lihat / Unduh Proposal
                                </a>
                            @else
                                <p class="text-slate-400 text-sm italic">Tidak ada dokumen proposal yang dilampirkan.</p>
                            @endif
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                            <h3 class="text-sm font-medium text-slate-500 mb-3">Informasi Organisasi</h3>
                            <div class="space-y-2">
                                <p class="font-bold text-slate-800">{{ $program->organization?->name ?? '-' }}</p>
                                <p class="text-sm text-slate-600">📂 {{ $program->organization?->category?->name ?? '-' }}</p>
                                <p class="text-sm text-slate-500">📍 {{ $program->organization?->address ?? '-' }}</p>
                            </div>
                        </div>

                        <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                            <h3 class="text-sm font-medium text-slate-500 mb-3">Ketua Pelaksana</h3>
                            <div class="space-y-2">
                                <p class="font-bold text-slate-800">{{ $program->leader?->name ?? '-' }}</p>
                                <p class="text-sm text-slate-500">✉️ {{ $program->leader?->email ?? '-' }}</p>
                                @if($program->leader?->phone)
                                    <p class="text-sm text-slate-500">📱 {{ $program->leader->phone }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                            <h3 class="text-sm font-medium text-slate-500 mb-3">Anggota Program</h3>
                            @forelse($program->members as $member)
                                <div class="flex items-center gap-2 py-1">
                                    <div class="w-6 h-6 bg-navy rounded-full flex items-center justify-center text-white text-xs">
                                        {{ strtoupper(substr($member->user?->name ?? '?', 0, 1)) }}
                                    </div>
                                    <span class="text-sm text-slate-700">{{ $member->user?->name ?? '-' }}</span>
                                    <span class="text-xs text-slate-400">({{ $member->role?->value ?? '-' }})</span>
                                </div>
                            @empty
                                <p class="text-sm text-slate-400">Belum ada anggota terdaftar.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                @if($program->proposal_notes)
                    <div class="mt-6 p-4 bg-amber-50 border border-amber-200 rounded-xl">
                        <h3 class="text-sm font-semibold text-amber-700 mb-1">Catatan Verifikasi Sebelumnya:</h3>
                        <p class="text-sm text-amber-800 whitespace-pre-wrap">{{ $program->proposal_notes }}</p>
                    </div>
                @endif
            </div>

            {{-- Tab Logbook --}}
            <div x-show="tab === 'logbook'" x-cloak>
                @if($program->activityLogs->isEmpty())
                    <div class="text-center py-8 text-slate-500">
                        <p>Belum ada logbook kegiatan untuk program ini.</p>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($program->activityLogs as $log)
                            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4">
                                <div class="flex justify-between items-start mb-2">
                                    <h4 class="font-bold text-slate-800">{{ $log->title }}</h4>
                                    <span class="text-xs text-slate-400 font-mono">{{ $log->activity_date?->format('d M Y') ?? '-' }}</span>
                                </div>
                                <p class="text-sm text-slate-600 whitespace-pre-wrap">{{ $log->description }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Tab E-LPJ --}}
            <div x-show="tab === 'elpj'" x-cloak x-data="{ openDetailModal: false }">
                @php $lpj = $program->financialReport; @endphp
                @if(!$lpj)
                    <div class="text-center py-8 bg-slate-50 border border-slate-100 rounded-xl text-slate-500 text-sm">
                        <p class="font-medium">Belum ada laporan yang dikirim.</p>
                        <p class="text-xs text-slate-400 mt-1">Ketua Pelaksana belum mengirimkan laporan E-LPJ untuk program ini.</p>
                    </div>
                @else
                    <div class="overflow-x-auto border border-slate-200 rounded-xl">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-slate-50 text-slate-500 text-xs uppercase border-b border-slate-200">
                                <tr>
                                    <th class="px-4 py-3">Nomor LPJ</th>
                                    <th class="px-4 py-3">Tanggal Submit</th>
                                    <th class="px-4 py-3">Total Pengeluaran</th>
                                    <th class="px-4 py-3">Status</th>
                                    <th class="px-4 py-3 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @php
                                    $lpjStatusVal = $lpj->status instanceof \BackedEnum ? $lpj->status->value : $lpj->status;
                                    $lpjStatusLabel = $lpj->status instanceof \BackedEnum ? $lpj->status->label() : ucfirst($lpjStatusVal);
                                    $lpjStatusClass = match($lpjStatusVal) {
                                        'Approved' => 'bg-green-100 text-green-700',
                                        'Submitted' => 'bg-blue-100 text-blue-700',
                                        'Revision' => 'bg-amber-100 text-amber-700',
                                        'Rejected' => 'bg-red-100 text-red-700',
                                        default => 'bg-slate-100 text-slate-700',
                                    };
                                @endphp
                                <tr class="hover:bg-slate-50">
                                    <td class="px-4 py-3 font-mono font-bold text-slate-800">{{ $lpj->report_number }}</td>
                                    <td class="px-4 py-3 text-slate-600">{{ $lpj->submitted_at ? $lpj->submitted_at->format('d M Y, H:i') : '-' }}</td>
                                    <td class="px-4 py-3 font-bold text-slate-800">Rp {{ number_format($lpj->total_expense ?? 0, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3">
                                        <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $lpjStatusClass }}">
                                            {{ $lpjStatusLabel }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <button @click="openDetailModal = true" class="px-3 py-1.5 bg-navy text-white hover:bg-slate-800 rounded-lg text-xs font-semibold transition">
                                            Aksi Detail &rarr;
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    {{-- Modal Detail E-LPJ --}}
                    <div x-show="openDetailModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm" x-cloak>
                        <div @click.outside="openDetailModal = false" class="bg-white rounded-2xl max-w-3xl w-full max-h-[90vh] overflow-y-auto p-6 shadow-2xl">
                            <div class="flex justify-between items-center pb-4 border-b border-slate-100 mb-4">
                                <div>
                                    <h3 class="text-xl font-bold text-slate-800" style="font-family: 'Big Shoulders Display', sans-serif;">Detail Laporan E-LPJ</h3>
                                    <p class="text-xs font-mono text-slate-500">{{ $lpj->report_number }}</p>
                                </div>
                                <button @click="openDetailModal = false" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>

                            {{-- Ringkasan LPJ --}}
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 bg-slate-50 p-4 rounded-xl mb-6">
                                <div>
                                    <span class="block text-xs text-slate-500">Total Anggaran</span>
                                    <span class="font-bold text-slate-800 text-sm">Rp {{ number_format($lpj->total_budget ?? 0, 0, ',', '.') }}</span>
                                </div>
                                <div>
                                    <span class="block text-xs text-slate-500">Penerimaan</span>
                                    <span class="font-bold text-slate-800 text-sm">Rp {{ number_format($lpj->total_income ?? 0, 0, ',', '.') }}</span>
                                </div>
                                <div>
                                    <span class="block text-xs text-slate-500">Pengeluaran</span>
                                    <span class="font-bold text-slate-800 text-sm">Rp {{ number_format($lpj->total_expense ?? 0, 0, ',', '.') }}</span>
                                </div>
                                <div>
                                    <span class="block text-xs text-slate-500">Sisa Anggaran</span>
                                    <span class="font-bold text-slate-800 text-sm">Rp {{ number_format($lpj->remaining_budget ?? 0, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            {{-- Daftar Financial Items --}}
                            <h4 class="font-bold text-slate-800 text-sm mb-3">Daftar Financial Items & Bukti Struk</h4>
                            <div class="overflow-x-auto border border-slate-200 rounded-xl mb-6">
                                <table class="w-full text-left text-xs">
                                    <thead class="bg-slate-50 text-slate-500 uppercase border-b border-slate-200">
                                        <tr>
                                            <th class="px-3 py-2">Deskripsi</th>
                                            <th class="px-3 py-2">Tipe</th>
                                            <th class="px-3 py-2">Kategori</th>
                                            <th class="px-3 py-2">Jumlah</th>
                                            <th class="px-3 py-2">Harga Satuan</th>
                                            <th class="px-3 py-2">Subtotal</th>
                                            <th class="px-3 py-2">Bukti Struk</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100">
                                        @forelse($lpj->items as $item)
                                            <tr>
                                                <td class="px-3 py-2 font-medium text-slate-800">{{ $item->description }}</td>
                                                <td class="px-3 py-2">
                                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold {{ ($item->type instanceof \BackedEnum ? $item->type->value : $item->type) === 'income' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                                        {{ strtoupper($item->type instanceof \BackedEnum ? $item->type->value : $item->type) }}
                                                    </span>
                                                </td>
                                                <td class="px-3 py-2 text-slate-600">{{ $item->category ?? '-' }}</td>
                                                <td class="px-3 py-2 text-slate-600">{{ $item->quantity }}</td>
                                                <td class="px-3 py-2 text-slate-600">Rp {{ number_format($item->unit_price ?? 0, 0, ',', '.') }}</td>
                                                <td class="px-3 py-2 font-bold text-slate-800">Rp {{ number_format($item->subtotal ?? 0, 0, ',', '.') }}</td>
                                                <td class="px-3 py-2">
                                                    @if($item->receipt)
                                                        <a href="{{ asset('storage/' . $item->receipt) }}" target="_blank" class="text-blue-600 hover:underline font-semibold flex items-center gap-1">
                                                            🖼️ Lihat Struk
                                                        </a>
                                                    @else
                                                        <span class="text-slate-400 italic">Tidak ada</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="px-3 py-4 text-center text-slate-400">Tidak ada rincian transaksi.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            @if($lpj->verifier_notes || $lpj->verifier)
                                <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 text-xs text-amber-900">
                                    <h5 class="font-bold mb-1">Catatan Verifikator</h5>
                                    <p>{{ $lpj->verifier_notes ?? 'Tidak ada catatan khusus.' }}</p>
                                    @if($lpj->verifier)
                                        <p class="mt-2 text-[10px] text-amber-700">Diverifikasi oleh: {{ $lpj->verifier->name }} ({{ $lpj->verified_at?->format('d M Y, H:i') }})</p>
                                    @endif
                                </div>
                            @endif

                            <div class="mt-6 flex justify-end">
                                <button @click="openDetailModal = false" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 text-xs font-semibold rounded-xl transition">
                                    Tutup
                                </button>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Verifikasi Actions --}}
    @php
        $isPending = ($program->proposal_status instanceof \BackedEnum ? $program->proposal_status->value : $program->proposal_status) === 'Pending';
    @endphp

    @if($isPending)
        <div class="bg-white border border-slate-200 shadow-sm rounded-2xl p-6">
            <h2 class="text-lg font-semibold text-slate-800 mb-4">Keputusan Verifikasi</h2>

            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-600 mb-1">Catatan / Alasan (wajib untuk Revisi & Tolak)</label>
                <textarea wire:model="notes" rows="3"
                    class="w-full px-3 py-2 text-sm border border-slate-200 rounded-xl focus:ring-navy focus:border-navy"
                    placeholder="Tulis catatan verifikasi di sini..."></textarea>
                @error('notes') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex flex-wrap gap-3">
                <button
                    @click="Swal.fire({ icon: 'question', title: 'Setujui Proposal?', text: 'Proposal ini akan disetujui dan program dapat segera dimulai.', showCancelButton: true, confirmButtonText: '✓ Ya, Setujui', cancelButtonText: 'Batal', confirmButtonColor: '#16a34a', cancelButtonColor: '#64748b' }).then(r => { if (r.isConfirmed) { $wire.approve(); } })"
                    class="px-6 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-xl font-semibold transition shadow-sm">
                    ✓ Setujui
                </button>
                <button
                    @click="Swal.fire({ icon: 'info', title: 'Minta Revisi?', text: 'Proposal akan dikembalikan ke Ketua Pelaksana dengan catatan revisi.', showCancelButton: true, confirmButtonText: 'Ya, Minta Revisi', cancelButtonText: 'Batal', confirmButtonColor: '#2563eb', cancelButtonColor: '#64748b' }).then(r => { if (r.isConfirmed) { $wire.revision(); } })"
                    class="px-6 py-2.5 bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 rounded-xl font-semibold transition">
                    ↩ Minta Revisi
                </button>
                <button
                    @click="Swal.fire({ icon: 'warning', title: 'Tolak Proposal?', text: 'Proposal ini akan ditolak dan tidak dapat diproses lebih lanjut.', showCancelButton: true, confirmButtonText: 'Ya, Tolak', cancelButtonText: 'Batal', confirmButtonColor: '#dc2626', cancelButtonColor: '#64748b' }).then(r => { if (r.isConfirmed) { $wire.reject(); } })"
                    class="px-6 py-2.5 bg-red-50 hover:bg-red-100 text-red-700 border border-red-200 rounded-xl font-semibold transition">
                    ✕ Tolak
                </button>
            </div>
        </div>
    @else
        <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 flex flex-col sm:flex-row items-center justify-between gap-3 text-slate-600">
            <div>
                Proposal ini telah <strong>{{ $propLabel }}</strong>.
                @if($program->verifier)
                    Diverifikasi oleh <strong>{{ $program->verifier->name }}</strong> pada {{ $program->verified_at?->format('d M Y, H:i') }}.
                @endif
            </div>
            <a href="{{ route('verifier.evaluation.show', $program->id) }}" class="px-4 py-2 bg-navy hover:bg-slate-800 text-white text-xs font-semibold rounded-xl transition shrink-0 shadow-sm">
                Evaluasi & Verifikasi Akhir &rarr;
            </a>
        </div>
    @endif
</div>