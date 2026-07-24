{{-- ============================================ --}}
{{-- MENU PUBLIK — Dipakai oleh Desktop & Mobile --}}
{{-- ============================================ --}}
<x-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')">
    Beranda
</x-nav-link>

<x-nav-link href="{{ route('public.organizations.index') }}" :active="request()->routeIs('public.organizations.*')">
    Cari Organisasi
</x-nav-link>

<x-nav-link href="{{ route('public.programs.index') }}" :active="request()->routeIs('public.programs.*')">
    Program
</x-nav-link>

<x-nav-link href="{{ route('public.gallery.index') }}" :active="request()->routeIs('public.gallery.*')">
    Galeri
</x-nav-link>
