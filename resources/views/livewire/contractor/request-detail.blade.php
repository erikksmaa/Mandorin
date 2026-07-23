<div>
    <a href="{{ route('contractor.dashboard') }}" class="text-sm font-medium text-slate-500 hover:text-slate-800 mb-6 inline-flex items-center gap-1">
        &larr; Kembali ke Dashboard
    </a>

    <div class="flex items-center gap-4 mb-6">
        <h1 class="text-2xl font-bold text-slate-800" style="font-family: 'Big Shoulders Display', sans-serif;">
            {{ $project->title }}
        </h1>
        <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $project->status->value === 'pending' ? 'bg-amber-100 text-amber-700' : ($project->status->value === 'rejected' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700') }}">
            {{ $project->status->label() }}
        </span>
    </div>

    <div class="bg-white border border-slate-200 shadow-sm rounded-2xl p-6 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <h3 class="text-lg font-bold text-slate-800 mb-4 border-b pb-2">Informasi Klien</h3>
                <div class="space-y-3">
                    <div>
                        <span class="block text-xs font-medium text-slate-500">Nama Lengkap</span>
                        <span class="text-slate-800 font-medium">{{ $project->customer->name }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-medium text-slate-500">Email</span>
                        <span class="text-slate-800">{{ $project->customer->email }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-medium text-slate-500">No. HP</span>
                        <span class="text-slate-800">{{ $project->customer->phone ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-bold text-slate-800 mb-4 border-b pb-2">Detail Permintaan</h3>
                <div class="space-y-3">
                    <div>
                        <span class="block text-xs font-medium text-slate-500">Layanan</span>
                        <span class="text-slate-800 font-medium">{{ $project->service?->name ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-medium text-slate-500">Tanggal Permintaan</span>
                        <span class="text-slate-800">{{ $project->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-medium text-slate-500">Kode Proyek</span>
                        <span class="text-slate-800 font-mono">{{ $project->project_code }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-medium text-slate-500">Alamat Proyek</span>
                        <span class="text-slate-800">{{ $project->address }}</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-6 pt-6 border-t border-slate-100">
            <span class="block text-xs font-medium text-slate-500 mb-2">Deskripsi Kebutuhan</span>
            <p class="text-slate-700 whitespace-pre-line">{{ $project->description }}</p>
        </div>
    </div>

    @if($project->status->value === 'pending')
        <div class="flex gap-3">
            <button
                @click="Swal.fire({ icon: 'question', title: 'Terima Proyek?', text: 'Anda akan bertanggung jawab atas proyek ini. Pastikan Anda siap sebelum melanjutkan.', showCancelButton: true, confirmButtonText: '✓ Ya, Terima', cancelButtonText: 'Batal', confirmButtonColor: '#16a34a', cancelButtonColor: '#64748b' }).then(r => { if (r.isConfirmed) { $wire.accept(); } })"
                class="px-6 py-2.5 bg-green-600 hover:bg-green-700 active:bg-green-800 text-white rounded-xl font-semibold transition shadow-sm">
                Terima Proyek
            </button>
            <button
                @click="Swal.fire({ icon: 'warning', title: 'Tolak Permintaan?', text: 'Permintaan dari klien ini akan ditolak dan klien akan diberi notifikasi. Tindakan ini tidak dapat dibatalkan.', showCancelButton: true, confirmButtonText: 'Ya, Tolak', cancelButtonText: 'Batal', confirmButtonColor: '#dc2626', cancelButtonColor: '#64748b' }).then(r => { if (r.isConfirmed) { $wire.reject(); } })"
                class="px-6 py-2.5 bg-red-50 hover:bg-red-100 text-red-700 border border-red-200 rounded-xl font-semibold transition">
                Tolak
            </button>
        </div>
    @else
        <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 text-center text-slate-600">
            Proyek ini telah {{ strtolower($project->status->label()) }}.
        </div>
    @endif
</div>
