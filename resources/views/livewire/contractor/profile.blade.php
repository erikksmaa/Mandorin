<div class="max-w-5xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-bold text-slate-800 mb-6" style="font-family: 'Big Shoulders Display', sans-serif;">
        Profil Kontraktor
    </h1>

    @if (session()->has('success'))
        <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-xl text-sm font-medium">
            {{ session('success') }}
        </div>
    @endif

    @if($profile->verification_status)
        <div class="mb-6 p-4 rounded-xl text-sm font-medium flex items-center gap-2
            @if($profile->verification_status->value === 'pending') bg-amber-100 text-amber-700
            @elseif($profile->verification_status->value === 'verified') bg-green-100 text-green-700
            @elseif($profile->verification_status->value === 'rejected') bg-red-100 text-red-700
            @else bg-slate-100 text-slate-700 @endif
        ">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            Status Verifikasi: {{ $profile->verification_status->label() }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        <div class="lg:col-span-2 space-y-6">
            <!-- Form Utama -->
            <form wire:submit="save" class="space-y-6">
                <div class="bg-white border border-slate-200 shadow-sm rounded-2xl p-6">
                    <h2 class="text-lg font-bold text-slate-800 mb-4">Informasi Utama</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Nama (Sesuai Akun)</label>
                            <input type="text" value="{{ $user->name }}" disabled class="w-full bg-slate-50 border-slate-200 rounded-lg text-sm text-slate-500 cursor-not-allowed">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Email / Telepon</label>
                            <input type="text" value="{{ $user->email }} / {{ $user->phone }}" disabled class="w-full bg-slate-50 border-slate-200 rounded-lg text-sm text-slate-500 cursor-not-allowed">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Bio Singkat</label>
                            <textarea wire:model="bio" rows="3" class="w-full border-slate-300 rounded-lg text-sm focus:border-navy focus:ring focus:ring-navy focus:ring-opacity-50 placeholder-slate-400" placeholder="Ceritakan sedikit tentang Anda..."></textarea>
                            @error('bio') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Alamat</label>
                            <textarea wire:model="address" rows="2" class="w-full border-slate-300 rounded-lg text-sm focus:border-navy focus:ring focus:ring-navy focus:ring-opacity-50 placeholder-slate-400" placeholder="Alamat lengkap..."></textarea>
                            @error('address') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Foto Profil Baru (Opsional)</label>
                            <input type="file" wire:model="profilePhoto" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-slate-50 file:text-navy hover:file:bg-slate-100">
                            @error('profilePhoto') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            
                            @if ($profilePhoto)
                                <div class="mt-2 text-sm text-slate-500">Preview: Foto akan diperbarui saat disimpan.</div>
                            @elseif($profile->profile_photo)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $profile->profile_photo) }}" class="h-16 w-16 rounded-full object-cover border border-slate-200">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="bg-white border border-slate-200 shadow-sm rounded-2xl p-6">
                    <h2 class="text-lg font-bold text-slate-800 mb-4">Dokumen Verifikasi</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">KTP / Identitas (Baru)</label>
                            <input type="file" wire:model="identityDocument" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-slate-50 file:text-navy hover:file:bg-slate-100">
                            @error('identityDocument') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            
                            @if($profile->identity_document)
                                <div class="mt-2 text-xs">
                                    <a href="{{ asset('storage/' . $profile->identity_document) }}" target="_blank" class="text-navy hover:underline">Lihat Dokumen Saat Ini</a>
                                </div>
                            @endif
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Sertifikat / Portofolio Perusahaan (Baru)</label>
                            <input type="file" wire:model="certificateDocument" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-slate-50 file:text-navy hover:file:bg-slate-100">
                            @error('certificateDocument') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            
                            @if($profile->certificate_document)
                                <div class="mt-2 text-xs">
                                    <a href="{{ asset('storage/' . $profile->certificate_document) }}" target="_blank" class="text-navy hover:underline">Lihat Dokumen Saat Ini</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-xl font-medium transition flex items-center gap-2">
                        <span wire:loading.remove wire:target="save">Simpan Perubahan</span>
                        <span wire:loading wire:target="save">Menyimpan...</span>
                    </button>
                </div>
            </form>
        </div>

        <div class="lg:col-span-1">
            <div class="bg-white border border-slate-200 shadow-sm rounded-2xl p-6">
                <h2 class="text-lg font-bold text-slate-800 mb-4">Layanan Anda</h2>
                @if($profile->services->isEmpty())
                    <p class="text-slate-500 text-sm">Belum ada layanan yang dipilih.</p>
                @else
                    <div class="flex flex-wrap gap-2">
                        @foreach($profile->services as $service)
                            <span class="px-3 py-1 bg-slate-100 text-slate-700 rounded-full text-sm">
                                {{ $service->name }}
                            </span>
                        @endforeach
                    </div>
                @endif
                <div class="mt-4 pt-4 border-t border-slate-100">
                    <p class="text-xs text-slate-500">Layanan hanya dapat diubah melalui admin.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Portfolio Section -->
    <div class="mb-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-slate-800" style="font-family: 'Big Shoulders Display', sans-serif;">
                Portfolio Pekerjaan
            </h2>
            <a href="{{ route('contractor.portfolio.form') }}" class="px-4 py-2 bg-navy hover:bg-navy-700 text-white rounded-xl text-sm font-medium transition">
                Tambah Portfolio
            </a>
        </div>

        @if($profile->portfolios->isEmpty())
            <div class="bg-slate-50 border border-slate-200 border-dashed rounded-2xl p-8 text-center">
                <p class="text-slate-500">Belum ada portofolio yang ditambahkan.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($profile->portfolios as $portfolio)
                    <div class="bg-white border border-slate-200 shadow-sm rounded-2xl overflow-hidden flex flex-col group">
                        <div class="relative h-48 bg-slate-100">
                            @if($portfolio->after_photo)
                                <img src="{{ asset('storage/' . $portfolio->after_photo) }}" class="w-full h-full object-cover">
                            @elseif($portfolio->before_photo)
                                <img src="{{ asset('storage/' . $portfolio->before_photo) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-400 text-xs">Tanpa Foto</div>
                            @endif
                            <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                                <a href="{{ route('contractor.portfolio.form', $portfolio->id) }}" class="px-4 py-2 bg-white text-navy font-bold rounded-lg text-sm">
                                    Edit
                                </a>
                            </div>
                        </div>
                        <div class="p-4 flex-grow">
                            <h3 class="font-bold text-slate-800 mb-1">{{ $portfolio->title }}</h3>
                            <p class="text-sm text-slate-500 line-clamp-2">{{ $portfolio->description }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
