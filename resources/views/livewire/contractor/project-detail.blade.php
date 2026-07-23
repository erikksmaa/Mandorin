<div>
    <a href="{{ route('contractor.dashboard') }}" class="text-sm font-medium text-slate-500 hover:text-slate-800 mb-6 inline-flex items-center gap-1">
        &larr; Kembali ke Dashboard
    </a>

    <div class="flex items-center gap-4 mb-4">
        <h1 class="text-2xl font-bold text-slate-800" style="font-family: 'Big Shoulders Display', sans-serif;">
            {{ $project->title }}
        </h1>
        <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $project->status->color() }}">
            {{ $project->status->label() }}
        </span>
    </div>


    <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-5 mb-6">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div>
                <span class="block text-xs font-medium text-slate-500">Klien</span>
                <span class="text-sm font-medium text-slate-800">{{ $project->customer->name }}</span>
            </div>
            <div>
                <span class="block text-xs font-medium text-slate-500">Layanan</span>
                <span class="text-sm font-medium text-slate-800">{{ $project->service?->name ?? '-' }}</span>
            </div>
            <div>
                <span class="block text-xs font-medium text-slate-500">Tanggal Mulai</span>
                <span class="text-sm font-medium text-slate-800 font-mono">{{ $project->start_date ? $project->start_date->format('d M Y') : '-' }}</span>
            </div>
            <div>
                <span class="block text-xs font-medium text-slate-500">Progress ({{ $project->progress_percentage ?? 0 }}%)</span>
                <div class="w-full bg-slate-100 rounded-full h-2 mt-1.5">
                    <div class="bg-green-500 h-2 rounded-full transition-all duration-500" style="width: {{ $project->progress_percentage ?? 0 }}%"></div>
                </div>
            </div>
        </div>
    </div>

    <div x-data="{ tab: @entangle('activeTab') }">
        <div class="border-b border-slate-200 mb-6">
            <nav class="flex gap-4">
                <button @click="tab = 'info'" :class="tab === 'info' ? 'border-b-2 border-orange-500 text-orange-600' : 'text-slate-500 hover:text-slate-700 border-b-2 border-transparent'" class="px-2 py-3 text-sm font-medium transition">Info Proyek</button>
                <button @click="tab = 'pekerja'" :class="tab === 'pekerja' ? 'border-b-2 border-orange-500 text-orange-600' : 'text-slate-500 hover:text-slate-700 border-b-2 border-transparent'" class="px-2 py-3 text-sm font-medium transition">Pekerja & Absensi</button>
                <button @click="tab = 'laporan'" :class="tab === 'laporan' ? 'border-b-2 border-orange-500 text-orange-600' : 'text-slate-500 hover:text-slate-700 border-b-2 border-transparent'" class="px-2 py-3 text-sm font-medium transition">Laporan Harian</button>
                <button @click="tab = 'pembayaran'" :class="tab === 'pembayaran' ? 'border-b-2 border-orange-500 text-orange-600' : 'text-slate-500 hover:text-slate-700 border-b-2 border-transparent'" class="px-2 py-3 text-sm font-medium transition">Pembayaran</button>
            </nav>
        </div>

        {{-- TAB: INFO --}}
        <div x-show="tab === 'info'">
            <div class="bg-white border border-slate-200 shadow-sm rounded-2xl p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    <div>
                        <h3 class="font-bold text-slate-800 mb-3 border-b pb-2">Deskripsi Proyek</h3>
                        <p class="text-sm text-slate-700 whitespace-pre-line">{{ $project->description }}</p>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800 mb-3 border-b pb-2">Detail Proyek</h3>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-slate-500">Kode Proyek</span>
                                <span class="font-mono font-medium">{{ $project->project_code }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-500">Alamat</span>
                                <span class="font-medium text-right max-w-[200px]">{{ $project->address }}</span>
                            </div>
                            <div class="flex justify-between items-center py-1">
                                <span class="text-slate-500">Target Selesai</span>
                                <form wire:submit="updateEstimatedFinishDate" class="flex items-center gap-1.5">
                                    <input type="date" wire:model="estimatedFinishDate" class="text-xs py-1 px-2 border border-slate-200 rounded-lg bg-slate-50 focus:bg-white focus:border-navy outline-none">
                                    <button type="submit" class="px-2.5 py-1 bg-navy hover:bg-navy-700 text-white text-xs font-semibold rounded-lg transition shrink-0">
                                        Simpan
                                    </button>
                                </form>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-slate-500">Selesai Pada</span>
                                <span class="font-mono font-medium text-slate-800">{{ $project->completed_at ? $project->completed_at->format('d M Y') : '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border-t border-slate-100 pt-6">
                    <h3 class="font-bold text-slate-800 mb-4">Aksi Status Proyek</h3>
                    <div class="flex flex-wrap gap-3">
                        @if($project->status->value === 'accepted')
                            <button wire:click="markInProgress" class="px-4 py-2 bg-navy text-white rounded-xl font-medium transition text-sm hover:opacity-90">
                                Mulai Kerjakan Proyek
                            </button>
                        @endif

                        @if(in_array($project->status->value, ['accepted', 'in_progress']))
                            <div class="flex items-center gap-2 bg-slate-50 p-2 rounded-xl border border-slate-200">
                                <span class="text-xs font-medium text-slate-500 px-2">Update Progress:</span>
                                @foreach([25, 50, 75, 100] as $pct)
                                    <button wire:click="updateProgress({{ $pct }})" class="px-3 py-1.5 {{ $project->progress_percentage == $pct ? 'bg-orange-500 text-white' : 'bg-white border border-slate-200 text-slate-700 hover:bg-slate-50' }} rounded-lg text-xs font-medium transition">
                                        {{ $pct }}%
                                    </button>
                                @endforeach
                            </div>
                        @endif

                        @if($project->status->value === 'in_progress' || $project->progress_percentage == 100)
                            <button @click="Swal.fire({ icon: 'question', title: 'Tandai Selesai?', text: 'Apakah Anda yakin ingin menandai proyek ini sebagai Selesai?', showCancelButton: true, confirmButtonText: 'Ya, Selesai', cancelButtonText: 'Batal', confirmButtonColor: '#16a34a', cancelButtonColor: '#64748b' }).then(r => { if (r.isConfirmed) $wire.markCompleted(); })" class="px-4 py-2 bg-verified hover:bg-green-700 text-white rounded-xl font-medium transition text-sm">
                                Tandai Selesai
                            </button>
                        @endif

                        @if(in_array($project->status->value, ['completed']))
                            <span class="px-4 py-2 bg-green-50 text-verified rounded-xl font-medium text-sm border border-green-200">
                                ✓ Proyek selesai pada {{ $project->completed_at?->format('d M Y') }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- TAB: PEKERJA & ABSENSI --}}
        <div x-show="tab === 'pekerja'" style="display: none;">
            @livewire('contractor.worker-manager', ['project' => $project])
            <div class="mt-6">
                @livewire('contractor.attendance-form', ['project' => $project])
            </div>
        </div>

        {{-- TAB: LAPORAN HARIAN --}}
        <div x-show="tab === 'laporan'" style="display: none;">
            @livewire('contractor.daily-report-history', ['project' => $project])
        </div>

        {{-- TAB: PEMBAYARAN --}}
        <div x-show="tab === 'pembayaran'" style="display: none;">
            @livewire('contractor.payment-log-form', ['project' => $project])
        </div>
    </div>
</div>
