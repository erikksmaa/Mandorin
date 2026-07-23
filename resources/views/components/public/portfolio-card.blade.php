@props(['portfolio', 'showContractor' => true])

@php
    /** @var \App\Models\Portfolio $portfolio */
    $photo = $portfolio->after_photo ?? $portfolio->before_photo;
@endphp

<a href="{{ route('public.portfolios.show', $portfolio) }}" wire:navigate
   class="group bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 flex flex-col h-full">

    {{-- Foto --}}
    <div class="relative overflow-hidden bg-slate-100 aspect-video">
        @if($photo)
            <img src="{{ asset('storage/' . $photo) }}"
                 alt="{{ $portfolio->title }}"
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
        @else
            <div class="w-full h-full flex items-center justify-center bg-slate-100 text-slate-300">
                <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
        @endif

        {{-- Before/After badge --}}
        @if($portfolio->before_photo && $portfolio->after_photo)
            <div class="absolute top-2 left-2 flex gap-1">
                <span class="bg-black/60 text-white text-[10px] font-bold px-2 py-0.5 rounded-full backdrop-blur-sm">Before/After</span>
            </div>
        @endif
    </div>

    {{-- Content --}}
    <div class="p-4 flex flex-col flex-1">
        <h3 class="font-bold text-slate-800 text-sm mb-1 line-clamp-1 group-hover:text-navy transition-colors">
            {{ $portfolio->title }}
        </h3>

        @if($portfolio->description)
            <p class="text-slate-500 text-xs leading-relaxed line-clamp-2 mb-3">{{ $portfolio->description }}</p>
        @endif

        @if($showContractor && isset($portfolio->contractorProfile))
            <div class="mt-auto pt-3 border-t border-slate-100 flex items-center gap-2">
                <div class="w-6 h-6 rounded-full overflow-hidden bg-navy shrink-0">
                    @if($portfolio->contractorProfile->profile_photo)
                        <img src="{{ asset('storage/' . $portfolio->contractorProfile->profile_photo) }}"
                             alt="{{ $portfolio->contractorProfile->user->name ?? '' }}"
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-white text-[10px] font-bold">
                            {{ strtoupper(substr($portfolio->contractorProfile->user->name ?? '?', 0, 1)) }}
                        </div>
                    @endif
                </div>
                <span class="text-xs text-slate-500 truncate">{{ $portfolio->contractorProfile->user->name ?? 'Kontraktor' }}</span>
            </div>
        @endif
    </div>
</a>
