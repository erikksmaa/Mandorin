{{-- ============================================ --}}
{{-- MENU PUBLIK — Dipakai oleh Desktop & Mobile --}}
{{-- ============================================ --}}
<x-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')">
    Beranda
</x-nav-link>

<x-nav-link href="{{ route('public.contractors.index') }}" :active="request()->routeIs('public.contractors.*')">
    Cari Kontraktor
</x-nav-link>

<x-nav-link href="{{ route('public.portfolios.index') }}" :active="request()->routeIs('public.portfolios.*')">
    Portfolio
</x-nav-link>

