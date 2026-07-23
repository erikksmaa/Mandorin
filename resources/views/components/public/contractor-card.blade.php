@props(['contractor'])

@php
    /** @var \App\Models\ContractorProfile $contractor */
@endphp

<div class="bg-white border border-slate-200 shadow-sm rounded-2xl p-5 flex flex-col hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 h-full">
    {{-- Header: Avatar + Badge --}}
    <div class="flex items-start justify-between mb-4">
        <div class="w-14 h-14 rounded-2xl overflow-hidden bg-slate-100 shrink-0 border border-slate-200">
            @if($contractor->profile_photo)
                <img src="{{ asset('storage/' . $contractor->profile_photo) }}"
                     alt="Foto profil {{ $contractor->user->name }}"
                     class="w-full h-full object-cover">
            @else
                <div class="w-full h-full flex items-center justify-center bg-navy text-white font-bold text-xl"
                     aria-label="Inisial {{ $contractor->user->name ?? '?' }}">
                    {{ strtoupper(substr($contractor->user->name ?? '?', 0, 1)) }}
                </div>
            @endif
        </div>
        @if($contractor->verification_status?->value === 'verified')
            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-verified-100 text-verified-700 flex items-center gap-1">
                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                Terverifikasi
            </span>
        @else
            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700">
                Pending
            </span>
        @endif
    </div>

    {{-- Info --}}
    <h3 class="font-bold text-slate-800 mb-1 truncate">{{ $contractor->user->name ?? 'Kontraktor' }}</h3>

    {{-- Rating --}}
    <div class="flex items-center gap-1.5 mb-2">
        <div class="flex text-amber-400" aria-label="Rating {{ number_format($contractor->rating ?? 0, 1) }} dari 5">
            @for($i = 1; $i <= 5; $i++)
                <svg class="w-3.5 h-3.5 {{ $i <= round($contractor->rating ?? 0) ? 'text-amber-400' : 'text-slate-200' }}"
                     fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
            @endfor
        </div>
        <span class="text-xs font-semibold text-slate-700">{{ number_format($contractor->rating ?? 0, 1) }}</span>
        <span class="text-xs text-slate-400">({{ $contractor->total_reviews ?? 0 }} ulasan)</span>
    </div>

    {{-- Lokasi --}}
    @if($contractor->address)
        <div class="flex items-start gap-1 text-xs text-slate-500 mb-3">
            <svg class="w-3.5 h-3.5 shrink-0 mt-0.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            <span class="line-clamp-1">{{ $contractor->address }}</span>
        </div>
    @endif

    {{-- Badge Layanan --}}
    @if(isset($contractor->services) && $contractor->services->isNotEmpty())
        <div class="flex flex-wrap gap-1 mb-4">
            @foreach($contractor->services->take(3) as $svc)
                <span class="px-2 py-0.5 bg-slate-100 text-slate-600 text-[10px] font-medium rounded-full">
                    {{ $svc->name }}
                </span>
            @endforeach
            @if($contractor->services->count() > 3)
                <span class="px-2 py-0.5 bg-slate-100 text-slate-400 text-[10px] rounded-full">
                    +{{ $contractor->services->count() - 3 }}
                </span>
            @endif
        </div>
    @else
        <div class="mb-4"></div>
    @endif

    {{-- Stats --}}
    <div class="flex gap-4 mb-4">
        <div class="text-center">
            <div class="text-sm font-bold text-slate-800">{{ $contractor->total_projects ?? 0 }}</div>
            <div class="text-[10px] text-slate-400">Proyek</div>
        </div>
        <div class="text-center">
            <div class="text-sm font-bold text-slate-800">{{ $contractor->total_reviews ?? 0 }}</div>
            <div class="text-[10px] text-slate-400">Ulasan</div>
        </div>
    </div>

    {{-- CTA --}}
    <div class="mt-auto">
        <a href="{{ route('public.contractors.show', $contractor) }}" wire:navigate
           class="block w-full text-center py-2.5 px-4 bg-navy hover:bg-navy-700 text-white text-sm font-semibold rounded-xl transition">
            Lihat Profil
        </a>
    </div>
</div>
