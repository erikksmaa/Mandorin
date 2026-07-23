<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800" style="font-family: 'Big Shoulders Display', sans-serif;">
                Manajemen Profil & Portfolio
            </h1>
        </div>
        <div class="flex items-center gap-2">
            @if($profile->verification_status)
                <span class="px-3 py-1.5 rounded-lg text-xs font-semibold flex items-center gap-1.5 border
                    @if($profile->verification_status->value === 'pending') bg-amber-50 text-amber-700 border-amber-200
                    @elseif($profile->verification_status->value === 'verified') bg-verified-50 text-verified-700 border-verified-200
                    @elseif($profile->verification_status->value === 'rejected') bg-red-50 text-red-700 border-red-200
                    @else bg-slate-50 text-slate-700 border-slate-200 @endif
                ">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ $profile->verification_status->label() }}
                </span>
            @endif
            <button type="submit" form="profile-form" class="px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-lg text-sm font-semibold transition flex items-center gap-2 shadow-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span wire:loading.remove wire:target="save">Simpan Profil</span>
                <span wire:loading wire:target="save">Menyimpan...</span>
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 items-start">
        <!-- FORM UTAMA (7 Kolom) -->
        <div class="lg:col-span-7">
            <form id="profile-form" wire:submit="save" class="space-y-5">
                
                <!-- Info Dasar -->
                <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-5">
                    <h2 class="text-sm font-bold text-slate-800 mb-4 flex items-center gap-2 border-b border-slate-100 pb-2">
                        <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Informasi Dasar
                    </h2>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="sm:col-span-2 flex items-start gap-4 mb-2">
                            <div class="shrink-0">
                                @if ($profilePhoto)
                                    <img src="{{ $profilePhoto->temporaryUrl() }}" class="h-16 w-16 rounded-xl object-cover border border-slate-200 shadow-sm">
                                @elseif($profile->profile_photo)
                                    <img src="{{ asset('storage/' . $profile->profile_photo) }}" class="h-16 w-16 rounded-xl object-cover border border-slate-200 shadow-sm">
                                @else
                                    <div class="h-16 w-16 rounded-xl bg-slate-100 flex items-center justify-center text-slate-400 border border-slate-200">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-grow">
                                <label class="block text-xs font-semibold text-slate-600 mb-1">Update Foto Profil</label>
                                <input type="file" wire:model="profilePhoto" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-slate-50 file:text-navy hover:file:bg-slate-100 cursor-pointer">
                                @error('profilePhoto') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1">Nama / Pemilik</label>
                            <input type="text" value="{{ $user->name }}" disabled class="w-full bg-slate-50 border-slate-200 rounded-lg text-sm text-slate-500 py-2 cursor-not-allowed">
                        </div>
                        
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1">Kontak (Email/No.HP)</label>
                            <input type="text" value="{{ $user->email }} / {{ $user->phone }}" disabled class="w-full bg-slate-50 border-slate-200 rounded-lg text-sm text-slate-500 py-2 cursor-not-allowed">
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-xs font-semibold text-slate-600 mb-1">Bio Singkat</label>
                            <textarea wire:model="bio" rows="2" class="w-full border-slate-300 rounded-lg text-sm focus:border-navy focus:ring-navy focus:ring-opacity-50 py-2" placeholder="Tuliskan pengalaman atau spesialisasi Anda..."></textarea>
                            @error('bio') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-xs font-semibold text-slate-600 mb-1">Alamat Lengkap</label>
                            <textarea wire:model="address" rows="2" class="w-full border-slate-300 rounded-lg text-sm focus:border-navy focus:ring-navy focus:ring-opacity-50 py-2" placeholder="Domisili atau alamat operasional..."></textarea>
                            @error('address') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Layanan & Dokumen (Grid 2 Kolom Internal) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-5">
                        <h2 class="text-sm font-bold text-slate-800 mb-3 flex items-center gap-2 border-b border-slate-100 pb-2">
                            <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            Pilih Layanan
                        </h2>
                        <div class="space-y-2 max-h-48 overflow-y-auto pr-2 custom-scrollbar">
                            @foreach($allServices as $service)
                                <label class="flex items-center space-x-2.5 p-2 border border-slate-100 rounded-lg cursor-pointer hover:bg-slate-50 transition-colors">
                                    <input type="checkbox" wire:model="selectedServices" value="{{ $service->id }}" class="form-checkbox h-4 w-4 text-navy rounded border-slate-300 focus:ring-navy">
                                    <span class="text-xs font-medium text-slate-700">{{ $service->name }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('selectedServices') <span class="text-red-500 text-[10px] mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-5">
                        <h2 class="text-sm font-bold text-slate-800 mb-3 flex items-center gap-2 border-b border-slate-100 pb-2">
                            <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            Dokumen Validasi
                        </h2>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1">Identitas (KTP)</label>
                                <input type="file" wire:model="identityDocument" class="w-full text-xs text-slate-500 file:mr-3 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-[10px] file:font-semibold file:bg-slate-50 file:text-navy hover:file:bg-slate-100 cursor-pointer">
                                @error('identityDocument') <span class="text-red-500 text-[10px] block mt-1">{{ $message }}</span> @enderror
                                
                                @if($profile->identity_document)
                                    <div class="mt-1.5">
                                        <a href="{{ asset('storage/' . $profile->identity_document) }}" target="_blank" class="text-[10px] text-orange-500 hover:underline flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg> Lihat Tersimpan</a>
                                    </div>
                                @endif
                            </div>
                            
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1">Sertifikat / Bukti Usaha</label>
                                <input type="file" wire:model="certificateDocument" class="w-full text-xs text-slate-500 file:mr-3 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-[10px] file:font-semibold file:bg-slate-50 file:text-navy hover:file:bg-slate-100 cursor-pointer">
                                @error('certificateDocument') <span class="text-red-500 text-[10px] block mt-1">{{ $message }}</span> @enderror
                                
                                @if($profile->certificate_document)
                                    <div class="mt-1.5">
                                        <a href="{{ asset('storage/' . $profile->certificate_document) }}" target="_blank" class="text-[10px] text-orange-500 hover:underline flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg> Lihat Tersimpan</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>

        <!-- PORTFOLIO SECTION (5 Kolom) -->
        <div class="lg:col-span-5 h-full">
            <div class="bg-white border border-slate-200 shadow-sm rounded-xl flex flex-col h-full">
                <!-- Header -->
                <div class="p-4 border-b border-slate-100 flex justify-between items-center">
                    <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                        <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Portfolio / Karya
                    </h2>
                    <a href="{{ route('contractor.portfolio.form') }}" class="px-2.5 py-1 bg-navy hover:bg-navy-700 text-white rounded-md text-[11px] font-semibold transition flex items-center gap-1 shadow-sm">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Tambah
                    </a>
                </div>
                
                <!-- Body List -->
                <div class="p-4 flex-grow max-h-[600px] overflow-y-auto custom-scrollbar bg-slate-50/50">
                    @if($profile->portfolios->isEmpty())
                        <div class="h-full min-h-[200px] flex flex-col items-center justify-center text-center px-4">
                            <div class="w-12 h-12 bg-slate-100 text-slate-300 rounded-full flex items-center justify-center mb-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            <h3 class="text-sm font-semibold text-slate-700 mb-1">Belum ada portfolio</h3>
                            <p class="text-[11px] text-slate-500 leading-relaxed mb-4">Tambahkan foto hasil kerja untuk meyakinkan calon pelanggan Anda.</p>
                        </div>
                    @else
                        <div class="grid grid-cols-2 gap-3">
                            @foreach($profile->portfolios as $portfolio)
                                <div class="bg-white border border-slate-200 rounded-lg overflow-hidden group hover:border-navy/30 transition-colors shadow-sm">
                                    <div class="relative h-24 bg-slate-100">
                                        @if($portfolio->after_photo)
                                            <img src="{{ asset('storage/' . $portfolio->after_photo) }}" class="w-full h-full object-cover">
                                        @elseif($portfolio->before_photo)
                                            <img src="{{ asset('storage/' . $portfolio->before_photo) }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-slate-300 text-xs font-medium">Tanpa Foto</div>
                                        @endif
                                        <div class="absolute inset-0 bg-navy/80 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                                            <a href="{{ route('contractor.portfolio.form', $portfolio->id) }}" class="px-3 py-1.5 bg-white text-navy font-bold rounded text-[10px] shadow-sm hover:scale-105 transition-transform">
                                                Edit Data
                                            </a>
                                        </div>
                                    </div>
                                    <div class="p-2.5">
                                        <h3 class="text-xs font-bold text-slate-800 mb-0.5 truncate" title="{{ $portfolio->title }}">{{ $portfolio->title }}</h3>
                                        <p class="text-[10px] text-slate-400 truncate">{{ $portfolio->category ?? 'Portfolio' }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Custom Scrollbar for compact lists */
.custom-scrollbar::-webkit-scrollbar {
    width: 4px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent; 
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #cbd5e1; 
    border-radius: 10px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: #94a3b8; 
}
</style>
