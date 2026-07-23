{{-- ============================================ --}}
{{-- MENU PUBLIK MOBILE — Dipakai oleh Mobile Menu --}}
{{-- ============================================ --}}
<a href="{{ route('home') }}" wire:navigate
    class="block px-3 py-2.5 text-sm font-medium text-slate-700 hover:text-navy hover:bg-slate-100 rounded-lg transition">
    🏠 Beranda
</a>
<a href="{{ route('public.contractors.index') }}" wire:navigate
    class="block px-3 py-2.5 text-sm font-medium text-slate-700 hover:text-navy hover:bg-slate-100 rounded-lg transition">
    🔍 Cari Kontraktor
</a>
<a href="{{ route('public.portfolios.index') }}" wire:navigate
    class="block px-3 py-2.5 text-sm font-medium text-slate-700 hover:text-navy hover:bg-slate-100 rounded-lg transition">
    📂 Portfolio
</a>

