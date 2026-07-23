<div>
    <div class="mb-4">
        <a href="{{ route('customer.projects.index') }}" class="text-sm text-slate-500 hover:text-navy inline-flex items-center gap-1">
            &larr; Kembali ke Proyek Saya
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
                        {{ $project->title }}
                    </h1>
                    <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $project->status->color() }}">
                        {{ $project->status->label() }}
                    </span>
                </div>
                <span class="text-sm font-mono text-slate-500">{{ $project->project_code }}</span>
            </div>

            <div class="w-full md:w-64">
                <div class="flex justify-between text-sm mb-1">
                    <span class="font-medium text-slate-600">Progress</span>
                    <span class="font-bold text-navy font-mono">{{ $project->progress_percentage }}%</span>
                </div>
                <div class="w-full bg-slate-100 rounded-full h-2.5">
                    <div class="bg-navy h-2.5 rounded-full transition-all duration-500" style="width: {{ $project->progress_percentage }}%"></div>
                </div>
            </div>
        </div>

        <div x-data="{ tab: 'detail' }">
            <div class="border-b border-slate-200 mb-6 flex overflow-x-auto">
                <button @click="tab = 'detail'" :class="{ 'border-b-2 border-navy text-navy font-semibold': tab === 'detail', 'text-slate-500 hover:text-slate-700': tab !== 'detail' }" class="px-4 py-3 whitespace-nowrap text-sm">
                    Detail Proyek
                </button>
                <button @click="tab = 'timeline'" :class="{ 'border-b-2 border-navy text-navy font-semibold': tab === 'timeline', 'text-slate-500 hover:text-slate-700': tab !== 'timeline' }" class="px-4 py-3 whitespace-nowrap text-sm">
                    Laporan Harian
                </button>
                <button @click="tab = 'pembayaran'" :class="{ 'border-b-2 border-navy text-navy font-semibold': tab === 'pembayaran', 'text-slate-500 hover:text-slate-700': tab !== 'pembayaran' }" class="px-4 py-3 whitespace-nowrap text-sm">
                    Pembayaran
                </button>
            </div>

            {{-- Tab Detail --}}
            <div x-show="tab === 'detail'" x-cloak>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-6">
                        <div>
                            <h3 class="text-sm font-medium text-slate-500 mb-1">Layanan</h3>
                            <p class="font-medium text-slate-800">{{ $project->service->name }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-slate-500 mb-1">Deskripsi</h3>
                            <p class="text-slate-700 text-sm whitespace-pre-wrap">{{ $project->description }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-slate-500 mb-1">Alamat</h3>
                            <p class="text-slate-700 text-sm">{{ $project->address }}</p>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <h3 class="text-sm font-medium text-slate-500 mb-1">Tgl Pengajuan</h3>
                                <p class="text-slate-700 text-sm font-mono">{{ $project->requested_at ? $project->requested_at->format('d M Y') : '-' }}</p>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-slate-500 mb-1">Tgl Mulai</h3>
                                <p class="text-slate-700 text-sm font-mono">{{ $project->start_date ? \Carbon\Carbon::parse($project->start_date)->format('d M Y') : '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                            <h3 class="text-sm font-medium text-slate-500 mb-3">Informasi Kontraktor</h3>
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-full overflow-hidden bg-slate-200 shrink-0">
                                    @if ($project->contractor && $project->contractor->contractorProfile?->profile_photo)
                                        <img src="{{ asset('storage/' . $project->contractor->contractorProfile->profile_photo) }}" alt="Foto" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-navy text-white font-bold text-lg">
                                            {{ $project->contractor ? substr($project->contractor->name, 0, 1) : '?' }}
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <p class="font-bold text-slate-800">{{ $project->contractor ? $project->contractor->name : 'Belum ditentukan' }}</p>
                                    @if($project->contractor && $project->contractor->contractorProfile)
                                        <a href="{{ route('public.contractors.show', $project->contractor->contractorProfile) }}" class="text-xs text-orange-500 hover:underline">Lihat Profil</a>
                                    @endif
                                </div>
                            </div>
                            {{-- Tombol Chat via WA --}}
                            @if($project->contractor && $project->contractor->phone)
                                @php
                                    $waPhone = preg_replace('/[^0-9]/', '', $project->contractor->phone);
                                    if (str_starts_with($waPhone, '0')) $waPhone = '62' . substr($waPhone, 1);
                                    $waMsg = "Halo Bapak/Ibu *{$project->contractor->name}*, saya *" . auth()->user()->name . "* ingin menghubungi Anda terkait proyek:\n\n*{$project->title}*\nKode: {$project->project_code}\nLayanan: {$project->service?->name}\n\nMohon konfirmasinya, terima kasih! 🙏";
                                    $waUrl = 'https://wa.me/' . $waPhone . '?text=' . urlencode($waMsg);
                                @endphp
                                <a href="{{ $waUrl }}" target="_blank" rel="noopener"
                                   class="mt-3 flex items-center justify-center gap-2 w-full py-2.5 px-4 bg-green-500 hover:bg-green-600 text-white text-sm font-semibold rounded-xl transition-colors shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.126 1.533 5.854L0 24l6.293-1.51C8.037 23.472 9.981 24 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.892 0-3.658-.516-5.168-1.414l-.37-.22-3.734.896.937-3.627-.242-.378A9.944 9.944 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/></svg>
                                    Chat Mandor via WhatsApp
                                </a>
                            @endif
                        </div>
                        </div>

                        <div>
                            <h3 class="text-sm font-medium text-slate-500 mb-3">Riwayat Status</h3>
                            <div class="space-y-4">
                                @foreach($project->statusHistories as $history)
                                    <div class="flex gap-3 text-sm">
                                        <div class="w-2 h-2 rounded-full bg-navy mt-1.5 shrink-0"></div>
                                        <div>
                                            <p class="font-medium text-slate-700">{{ $history->status->label() }}</p>
                                            <p class="text-xs text-slate-500">{{ $history->created_at->format('d M Y H:i') }} • {{ $history->changedBy ? $history->changedBy->name : 'Sistem' }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        @if($project->status === \App\Enums\ProjectStatus::Pending)
                            <div class="pt-4 border-t border-slate-100">
                                <button @click="Swal.fire({ icon: 'warning', title: 'Batalkan Pengajuan?', text: 'Apakah Anda yakin ingin membatalkan pengajuan proyek ini?', showCancelButton: true, confirmButtonText: 'Ya, Batalkan', cancelButtonText: 'Batal', confirmButtonColor: '#dc2626', cancelButtonColor: '#64748b' }).then(r => { if (r.isConfirmed) $wire.cancel(); })" class="w-full py-2 px-4 bg-white border-2 border-red-500 text-red-600 hover:bg-red-50 rounded-xl font-medium transition text-sm">
                                    Batalkan Pengajuan
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Tab Timeline Laporan Harian --}}
            <div x-show="tab === 'timeline'" x-cloak>
                @if($project->dailyReports->isEmpty())
                    <div class="text-center py-8 text-slate-500">
                        <p>Belum ada laporan harian untuk proyek ini.</p>
                    </div>
                @else
                    <div class="space-y-8 pl-2">
                        @foreach($project->dailyReports as $report)
                            <div class="relative">
                                @if(!$loop->last)
                                    <div class="absolute left-4 top-10 bottom-[-2rem] border-l-2 border-dashed border-slate-200"></div>
                                @endif
                                <div class="flex gap-6 relative">
                                    <div class="w-8 h-8 rounded-full bg-navy text-white flex-shrink-0 flex items-center justify-center z-10 text-xs font-bold shadow-sm">
                                        {{ \Carbon\Carbon::parse($report->date)->format('d') }}
                                    </div>
                                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-5 flex-grow">
                                        <div class="flex flex-col sm:flex-row justify-between mb-3 gap-2">
                                            <h4 class="font-bold text-slate-800">{{ \Carbon\Carbon::parse($report->date)->translatedFormat('l, d F Y') }}</h4>
                                            <span class="px-2 py-1 bg-white border border-slate-200 rounded-md text-xs font-mono text-navy font-semibold w-max">
                                                Progress: {{ $report->progress_percentage }}%
                                            </span>
                                        </div>
                                        <p class="text-sm text-slate-600 mb-4 whitespace-pre-wrap">{{ $report->notes }}</p>

                                        @if($report->before_photo || $report->after_photo)
                                            <div class="flex flex-wrap gap-4 mt-2">
                                                @if($report->before_photo)
                                                    <div>
                                                        <div class="text-xs text-slate-500 mb-1">Sebelum:</div>
                                                        <img src="{{ asset('storage/' . $report->before_photo) }}" alt="Sebelum" class="h-32 w-auto object-cover rounded-xl border border-slate-200">
                                                    </div>
                                                @endif
                                                @if($report->after_photo)
                                                    <div>
                                                        <div class="text-xs text-slate-500 mb-1">Sesudah:</div>
                                                        <img src="{{ asset('storage/' . $report->after_photo) }}" alt="Sesudah" class="h-32 w-auto object-cover rounded-xl border border-slate-200">
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

            {{-- Tab Pembayaran --}}
            <div x-show="tab === 'pembayaran'" x-cloak>
                @livewire('customer.payment-confirm', ['project' => $project])
            </div>
        </div>
    </div>
</div>