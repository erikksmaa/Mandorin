@props(['active' => false, 'href' => '#'])

<a href="{{ $href }}" wire:navigate
    class="relative px-3 py-2 text-sm font-medium rounded-lg transition-all
          {{ $active ? 'text-navy bg-slate-100' : 'text-slate-600 hover:text-navy hover:bg-slate-100' }}">
    {{ $slot }}
    @if ($active)
        <span class="absolute bottom-1 left-1/2 -translate-x-1/2 w-6 h-0.5 bg-orange-500 rounded-full"></span>
    @endif
</a>
