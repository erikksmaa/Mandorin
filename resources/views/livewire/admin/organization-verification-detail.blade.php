<div>
    <div class="mb-4">
        <a href="{{ route('admin.verification.index') }}" class="inline-flex items-center text-sm text-slate-500 hover:text-slate-800">
            &larr; Kembali ke Antrian
        </a>
    </div>

    @if (session('status'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 rounded-xl p-4 text-sm font-medium">
            {{ session('status') }}
        </div>
    @endif

    <div class="flex items-center justify-between mb-6">
        <div>
            <span class="text-xs font-mono text-slate-400">{{ $organization->organization_code }}</span>
            <h1 class="text-2xl font-bold text-slate-800" style="font-family: 'Big Shoulders Display', sans-serif;">
                {{ $organization->name ?? 'Detail Organisasi' }}
            </h1>
        </div>
        @php
            $statusVal = $organization->status instanceof \BackedEnum ? $organization->status->value : $organization->status;
        @endphp
        <span class="px-3 py-1 rounded-full text-sm font-medium {{ $statusVal === 'active' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">
            {{ $statusVal === 'active' ? 'Terverifikasi' : 'Belum Aktif' }}
        </span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white border border-slate-200 shadow-sm rounded-2xl p-6">
                <div class="flex flex-col items-center text-center mb-6">
                    <div class="w-24 h-24 rounded-full bg-navy overflow-hidden mb-4 flex items-center justify-center text-white font-bold text-3xl">
                        @if($organization->logo)
                            <img src="{{ asset('storage/' . $organization->logo) }}" class="w-full h-full object-cover">
                        @else
                            {{ strtoupper(substr($organization->name ?? '?', 0, 1)) }}
                        @endif
                    </div>
                    <div class="font-bold text-lg text-slate-800">{{ $organization->name ?? '-' }}</div>
                    <div class="text-xs text-orange-600 font-semibold">{{ $organization->category?->name ?? 'Organisasi Kepemudaan' }}</div>
                </div>

                <div class="space-y-4 text-sm">
                    <div>
                        <div class="text-xs text-slate-500 mb-1">Penanggung Jawab / Ketua</div>
                        <div class="font-medium text-slate-800">{{ $organization->creator?->name ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-slate-500 mb-1">Email</div>
                        <div class="font-medium text-slate-800">{{ $organization->email ?? $organization->creator?->email ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-slate-500 mb-1">Telepon</div>
                        <div class="font-medium text-slate-800">{{ $organization->phone ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-slate-500 mb-1">Alamat</div>
                        <div class="font-medium text-slate-800">{{ $organization->address ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-slate-500 mb-1">Deskripsi Profil</div>
                        <div class="text-slate-700 bg-slate-50 p-3 rounded-lg text-xs leading-relaxed">{{ $organization->description ?? 'Belum ada deskripsi profil.' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white border border-slate-200 shadow-sm rounded-2xl p-6">
                <h3 class="font-bold text-slate-800 mb-4 border-b border-slate-100 pb-2">Dokumen SK / Legalitas Organisasi</h3>


                <h3 class="font-bold text-slate-800 mb-4 border-b border-slate-100 pb-2 mt-8">Struktur Anggota Terdaftar</h3>
                @forelse($organization->members as $member)
                    <div class="flex items-center justify-between py-2 border-b border-slate-100 text-sm">
                        <div class="font-medium text-slate-800">{{ $member->user?->name ?? '-' }}</div>
                        <div class="text-xs text-slate-500">({{ $member->position?->value ?? '-' }})</div>
                    </div>
                @empty
                    <div class="p-4 bg-slate-50 rounded-xl text-center text-slate-500 text-xs">
                        Belum ada anggota yang didaftarkan.
                    </div>
                @endforelse
            </div>

            <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-6">
                <h3 class="font-bold text-slate-800 mb-4">Aksi Verifikasi Admin</h3>
                <div class="flex gap-3">
                    <button
                        @click="Swal.fire({ icon: 'question', title: 'Setujui Verifikasi?', html: 'Organisasi <strong>{{ $organization->name }}</strong> akan disetujui dan statusnya diaktifkan.', showCancelButton: true, confirmButtonText: '✓ Ya, Setujui', cancelButtonText: 'Batal', confirmButtonColor: '#059669', cancelButtonColor: '#64748b' }).then(r => { if (r.isConfirmed) { $wire.approve(); } })"
                        class="px-5 py-2.5 bg-emerald-500 hover:bg-emerald-600 active:bg-emerald-700 text-white rounded-xl font-semibold transition flex-1 shadow-sm">
                        ✓ Setujui & Aktifkan
                    </button>
                    <button
                        @click="Swal.fire({ icon: 'warning', title: 'Tolak / Nonaktifkan?', html: 'Organisasi <strong>{{ $organization->name }}</strong> akan dinonaktifkan.', showCancelButton: true, confirmButtonText: 'Ya, Nonaktifkan', cancelButtonText: 'Batal', confirmButtonColor: '#dc2626', cancelButtonColor: '#64748b' }).then(r => { if (r.isConfirmed) { $wire.reject(); } })"
                        class="px-5 py-2.5 bg-red-500 hover:bg-red-600 active:bg-red-700 text-white rounded-xl font-semibold transition flex-1 shadow-sm">
                        ✕ Nonaktifkan Organisasi
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
