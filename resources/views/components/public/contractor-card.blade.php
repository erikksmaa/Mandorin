@props(['organization'])

@php
    /** @var \App\Models\Organization $organization */
@endphp

<div class="bg-white border border-slate-200 shadow-sm rounded-2xl p-5 flex flex-col hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 h-full">
    {{-- Header: Logo / Initial + Status --}}
    <div class="flex items-start justify-between mb-4">
        <div class="w-14 h-14 rounded-2xl overflow-hidden bg-slate-100 shrink-0 border border-slate-200">
            @if($organization->logo)
                <img src="{{ asset('storage/' . $organization->logo) }}"
                     alt="Logo {{ $organization->name }}"
                     class="w-full h-full object-cover">
            @else
                <div class="w-full h-full flex items-center justify-center bg-navy text-white font-bold text-xl"
                     aria-label="Inisial {{ $organization->name ?? '?' }}">
                    {{ strtoupper(substr($organization->name ?? '?', 0, 1)) }}
                </div>
            @endif
        </div>
        @if(($organization->status?->value ?? $organization->status) === 'active')
            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700 flex items-center gap-1">
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
    <h3 class="font-bold text-slate-800 mb-1 truncate">{{ $organization->name ?? 'Organisasi Pemuda' }}</h3>
    <span class="text-xs text-orange-600 font-semibold mb-2 block">
        {{ $organization->category?->name ?? 'Organisasi Kepemudaan' }}
    </span>

    {{-- Lokasi --}}
    @if($organization->address)
        <div class="flex items-start gap-1 text-xs text-slate-500 mb-3">
            <svg class="w-3.5 h-3.5 shrink-0 mt-0.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            <span class="line-clamp-1">{{ $organization->address }}</span>
        </div>
    @endif

    @if($organization->description)
        <p class="text-xs text-slate-600 line-clamp-2 mb-4">
            {{ $organization->description }}
        </p>
    @endif

    {{-- CTA --}}
    <div class="mt-auto pt-3">
        <a href="{{ route('public.organizations.show', $organization) }}" wire:navigate
           class="block w-full text-center py-2.5 px-4 bg-navy hover:bg-slate-800 text-white text-sm font-semibold rounded-xl transition">
            Lihat Profil
        </a>
    </div>
</div>
