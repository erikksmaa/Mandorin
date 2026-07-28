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

                @forelse($documents as $doc)
                    @php
                        $ext = strtolower(pathinfo($doc, PATHINFO_EXTENSION));
                        $fileName = basename($doc);
                        $fileUrl = asset('storage/' . $doc);
                    @endphp
                    <div class="mb-6 p-4 bg-slate-50 border border-slate-200 rounded-xl space-y-3">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-200 pb-3">
                            <div class="flex items-center gap-2 min-w-0">
                                @if(in_array($ext, ['jpg', 'jpeg', 'png', 'webp']))
                                    <svg class="w-5 h-5 text-blue-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                @elseif($ext === 'pdf')
                                    <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                @else
                                    <svg class="w-5 h-5 text-slate-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                @endif
                                <span class="font-medium text-xs text-slate-700 truncate" title="{{ $fileName }}">{{ $fileName }}</span>
                            </div>
                            <div class="flex items-center gap-2 shrink-0">
                                <a href="{{ $fileUrl }}" target="_blank" class="px-3 py-1.5 bg-white border border-slate-300 text-slate-700 hover:bg-slate-100 rounded-lg text-xs font-semibold transition inline-flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    Lihat Dokumen
                                </a>
                                <button wire:click="downloadDocument('{{ $doc }}')" class="px-3 py-1.5 bg-navy text-white hover:bg-navy-700 rounded-lg text-xs font-semibold transition inline-flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                    Download Dokumen
                                </button>
                            </div>
                        </div>

                        {{-- Preview Content --}}
                        <div>
                            @if(in_array($ext, ['jpg', 'jpeg', 'png', 'webp']))
                                <div class="bg-white p-2 rounded-lg border border-slate-200 flex justify-center">
                                    <img src="{{ $fileUrl }}" alt="{{ $fileName }}" class="max-h-72 object-contain rounded">
                                </div>
                            @elseif($ext === 'pdf')
                                <div class="bg-white rounded-lg border border-slate-200 overflow-hidden">
                                    <iframe src="{{ $fileUrl }}" class="w-full h-80" frameBorder="0"></iframe>
                                </div>
                            @else
                                <div class="p-3 bg-white rounded-lg text-xs text-slate-500 text-center border border-slate-200">
                                    Preview tidak tersedia untuk format file ini. Klik <strong>Lihat Dokumen</strong> atau <strong>Download Dokumen</strong>.
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="p-4 bg-amber-50 border border-amber-200 text-amber-800 rounded-xl text-xs font-medium text-center">
                        Belum ada dokumen SK / legalitas yang diunggah oleh organisasi ini.
                    </div>
                @endforelse

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
