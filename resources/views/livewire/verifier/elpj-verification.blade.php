<div>
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800" style="font-family: 'Big Shoulders Display', sans-serif;">
                Verifikasi E-LPJ (Laporan Pertanggungjawaban)
            </h1>
            <p class="text-slate-500 text-sm">Review dan verifikasi laporan pertanggungjawaban keuangan dari organisasi pelaksana.</p>
        </div>
        <div class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari no laporan / program..."
                class="w-full sm:w-64 px-3.5 py-2 text-sm bg-white border border-slate-200 rounded-xl focus:ring-navy focus:border-navy">
            
            <select wire:model.live="statusFilter" class="px-3 py-2 text-sm bg-white border border-slate-200 rounded-xl focus:ring-navy focus:border-navy">
                <option value="all">Semua Status LPJ</option>
                <option value="Submitted">Submitted</option>
                <option value="Approved">Approved</option>
                <option value="Revision">Revision</option>
            </select>

            <select wire:model.live="yearFilter" class="px-3 py-2 text-sm bg-white border border-slate-200 rounded-xl focus:ring-navy focus:border-navy">
                <option value="">Semua Tahun</option>
                <option value="2026">2026</option>
                <option value="2025">2025</option>
            </select>

            <div class="flex items-center gap-1.5 text-xs text-slate-500">
                <span>Tampilkan:</span>
                <select wire:model.live="perPage" class="border-slate-200 rounded-lg text-xs py-1.5 px-2 focus:ring-navy focus:border-navy">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
        </div>
    </div>

    <div class="bg-white border border-slate-200 shadow-sm rounded-xl overflow-hidden mb-6">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-slate-800 border-b border-slate-200 font-semibold">
                    <tr>
                        <th class="px-6 py-3.5">No. Laporan</th>
                        <th class="px-6 py-3.5">Program & Organisasi</th>
                        <th class="px-6 py-3.5 text-right">Total Realisasi</th>
                        <th class="px-6 py-3.5 text-center">Status</th>
                        <th class="px-6 py-3.5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($reports as $report)
                        <tbody x-data="{ expanded: false }" class="divide-y divide-slate-100 group">
                            <tr class="hover:bg-slate-50/80 transition cursor-pointer" @click="expanded = !expanded">
                                <td class="px-6 py-4 font-mono font-medium text-slate-700">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-slate-400 transition-transform" :class="expanded ? 'rotate-90' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                        {{ $report->report_number ?? 'ELPJ-' . $report->id }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-bold text-slate-800">{{ $report->program?->title ?? '-' }}</div>
                                    <div class="text-xs text-orange-600 font-semibold">{{ $report->program?->organization?->name ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 text-right font-mono font-bold text-slate-800">
                                    Rp {{ number_format($report->total_expense ?? 0, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @php
                                        $st = $report->status instanceof \BackedEnum ? $report->status->value : $report->status;
                                    @endphp
                                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold
                                        {{ $st === 'Approved' ? 'bg-green-100 text-green-700' : ($st === 'Revision' ? 'bg-amber-100 text-amber-700' : 'bg-blue-100 text-blue-700') }}">
                                        {{ $st }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2" @click.stop>
                                        <button wire:click="approve({{ $report->id }})" class="px-3 py-1 bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg text-xs font-semibold transition" title="Setujui">
                                            ✓ Setujui
                                        </button>
                                        <button wire:click="requestRevision({{ $report->id }})" class="px-3 py-1 bg-amber-500 hover:bg-amber-600 text-white rounded-lg text-xs font-semibold transition" title="Minta Revisi">
                                            ✎ Revisi
                                        </button>
                                        @if($report->program_id)
                                            <a href="{{ route('verifier.evaluation.show', $report->program_id) }}" class="px-2.5 py-1 bg-navy hover:bg-slate-800 text-white rounded-lg text-xs font-semibold transition" title="Evaluasi Akhir">
                                                Verifikasi Akhir &rarr;
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            <tr x-show="expanded" x-collapse>
                                <td colspan="5" class="px-6 py-4 bg-slate-50 border-b border-slate-200">
                                    <div class="rounded-xl bg-white border border-slate-200 overflow-hidden">
                                        <table class="w-full text-xs text-left">
                                            <thead class="bg-slate-100 text-slate-600 font-medium">
                                                <tr>
                                                    <th class="px-4 py-2">Tanggal</th>
                                                    <th class="px-4 py-2">Deskripsi</th>
                                                    <th class="px-4 py-2">Kategori</th>
                                                    <th class="px-4 py-2 text-right">Qty x Harga</th>
                                                    <th class="px-4 py-2 text-right">Subtotal</th>
                                                    <th class="px-4 py-2 text-center">Bukti</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-slate-100">
                                                @forelse($report->items as $item)
                                                <tr>
                                                    <td class="px-4 py-2 text-slate-500">{{ \Carbon\Carbon::parse($item->transaction_date)->format('d M Y') }}</td>
                                                    <td class="px-4 py-2 font-medium">
                                                        <span class="inline-block w-2 h-2 rounded-full mr-1 {{ $item->type->value === 'Income' ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                                        {{ $item->description }}
                                                    </td>
                                                    <td class="px-4 py-2 text-slate-600">{{ $item->category }}</td>
                                                    <td class="px-4 py-2 text-right text-slate-500">{{ $item->quantity }} x {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                                                    <td class="px-4 py-2 text-right font-medium {{ $item->type->value === 'Income' ? 'text-green-600' : 'text-slate-800' }}">
                                                        {{ $item->type->value === 'Income' ? '+' : '' }} Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                                    </td>
                                                    <td class="px-4 py-2 text-center">
                                                        @if($item->receipt)
                                                        <a href="{{ asset('storage/' . $item->receipt) }}" target="_blank" class="text-navy hover:underline font-medium">Lihat</a>
                                                        @else
                                                        <span class="text-slate-400">-</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="6" class="px-4 py-4 text-center text-slate-400">Belum ada item transaksi.</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                Belum ada laporan E-LPJ yang diajukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div>
        {{ $reports->links() }}
    </div>
</div>