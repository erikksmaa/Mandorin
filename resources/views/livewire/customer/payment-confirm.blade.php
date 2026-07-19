<div>
    @if(session('payment_success'))
        <div class="mb-4 bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm">
            {{ session('payment_success') }}
        </div>
    @endif
    @if(session('payment_error'))
        <div class="mb-4 bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">
            {{ session('payment_error') }}
        </div>
    @endif

    <div class="mb-6 flex justify-between items-end">
        <div>
            <h2 class="text-xl font-bold text-slate-800" style="font-family: 'Big Shoulders Display', sans-serif;">Log Pembayaran</h2>
            <p class="text-sm text-slate-500">Konfirmasi pembayaran yang diajukan oleh kontraktor.</p>
        </div>
        <div class="text-right">
            <p class="text-xs text-slate-500 uppercase tracking-wider font-semibold">Total Terbayar</p>
            <p class="text-xl font-bold font-mono text-green-600">Rp {{ number_format($totalConfirmed, 0, ',', '.') }}</p>
        </div>
    </div>

    @if($paymentLogs->isEmpty())
        <div class="text-center py-8 text-slate-500 bg-slate-50 rounded-xl border border-dashed border-slate-300">
            <p>Belum ada log pembayaran.</p>
        </div>
    @else
        <div class="space-y-4">
            @foreach($paymentLogs as $log)
                <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-4 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-navy text-white rounded-lg flex flex-col items-center justify-center shrink-0">
                            <span class="text-[10px] uppercase font-semibold">Termin</span>
                            <span class="text-lg font-bold leading-none">{{ $log->payment_number }}</span>
                        </div>
                        <div>
                            <p class="font-bold text-slate-800 font-mono text-lg">Rp {{ number_format($log->amount, 0, ',', '.') }}</p>
                            <p class="text-xs text-slate-500">Tgl: {{ $log->payment_date ? \Carbon\Carbon::parse($log->payment_date)->format('d M Y') : '-' }}</p>
                            @if($log->receipt)
                                <a href="{{ asset('storage/' . $log->receipt) }}" target="_blank" class="text-xs text-blue-600 hover:underline mt-1 inline-block">
                                    Lihat Bukti Transfer &#8599;
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="flex flex-col md:items-end gap-2">
                        @php
                            $statusColors = [
                                'pending' => 'bg-amber-100 text-amber-700',
                                'confirmed' => 'bg-green-100 text-green-700',
                                'rejected' => 'bg-red-100 text-red-700',
                            ];
                            $statusColor = $statusColors[$log->status->value] ?? 'bg-slate-100 text-slate-700';
                        @endphp
                        <span class="px-2.5 py-1 rounded-full text-xs font-medium w-max {{ $statusColor }}">
                            {{ $log->status->label() }}
                        </span>

                        @if($log->status === \App\Enums\PaymentStatus::Pending)
                            <div class="flex gap-2 mt-2">
                                <button wire:click="rejectPayment({{ $log->id }})" onclick="return confirm('Tolak pembayaran ini?')" class="px-3 py-1.5 text-xs font-medium text-red-600 bg-white border border-red-200 hover:bg-red-50 rounded-lg transition">
                                    Tolak
                                </button>
                                <button wire:click="confirmPayment({{ $log->id }})" onclick="return confirm('Konfirmasi bahwa Anda telah menerima pembayaran ini?')" class="px-3 py-1.5 text-xs font-medium text-white bg-green-600 hover:bg-green-700 rounded-lg transition">
                                    Konfirmasi
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>