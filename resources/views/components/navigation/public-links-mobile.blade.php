{{-- ============================================ --}}
{{-- MENU PUBLIK MOBILE — Dipakai oleh Mobile Menu --}}
{{-- ============================================ --}}
<a href="{{ route('home') }}" wire:navigate
    class="block px-3 py-2.5 text-sm font-medium text-slate-700 hover:text-navy hover:bg-slate-100 rounded-lg transition">
    🏠 Beranda
</a>
<a href="{{ route('public.organizations.index') }}" wire:navigate
    class="block px-3 py-2.5 text-sm font-medium text-slate-700 hover:text-navy hover:bg-slate-100 rounded-lg transition">
    🔍 Cari Organisasi
</a>
<a href="{{ route('public.programs.index') }}" wire:navigate
    class="block px-3 py-2.5 text-sm font-medium text-slate-700 hover:text-navy hover:bg-slate-100 rounded-lg transition">
    📋 Program
</a>
<a href="{{ route('public.gallery.index') }}" wire:navigate
    class="block px-3 py-2.5 text-sm font-medium text-slate-700 hover:text-navy hover:bg-slate-100 rounded-lg transition">
    🖼️ Galeri
</a>
