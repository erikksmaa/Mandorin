<div class="mt-8">
    <div class="mb-4">
        <a href="{{ route('leader.programs.show', $program->id) }}" class="text-sm font-medium text-slate-500 hover:text-slate-800 inline-flex items-center gap-1">
            &larr; Kembali ke Program
        </a>
    </div>

    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800" style="font-family: 'Big Shoulders Display', sans-serif;">
                Laporan Keuangan (E-LPJ): {{ $program->title }}
            </h2>
            <p class="text-sm text-slate-500">Status: 
                <span class="font-semibold {{ $report->status === 'Submitted' ? 'text-blue-600' : ($report->status === 'Approved' ? 'text-green-600' : 'text-amber-600') }}">
                    {{ $report->status }}
                </span>
            </p>
        </div>
        @if($report->status !== 'Approved' && $report->status !== 'Submitted')
            @if($items->isEmpty())
                <button disabled class="px-5 py-2.5 bg-slate-300 text-slate-500 rounded-xl text-sm font-semibold cursor-not-allowed flex items-center gap-2" title="Tambahkan minimal satu transaksi terlebih dahulu">
                    Kirim E-LPJ
                </button>
            @else
                <button wire:click="submitElpj" class="px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-xl text-sm font-semibold transition shadow-sm flex items-center gap-2">
                    Kirim E-LPJ
                </button>
            @endif
        @endif
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Total Anggaran</p>
            <p class="text-xl font-bold text-slate-800">Rp {{ number_format($report->total_budget, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Pemasukan Tambahan</p>
            <p class="text-xl font-bold text-green-600">+ Rp {{ number_format($report->total_income, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Total Pengeluaran</p>
            <p class="text-xl font-bold text-red-600">- Rp {{ number_format($report->total_expense, 0, ',', '.') }}</p>
        </div>
        <div class="bg-slate-800 p-5 rounded-2xl shadow-sm text-white border border-slate-700">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Sisa Anggaran</p>
            <p class="text-xl font-bold">Rp {{ number_format($report->remaining_budget, 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        @if($report->status !== 'Approved' && $report->status !== 'Submitted')
        <!-- Form Tambah Item -->
        <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-5 h-fit lg:col-span-1">
            <h3 class="font-bold text-slate-800 border-b border-slate-100 pb-2 mb-4">Tambah Transaksi Baru</h3>
            <form wire:submit="addItem" class="space-y-4">
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Jenis</label>
                        <select wire:model.live="type" class="w-full border-slate-300 rounded-lg text-sm focus:border-navy focus:ring focus:ring-navy focus:ring-opacity-50">
                            <option value="Expense">Pengeluaran</option>
                            <option value="Income">Pemasukan</option>
                        </select>
                        @error('type') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Kategori</label>
                        <select wire:model="category" class="w-full border-slate-300 rounded-lg text-sm focus:border-navy focus:ring focus:ring-navy focus:ring-opacity-50">
                            <option value="Transportasi">Transportasi</option>
                            <option value="Konsumsi">Konsumsi</option>
                            <option value="Perlengkapan">Perlengkapan</option>
                            <option value="Dokumentasi">Dokumentasi</option>
                            <option value="Honor">Honor</option>
                            <option value="Publikasi">Publikasi</option>
                            <option value="Sewa">Sewa</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                        @error('category') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Deskripsi Item</label>
                    <input type="text" wire:model="description" class="w-full border-slate-300 rounded-lg text-sm focus:border-navy focus:ring focus:ring-navy focus:ring-opacity-50" placeholder="Cth: Pembelian konsumsi">
                    @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Kuantitas</label>
                        <input type="number" wire:model="quantity" min="1" class="w-full border-slate-300 rounded-lg text-sm focus:border-navy focus:ring focus:ring-navy focus:ring-opacity-50">
                        @error('quantity') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Harga Satuan (Rp)</label>
                        <input type="number" wire:model="unit_price" min="0" class="w-full border-slate-300 rounded-lg text-sm focus:border-navy focus:ring focus:ring-navy focus:ring-opacity-50">
                        @error('unit_price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Tanggal Transaksi</label>
                        <input type="date" wire:model="transaction_date" class="w-full border-slate-300 rounded-lg text-sm focus:border-navy focus:ring focus:ring-navy focus:ring-opacity-50">
                        @error('transaction_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Bukti / Struk <span class="text-red-500" x-show="$wire.type === 'Expense'">*</span></label>
                        @if($receipt)
                            <div class="mb-2">
                                <img src="{{ $receipt->temporaryUrl() }}" class="h-20 w-full object-cover rounded-lg border border-slate-200">
                            </div>
                        @endif
                        <input type="file" wire:model="receipt" accept="image/*" class="w-full text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-slate-50 file:text-navy hover:file:bg-slate-100 cursor-pointer">
                        @error('receipt') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>
                <button type="submit" class="w-full py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-lg text-sm font-medium transition">
                    + Simpan Transaksi
                </button>
            </form>
        </div>
    @endif

        <!-- Tabel Transaksi -->
        <div class="lg:col-span-{{ ($report->status !== 'Approved' && $report->status !== 'Submitted') ? '2' : '3' }}">
            <div class="bg-white border border-slate-200 shadow-sm rounded-xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-slate-50 text-slate-600 border-b border-slate-200">
                            <tr>
                                <th class="px-4 py-3 font-medium">Tanggal</th>
                                <th class="px-4 py-3 font-medium">Deskripsi</th>
                                <th class="px-4 py-3 font-medium text-right">Qty</th>
                                <th class="px-4 py-3 font-medium text-right">Harga Satuan</th>
                                <th class="px-4 py-3 font-medium text-right">Subtotal</th>
                                <th class="px-4 py-3 font-medium text-center">Bukti</th>
                                @if($report->status !== 'Approved' && $report->status !== 'Submitted')
                                <th class="px-4 py-3 font-medium text-center">Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($items as $item)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-3 text-slate-500">{{ \Carbon\Carbon::parse($item->transaction_date)->format('d M Y') }}</td>
                                <td class="px-4 py-3 font-medium text-slate-800">
                                    <span class="inline-block w-2 h-2 rounded-full mr-1 {{ $item->type === 'Income' ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                    {{ $item->description }}
                                    <div class="text-xs text-slate-400 font-normal mt-0.5">{{ $item->category }}</div>
                                </td>
                                <td class="px-4 py-3 text-right text-slate-600">{{ $item->quantity }}</td>
                                <td class="px-4 py-3 text-right text-slate-600">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 text-right font-medium {{ $item->type === 'Income' ? 'text-green-600' : 'text-slate-800' }}">
                                    {{ $item->type === 'Income' ? '+' : '' }} Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    @if($item->receipt)
                                    <a href="{{ asset('storage/' . $item->receipt) }}" target="_blank" class="text-xs text-navy hover:underline">
                                        Lihat Struk
                                    </a>
                                    @else
                                    <span class="text-xs text-slate-400">-</span>
                                    @endif
                                </td>
                                @if($report->status !== 'Approved' && $report->status !== 'Submitted')
                                <td class="px-4 py-3 text-center">
                                    <button @click="Swal.fire({ icon: 'warning', title: 'Hapus Item?', showCancelButton: true, confirmButtonText: 'Ya, Hapus', cancelButtonText: 'Batal' }).then(r => { if (r.isConfirmed) $wire.deleteItem({{ $item->id }}); })" class="text-red-500 hover:text-red-700">
                                        <svg class="w-4 h-4 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </td>
                                @endif
                            </tr>
                            @empty
                            <tr>
                                <td colspan="{{ ($report->status !== 'Approved' && $report->status !== 'Submitted') ? '7' : '6' }}" class="px-4 py-8 text-center text-slate-400">
                                    Belum ada transaksi tercatat.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
