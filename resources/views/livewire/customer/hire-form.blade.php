<div>
    <div class="mb-4 text-sm text-slate-500">
        <a href="{{ route('public.contractors.index') }}" class="hover:text-navy">Cari Kontraktor</a>
        <span class="mx-2">&rsaquo;</span>
        <a href="{{ route('public.contractors.show', $contractorProfile) }}" class="hover:text-navy">Profil</a>
        <span class="mx-2">&rsaquo;</span>
        <span class="text-slate-700">Ajukan Proyek</span>
    </div>

    <h1 class="text-2xl font-bold text-slate-800 mb-6" style="font-family: 'Big Shoulders Display', sans-serif;">
        Ajukan Proyek Baru
    </h1>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Form Section -->
        <div class="lg:col-span-2">
            @if(session('error'))
                <div class="mb-6 bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded-xl">
                    {{ session('error') }}
                </div>
            @endif

            <form wire:submit="submit" class="bg-white border border-slate-200 shadow-sm rounded-2xl p-6 space-y-6">
                <div>
                    <label for="serviceId" class="block text-sm font-medium text-slate-700 mb-1">Pilih Layanan *</label>
                    <select id="serviceId" wire:model="serviceId" class="w-full rounded-xl border-slate-300 focus:border-navy focus:ring-navy shadow-sm">
                        <option value="">-- Pilih Layanan --</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}">{{ $service->name }}</option>
                        @endforeach
                    </select>
                    @error('serviceId') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="title" class="block text-sm font-medium text-slate-700 mb-1">Judul Proyek *</label>
                    <input type="text" id="title" wire:model="title" placeholder="Cth: Renovasi Atap Rumah" class="w-full rounded-xl border-slate-300 focus:border-navy focus:ring-navy shadow-sm">
                    @error('title') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-slate-700 mb-1">Deskripsi Detail *</label>
                    <textarea id="description" wire:model="description" rows="5" placeholder="Jelaskan kebutuhan proyek Anda secara detail..." class="w-full rounded-xl border-slate-300 focus:border-navy focus:ring-navy shadow-sm"></textarea>
                    @error('description') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="address" class="block text-sm font-medium text-slate-700 mb-1">Alamat Proyek *</label>
                    <textarea id="address" wire:model="address" rows="3" placeholder="Alamat lengkap lokasi proyek..." class="w-full rounded-xl border-slate-300 focus:border-navy focus:ring-navy shadow-sm"></textarea>
                    @error('address') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="estimatedFinishDate" class="block text-sm font-medium text-slate-700 mb-1">Target Selesai (Opsional)</label>
                    <input type="date" id="estimatedFinishDate" wire:model="estimatedFinishDate" class="w-full rounded-xl border-slate-300 focus:border-navy focus:ring-navy shadow-sm text-sm">
                    <span class="text-xs text-slate-400 mt-1 block">Estimasi tanggal penyelesaian proyek yang diharapkan.</span>
                    @error('estimatedFinishDate') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="pt-4 border-t border-slate-100">
                    <button type="submit" class="w-full py-3 px-4 bg-orange-500 hover:bg-orange-600 text-white rounded-xl font-bold transition shadow-sm text-lg flex justify-center items-center gap-2">
                        <span wire:loading.remove wire:target="submit">Ajukan Permintaan</span>
                        <span wire:loading wire:target="submit">Memproses...</span>
                    </button>
                    <p class="text-xs text-center text-slate-500 mt-3">
                        Kontraktor akan mereview permintaan Anda sebelum menyetujuinya.
                    </p>
                </div>
            </form>
        </div>

        <!-- Summary Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-white border border-slate-200 shadow-sm rounded-2xl p-6 sticky top-6">
                <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-4">Informasi Kontraktor</h3>
                
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-14 h-14 rounded-full overflow-hidden bg-slate-100 shrink-0">
                        @if ($contractorProfile->profile_photo)
                            <img src="{{ asset('storage/' . $contractorProfile->profile_photo) }}" alt="{{ $contractorProfile->user->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-navy text-white font-bold text-xl">
                                {{ substr($contractorProfile->user->name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-800">{{ $contractorProfile->user->name }}</h4>
                        <div class="flex items-center text-xs mt-1">
                            <span class="text-amber-500 mr-1">⭐</span>
                            <span class="font-mono text-slate-800 font-medium">{{ number_format($contractorProfile->rating ?? 0, 1) }}</span>
                            <span class="text-slate-400 ml-1">({{ $contractorProfile->total_reviews ?? 0 }})</span>
                        </div>
                    </div>
                </div>
                
                <div class="mb-4">
                    <p class="text-xs text-slate-500 mb-1">Layanan Tersedia:</p>
                    <div class="flex flex-wrap gap-1">
                        @foreach ($contractorProfile->services as $svc)
                            <span class="px-2 py-0.5 bg-slate-100 text-slate-600 text-[10px] rounded">{{ $svc->name }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
