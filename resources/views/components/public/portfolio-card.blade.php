@props(['program', 'showOrganization' => true])

@php
    /** @var \App\Models\Program $program */
    $photos = \App\Models\ActivityPhoto::whereHas('activityLog', function($q) use ($program) {
        $q->where('program_id', $program->id);
    })->latest()->take(3)->get();

    $coverPhoto = $photos->first()?->photo;
@endphp

<a href="{{ route('public.programs.show', $program) }}" wire:navigate
   class="group bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 flex flex-col h-full">

    {{-- Banner / Cover Image --}}
    <div class="relative overflow-hidden bg-slate-100 aspect-video flex items-center justify-center text-slate-300">
        @if($coverPhoto)
            <img src="{{ asset('storage/' . $coverPhoto) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
        @else
            <div class="w-full h-full bg-navy/10 flex items-center justify-center">
                <span class="text-3xl font-black text-navy/30 font-mono">{{ $program->program_code }}</span>
            </div>
        @endif

        <div class="absolute top-2 left-2 flex gap-1">
            <span class="bg-navy/80 backdrop-blur-sm text-white text-[10px] font-bold px-2.5 py-0.5 rounded-full">
                {{ $program->category?->name ?? 'Program' }}
            </span>
        </div>

        <div class="absolute top-2 right-2">
            <span class="bg-green-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow-sm">
                {{ $program->progress }}%
            </span>
        </div>
    </div>

    {{-- Content --}}
    <div class="p-4 flex flex-col flex-1">
        <h3 class="font-bold text-slate-800 text-sm mb-1 line-clamp-1 group-hover:text-navy transition-colors">
            {{ $program->title }}
        </h3>

        <div class="flex items-center gap-3 text-[11px] text-slate-400 mb-2">
            <span>📍 {{ $program->location ?? 'Lokasi Program' }}</span>
            <span>📅 {{ $program->end_date ? $program->end_date->format('d M Y') : ($program->start_date ? $program->start_date->format('d M Y') : '-') }}</span>
        </div>

        @if($program->description)
            <p class="text-slate-500 text-xs leading-relaxed line-clamp-2 mb-3">{{ $program->description }}</p>
        @endif

        <!-- Preview max 3 documentation photos -->
        @if($photos->isNotEmpty())
            <div class="flex gap-1.5 mb-3 pt-2 border-t border-slate-100">
                @foreach($photos as $p)
                    <div class="w-10 h-10 rounded-lg overflow-hidden border border-slate-200 shrink-0 bg-slate-100">
                        <img src="{{ asset('storage/' . $p->photo) }}" class="w-full h-full object-cover">
                    </div>
                @endforeach
            </div>
        @endif

        @if($showOrganization && isset($program->organization))
            <div class="mt-auto pt-3 border-t border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="w-6 h-6 rounded-full overflow-hidden bg-navy shrink-0 flex items-center justify-center text-white text-[10px] font-bold">
                        {{ strtoupper(substr($program->organization->name ?? '?', 0, 1)) }}
                    </div>
                    <span class="text-xs text-slate-600 font-medium truncate max-w-[140px]">{{ $program->organization->name ?? 'Organisasi' }}</span>
                </div>
                <span class="text-xs font-semibold text-navy group-hover:translate-x-0.5 transition">&rarr;</span>
            </div>
        @endif
    </div>
</a>
