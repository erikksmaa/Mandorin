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
        <div class="flex gap-4">
            <div x-data="{ showAcceptModal: false }">
                <button @click="showAcceptModal = true" class="px-6 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-xl font-medium transition">
                    Terima Proyek
                </button>
                
                <!-- Accept Confirmation Modal -->
                <div x-show="showAcceptModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
                    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                        <div x-show="showAcceptModal" @click="showAcceptModal = false" class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"></div>
                        <div class="inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-2xl shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                            <div class="sm:flex sm:items-start">
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                    <h3 class="text-lg font-medium leading-6 text-gray-900">Terima Proyek</h3>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500">Apakah Anda yakin ingin menerima proyek ini? Anda akan mulai bertanggung jawab terhadap proyek ini.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                                <button type="button" wire:click="accept" class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-green-600 border border-transparent rounded-xl shadow-sm hover:bg-green-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                                    Ya, Terima
                                </button>
                                <button type="button" @click="showAcceptModal = false" class="mt-3 inline-flex justify-center w-full px-4 py-2 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-xl shadow-sm hover:bg-gray-50 focus:outline-none sm:mt-0 sm:w-auto sm:text-sm">
                                    Batal
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div x-data="{ showRejectModal: false }">
                <button @click="showRejectModal = true" class="px-6 py-2.5 bg-red-100 text-red-700 hover:bg-red-200 rounded-xl font-medium transition">
                    Tolak
                </button>
                
                <!-- Reject Confirmation Modal -->
                <div x-show="showRejectModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
                    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                        <div x-show="showRejectModal" @click="showRejectModal = false" class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"></div>
                        <div class="inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-2xl shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                            <div class="sm:flex sm:items-start">
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                    <h3 class="text-lg font-medium leading-6 text-gray-900">Tolak Proyek</h3>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500">Apakah Anda yakin ingin menolak permintaan proyek ini?</p>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                                <button type="button" wire:click="reject" class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-red-600 border border-transparent rounded-xl shadow-sm hover:bg-red-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                                    Ya, Tolak
                                </button>
                                <button type="button" @click="showRejectModal = false" class="mt-3 inline-flex justify-center w-full px-4 py-2 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-xl shadow-sm hover:bg-gray-50 focus:outline-none sm:mt-0 sm:w-auto sm:text-sm">
                                    Batal
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 text-center text-slate-600">
            Proyek ini telah {{ strtolower($project->status->label()) }}.
        </div>
    @endif
</div>
