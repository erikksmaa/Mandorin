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
        <h1 class="text-2xl font-bold text-slate-800" style="font-family: 'Big Shoulders Display', sans-serif;">
            {{ $contractorProfile->user->name ?? 'Detail Kontraktor' }}
        </h1>
        <span class="px-3 py-1 rounded-full text-sm font-medium {{ $contractorProfile->verification_status->color() }}">
            {{ $contractorProfile->verification_status->label() }}
        </span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white border border-slate-200 shadow-sm rounded-2xl p-6">
                <div class="flex flex-col items-center text-center mb-6">
                    <div class="w-24 h-24 rounded-full bg-navy overflow-hidden mb-4 flex items-center justify-center">
                        <span class="text-white font-bold text-3xl">{{ substr($contractorProfile->user->name ?? '?', 0, 1) }}</span>
                    </div>
                    <div class="font-bold text-lg text-slate-800">{{ $contractorProfile->user->name ?? '-' }}</div>
                    <div class="text-sm text-slate-500">{{ $contractorProfile->address ?? 'Kontraktor' }}</div>
                </div>

                <div class="space-y-4">
                    <div>
                        <div class="text-xs text-slate-500 mb-1">Email</div>
                        <div class="text-sm font-medium text-slate-800">{{ $contractorProfile->user->email ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-slate-500 mb-1">Telepon</div>
                        <div class="text-sm font-medium text-slate-800">{{ $contractorProfile->user->phone ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-slate-500 mb-1">Alamat</div>
                        <div class="text-sm font-medium text-slate-800">{{ $contractorProfile->address ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-slate-500 mb-1">Bio</div>
                        <div class="text-sm text-slate-700 bg-slate-50 p-3 rounded-lg">{{ $contractorProfile->bio ?? 'Belum ada bio' }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-slate-500 mb-2">Layanan</div>
                        <div class="flex flex-wrap gap-2">
                            @forelse($contractorProfile->services as $service)
                                <span class="px-2.5 py-1 bg-navy text-white rounded-lg text-xs">
                                    {{ $service->name }}
                                </span>
                            @empty
                                <span class="text-sm text-slate-500">Tidak ada data</span>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white border border-slate-200 shadow-sm rounded-2xl p-6">
                <h3 class="font-bold text-slate-800 mb-4 border-b border-slate-100 pb-2">Dokumen Identitas (KTP/Legalitas)</h3>
                @if($contractorProfile->identity_document)
                    <div class="border border-slate-200 rounded-xl overflow-hidden mb-4 bg-slate-50">
                        @if(Str::endsWith($contractorProfile->identity_document, ['.jpg', '.jpeg', '.png']))
                            <img src="{{ asset('storage/' . $contractorProfile->identity_document) }}" class="max-w-full h-auto mx-auto">
                        @else
                            <div class="p-6 text-center">
                                <a href="{{ asset('storage/' . $contractorProfile->identity_document) }}" target="_blank" class="text-orange-500 hover:underline">
                                    Lihat Dokumen
                                </a>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="p-6 bg-slate-50 rounded-xl border border-dashed border-slate-300 text-center text-slate-500 mb-4">
                        Tidak ada dokumen identitas yang dilampirkan.
                    </div>
                @endif

                <h3 class="font-bold text-slate-800 mb-4 border-b border-slate-100 pb-2 mt-8">Sertifikat / Portofolio Utama</h3>
                @if($contractorProfile->certificate_document)
                    <div class="border border-slate-200 rounded-xl overflow-hidden bg-slate-50">
                        @if(Str::endsWith($contractorProfile->certificate_document, ['.jpg', '.jpeg', '.png']))
                            <img src="{{ asset('storage/' . $contractorProfile->certificate_document) }}" class="max-w-full h-auto mx-auto">
                        @else
                            <div class="p-6 text-center">
                                <a href="{{ asset('storage/' . $contractorProfile->certificate_document) }}" target="_blank" class="text-orange-500 hover:underline">
                                    Lihat Dokumen
                                </a>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="p-6 bg-slate-50 rounded-xl border border-dashed border-slate-300 text-center text-slate-500">
                        Tidak ada dokumen sertifikat yang dilampirkan.
                    </div>
                @endif
            </div>

            <div class="bg-white border border-slate-200 shadow-sm rounded-2xl p-6" x-data="{ confirmingApprove: false, confirmingReject: false }">
                <h3 class="font-bold text-slate-800 mb-4">Aksi Verifikasi</h3>
                <div class="flex gap-4">
                    <button @click="confirmingApprove = true; confirmingReject = false" class="px-6 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl font-medium transition flex-1">
                        Setujui Verifikasi
                    </button>
                    <button @click="confirmingReject = true; confirmingApprove = false" class="px-6 py-2.5 bg-red-500 hover:bg-red-600 text-white rounded-xl font-medium transition flex-1">
                        Tolak Verifikasi
                    </button>
                </div>

                <!-- Confirm Approve -->
                <div x-show="confirmingApprove" style="display: none;" class="mt-4 p-4 border border-emerald-200 bg-emerald-50 rounded-xl">
                    <p class="text-emerald-800 text-sm mb-3">Anda yakin ingin menyetujui kontraktor ini? Mereka akan bisa mulai menerima proyek.</p>
                    <div class="flex gap-2">
                        <button wire:click="approve" class="px-4 py-1.5 bg-emerald-500 text-white rounded-lg text-sm font-medium">Ya, Setujui</button>
                        <button @click="confirmingApprove = false" class="px-4 py-1.5 bg-white border border-emerald-200 text-emerald-700 rounded-lg text-sm font-medium">Batal</button>
                    </div>
                </div>

                <!-- Confirm Reject -->
                <div x-show="confirmingReject" style="display: none;" class="mt-4 p-4 border border-red-200 bg-red-50 rounded-xl">
                    <p class="text-red-800 text-sm mb-3">Anda yakin ingin menolak kontraktor ini? Anda bisa memberikan pesan penolakan nanti jika perlu.</p>
                    <div class="flex gap-2">
                        <button wire:click="reject" class="px-4 py-1.5 bg-red-500 text-white rounded-lg text-sm font-medium">Ya, Tolak</button>
                        <button @click="confirmingReject = false" class="px-4 py-1.5 bg-white border border-red-200 text-red-700 rounded-lg text-sm font-medium">Batal</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
