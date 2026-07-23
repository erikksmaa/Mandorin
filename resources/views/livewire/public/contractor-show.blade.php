<x-slot:seo>
    <x-public.seo
        :title="$contractor->user->name . ' — Profil Kontraktor | Mandorin'"
        :description="$contractor->bio ?? 'Lihat profil, portfolio, dan layanan ' . $contractor->user->name . ' di Mandorin.'"
    />
</x-slot:seo>

<div>
    <livewire:layout.navigation />

<main>
    {{-- Breadcrumb --}}
    <div class="bg-slate-50 border-b border-slate-200 py-3">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex items-center gap-2 text-sm text-slate-500" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" wire:navigate class="hover:text-navy transition">Beranda</a>
                <span aria-hidden="true">›</span>
                <a href="{{ route('public.contractors.index') }}" wire:navigate class="hover:text-navy transition">Kontraktor</a>
                <span aria-hidden="true">›</span>
                <span class="text-slate-800 font-medium truncate">{{ $contractor->user->name }}</span>
            </nav>
        </div>
    </div>

    <div class="bg-slate-50 min-h-screen py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-3 gap-8">

                {{-- LEFT: Sidebar Info --}}
                <aside class="lg:col-span-1 space-y-5">

                    {{-- Profil Card --}}
                    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm text-center">
                        {{-- Foto --}}
                        <div class="w-24 h-24 rounded-2xl overflow-hidden bg-slate-100 mx-auto mb-4 border-2 border-slate-200">
                            @if($contractor->profile_photo)
                                <img src="{{ asset('storage/' . $contractor->profile_photo) }}"
                                     alt="Foto {{ $contractor->user->name }}"
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-navy text-white font-black text-3xl">
                                    {{ strtoupper(substr($contractor->user->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>

                        <h1 class="text-xl font-bold text-slate-800 mb-1">{{ $contractor->user->name }}</h1>

                        {{-- Status Verifikasi --}}
                        @if($contractor->verification_status?->value === 'verified')
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-verified-100 text-verified-700 mb-3">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Terverifikasi
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700 mb-3">Belum Terverifikasi</span>
                        @endif

                        {{-- Rating --}}
                        <div class="flex items-center justify-center gap-1.5 mb-1">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-4 h-4 {{ $i <= round($contractor->rating ?? 0) ? 'text-amber-400' : 'text-slate-200' }}"
                                     fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                            <span class="text-sm font-bold text-slate-700">{{ number_format($contractor->rating ?? 0, 1) }}</span>
                        </div>
                        <p class="text-xs text-slate-400 mb-4">{{ $contractor->total_reviews ?? 0 }} ulasan • {{ $contractor->total_projects ?? 0 }} proyek</p>

                        {{-- Stats --}}
                        <div class="grid grid-cols-2 gap-3 mb-5 text-center">
                            <div class="bg-slate-50 rounded-xl p-3">
                                <div class="text-lg font-black text-navy" style="font-family: 'Big Shoulders Display', sans-serif;">{{ $contractor->total_projects ?? 0 }}</div>
                                <div class="text-[10px] text-slate-400 uppercase tracking-wide">Proyek</div>
                            </div>
                            <div class="bg-slate-50 rounded-xl p-3">
                                <div class="text-lg font-black text-navy" style="font-family: 'Big Shoulders Display', sans-serif;">{{ $contractor->total_reviews ?? 0 }}</div>
                                <div class="text-[10px] text-slate-400 uppercase tracking-wide">Ulasan</div>
                            </div>
                        </div>

                        {{-- CTA Buttons --}}
                        <div class="space-y-2">
                            {{-- Sewa --}}
                            @if($contractor->verification_status?->value === 'verified')
                                <button wire:click="hire"
                                        class="w-full py-3 px-4 bg-orange-500 hover:bg-orange-600 text-white text-sm font-bold rounded-xl transition shadow-sm"
                                        id="hire-btn">
                                    Sewa Kontraktor Ini
                                </button>
                            @endif

                            {{-- WhatsApp --}}
                            @if($contractor->user->phone)
                                @php
                                    $waPhone = preg_replace('/[^0-9]/', '', $contractor->user->phone);
                                    if (str_starts_with($waPhone, '0')) $waPhone = '62' . substr($waPhone, 1);
                                    $waMsg = "Halo *{$contractor->user->name}*, saya ingin menanyakan layanan konstruksi Anda yang tercantum di Mandorin. Apakah Anda tersedia untuk konsultasi?";
                                    $waUrl = 'https://wa.me/' . $waPhone . '?text=' . urlencode($waMsg);
                                @endphp
                                <a href="{{ $waUrl }}" target="_blank" rel="noopener"
                                   class="flex items-center justify-center gap-2 w-full py-3 px-4 bg-green-500 hover:bg-green-600 text-white text-sm font-semibold rounded-xl transition"
                                   id="whatsapp-btn" aria-label="Hubungi via WhatsApp">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.126 1.533 5.854L0 24l6.293-1.51C8.037 23.472 9.981 24 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.892 0-3.658-.516-5.168-1.414l-.37-.22-3.734.896.937-3.627-.242-.378A9.944 9.944 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/>
                                    </svg>
                                    Chat via WhatsApp
                                </a>
                            @endif
                        </div>
                    </div>

                    {{-- Lokasi --}}
                    @if($contractor->address)
                        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                            <h2 class="text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Lokasi</h2>
                            <div class="flex items-start gap-2">
                                <svg class="w-4 h-4 text-slate-400 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                </svg>
                                <p class="text-sm text-slate-700">{{ $contractor->address }}</p>
                            </div>
                        </div>
                    @endif

                    {{-- Layanan --}}
                    @if($contractor->services->isNotEmpty())
                        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                            <h2 class="text-xs font-bold text-slate-500 uppercase tracking-wide mb-3">Layanan</h2>
                            <div class="flex flex-wrap gap-2">
                                @foreach($contractor->services as $svc)
                                    <span class="px-3 py-1.5 bg-navy/5 text-navy text-xs font-semibold rounded-full border border-navy/10">
                                        {{ $svc->name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </aside>

                {{-- RIGHT: Main Content --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- Bio --}}
                    @if($contractor->bio)
                        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                            <h2 class="font-bold text-slate-800 mb-3">Tentang</h2>
                            <p class="text-slate-600 text-sm leading-relaxed">{{ $contractor->bio }}</p>
                        </div>
                    @endif

                    {{-- Portfolio --}}
                    @if($contractor->portfolios->isNotEmpty())
                        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                            <div class="flex items-center justify-between mb-4">
                                <h2 class="font-bold text-slate-800">Portfolio</h2>
                                <a href="{{ route('public.portfolios.index') }}" wire:navigate
                                   class="text-xs text-orange-500 hover:text-orange-600 font-semibold">Lihat semua →</a>
                            </div>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                                @foreach($contractor->portfolios as $port)
                                    <x-public.portfolio-card :portfolio="$port" :showContractor="false" />
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Kontraktor Terkait --}}
                    @if($related->isNotEmpty())
                        <div>
                            <h2 class="font-bold text-slate-800 mb-4">Kontraktor Lainnya</h2>
                            <div class="grid sm:grid-cols-3 gap-4">
                                @foreach($related as $rel)
                                    <x-public.contractor-card :contractor="$rel" />
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</main>

    <x-public.footer />
</div>
