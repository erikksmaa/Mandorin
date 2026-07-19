<div class="mt-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-slate-800" style="font-family: 'Big Shoulders Display', sans-serif;">
            Log Pembayaran
        </h2>
        <button wire:click="toggleForm" class="px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-xl text-sm font-medium transition">
            Tambah Pembayaran
        </button>
    </div>

    @if (session()->has('payment_success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg text-sm">
            {{ session('payment_success') }}
        </div>
    @endif

    @if($showForm)
        <div class="bg-slate-50 border border-slate-200 rounded-2xl p-5 mb-6">
            <h3 class="font-bold text-slate-700 mb-4">Form Pembayaran Baru</h3>
            <form wire:submit="addPayment">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1">Jumlah (Rp)</label>
                        <input type="number" wire:model="amount" class="w-full border-slate-300 rounded-lg text-sm focus:border-navy focus:ring focus:ring-navy focus:ring-opacity-50">
                        @error('amount') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1">Tanggal Pembayaran</label>
                        <input type="date" wire:model="paymentDate" class="w-full border-slate-300 rounded-lg text-sm focus:border-navy focus:ring focus:ring-navy focus:ring-opacity-50">
                        @error('paymentDate') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-medium text-slate-700 mb-1">Bukti Pembayaran (Opsional)</label>
                        <input type="file" wire:model="receipt" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-white file:text-navy hover:file:bg-slate-100">
                        @error('receipt') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" wire:click="toggleForm" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-xl text-sm font-medium transition">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-navy hover:bg-navy-700 text-white rounded-xl text-sm font-medium transition flex items-center justify-center gap-2">
                        <span wire:loading.remove wire:target="addPayment">Simpan</span>
                        <span wire:loading wire:target="addPayment">Menyimpan...</span>
                    </button>
                </div>
            </form>
        </div>
    @endif

    @if($paymentLogs->isEmpty())
        <div class="bg-slate-50 border border-slate-200 border-dashed rounded-2xl p-8 text-center">
            <p class="text-slate-500 mb-4">Belum ada log pembayaran.</p>
        </div>
    @else
        <div class="space-y-4">
            @foreach($paymentLogs as $log)
                <div class="bg-white border border-slate-200 shadow-sm rounded-2xl p-5 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold text-sm shrink-0">
                            #{{ $log->payment_number }}
                        </div>
                        <div>
                            <div class="font-bold text-slate-800 text-lg">Rp {{ number_format($log->amount, 0, ',', '.') }}</div>
                            <div class="text-sm text-slate-500">{{ date('d M Y', strtotime($log->payment_date)) }}</div>
                            
                            @if($log->receipt)
                                <div class="mt-2">
                                    <a href="{{ asset('storage/' . $log->receipt) }}" target="_blank" class="text-xs text-navy hover:underline flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                        Lihat Bukti
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <div>
                        @if($log->status->value === 'pending')
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-700">
                                {{ $log->status->label() }}
                            </span>
                        @elseif($log->status->value === 'confirmed')
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                {{ $log->status->label() }}
                            </span>
                        @elseif($log->status->value === 'rejected')
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">
                                {{ $log->status->label() }}
                            </span>
                        @else
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-700">
                                {{ $log->status->name }}
                            </span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
