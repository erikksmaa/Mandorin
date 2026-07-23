<x-slot:seo>
    <x-public.seo :title="$portfolio->title . ' — Portfolio | Mandorin'" :description="$portfolio->description ??
        'Lihat hasil kerja proyek ' .
            $portfolio->title .
            ' oleh ' .
            ($portfolio->contractorProfile->user->name ?? 'kontraktor') .
            ' di Mandorin.'" />
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
                    <a href="{{ route('public.portfolios.index') }}" wire:navigate
                        class="hover:text-navy transition">Portfolio</a>
                    <span aria-hidden="true">›</span>
                    <span class="text-slate-800 font-medium truncate">{{ $portfolio->title }}</span>
                </nav>
            </div>
        </div>

        <div class="bg-slate-50 min-h-screen py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden mb-8">
                    {{-- Header --}}
                    <div class="p-6 md:p-8 border-b border-slate-100">
                        <h1 class="text-2xl md:text-3xl font-black text-slate-900 mb-4"
                            style="font-family: 'Big Shoulders Display', sans-serif;">
                            {{ $portfolio->title }}
                        </h1>

                        <div class="flex flex-wrap items-center gap-4 text-sm text-slate-500">
                            <div class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>{{ $portfolio->created_at->translatedFormat('d F Y') }}</span>
                            </div>

                            {{-- Mandor Info --}}
                            <div class="flex items-center gap-2 border-l border-slate-200 pl-4">
                                Dikerjakan oleh:
                                <a href="{{ route('public.contractors.show', $portfolio->contractorProfile) }}"
                                    wire:navigate class="flex items-center gap-2 hover:text-navy group transition">
                                    <div
                                        class="w-6 h-6 rounded-full overflow-hidden bg-slate-100 border border-slate-200">
                                        @if ($portfolio->contractorProfile->profile_photo)
                                            <img src="{{ asset('storage/' . $portfolio->contractorProfile->profile_photo) }}"
                                                alt="{{ $portfolio->contractorProfile->user->name }}"
                                                class="w-full h-full object-cover">
                                        @else
                                            <div
                                                class="w-full h-full bg-navy text-white text-[10px] flex items-center justify-center font-bold">
                                                {{ strtoupper(substr($portfolio->contractorProfile->user->name ?? '?', 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>
                                    <span
                                        class="font-semibold text-slate-700 group-hover:text-navy">{{ $portfolio->contractorProfile->user->name ?? 'Kontraktor' }}</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Before & After Compare --}}
                    <div class="p-6 md:p-8 bg-slate-50 border-b border-slate-100">
                        <div class="grid md:grid-cols-2 gap-6">
                            {{-- Before --}}
                            <div>
                                <h3
                                    class="text-xs font-bold text-slate-500 uppercase tracking-wide mb-3 flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-slate-300"></span>
                                    Sebelum (Before)
                                </h3>
                                <div
                                    class="rounded-xl overflow-hidden bg-slate-200 border border-slate-200 aspect-video shadow-sm">
                                    @if ($portfolio->before_photo)
                                        <img src="{{ asset('storage/' . $portfolio->before_photo) }}"
                                            alt="Kondisi sebelum" class="w-full h-full object-cover">
                                    @else
                                        <div
                                            class="w-full h-full flex flex-col items-center justify-center text-slate-400">
                                            <svg class="w-10 h-10 mb-2" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <span class="text-sm">Tidak ada foto</span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- After --}}
                            <div>
                                <h3
                                    class="text-xs font-bold text-orange-600 uppercase tracking-wide mb-3 flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-orange-500"></span>
                                    Sesudah (After)
                                </h3>
                                <div
                                    class="rounded-xl overflow-hidden bg-slate-200 border border-orange-200 aspect-video shadow-sm relative">
                                    @if ($portfolio->after_photo)
                                        <img src="{{ asset('storage/' . $portfolio->after_photo) }}"
                                            alt="Kondisi sesudah" class="w-full h-full object-cover">
                                    @else
                                        <div
                                            class="w-full h-full flex flex-col items-center justify-center text-slate-400">
                                            <svg class="w-10 h-10 mb-2" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <span class="text-sm">Tidak ada foto</span>
                                        </div>
                                    @endif

                                    <div class="absolute top-3 right-3">
                                        <span
                                            class="bg-orange-500 text-white text-[10px] font-bold px-2.5 py-1 rounded-full shadow-lg flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                            Selesai
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Deskripsi --}}
                    <div class="p-6 md:p-8">
                        <h3 class="font-bold text-slate-800 mb-3 text-lg">Deskripsi Pekerjaan</h3>
                        <div class="prose prose-sm max-w-none text-slate-600">
                            {!! nl2br(e($portfolio->description ?? 'Tidak ada deskripsi rinci untuk portfolio ini.')) !!}
                        </div>

                        {{-- Layanan Terkait dari Mandor --}}
                        @if ($portfolio->contractorProfile->services->isNotEmpty())
                            <div class="mt-6 pt-6 border-t border-slate-100">
                                <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wide mb-3">Layanan Mandor
                                    Terkait</h4>
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($portfolio->contractorProfile->services as $svc)
                                        <a href="{{ route('public.contractors.index', ['layanan' => $svc->id]) }}"
                                            wire:navigate
                                            class="px-3 py-1.5 bg-navy/5 text-navy text-xs font-semibold rounded-full border border-navy/10 hover:bg-navy/10 transition">
                                            {{ $svc->name }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Portfolio Terkait --}}
                @if ($related->isNotEmpty())
                    <div class="mt-12">
                        <h2 class="text-2xl font-black text-slate-900 mb-6"
                            style="font-family: 'Big Shoulders Display', sans-serif;">
                            Portfolio Lainnya dari {{ $portfolio->contractorProfile->user->name ?? 'Mandor Ini' }}
                        </h2>
                        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
                            @foreach ($related as $rel)
                                <x-public.portfolio-card :portfolio="$rel" :showContractor="false" />
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </main>

    <x-public.footer />
</div>
