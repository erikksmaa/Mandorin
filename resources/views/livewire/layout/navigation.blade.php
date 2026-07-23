<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component {
    public function logout(Logout $logout): void
    {
        $logout();
        $this->redirect('/', navigate: true);
    }

    public function dashboardRoute(): string
    {
        return match (auth()->user()->role?->value) {
            'customer' => route('customer.dashboard'),
            'contractor' => route('contractor.dashboard'),
            'admin' => route('admin.dashboard'),
            default => route('login'),
        };
    }
}; ?>

<nav x-data="{ open: false }" class="bg-white sticky top-0 z-50 border-b border-slate-200 shadow-sm shadow-slate-200/50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            {{-- ============================================ --}}
            {{-- LOGO — selalu tampil --}}
            {{-- ============================================ --}}
            <a href="{{ route('home') }}" wire:navigate class="flex items-center gap-2 shrink-0 group">
                <img src="{{ asset('logo.png') }}" alt="Mandorin Logo"
                    class="w-[130px] object-contain transition group-hover:opacity-80">
            </a>

            {{-- ============================================ --}}
            {{-- DESKTOP NAVIGATION --}}
            {{-- ============================================ --}}
            <div class="hidden md:flex items-center gap-1">

                {{-- ---------- MENU PUBLIK (SEMUA ROLE) ---------- --}}
                <x-navigation.public-links />

                {{-- ---------- GUEST ONLY ---------- --}}
                @guest
                    <div class="flex items-center gap-2 ml-3">
                        <a href="{{ route('login') }}" wire:navigate
                            class="px-4 py-2 text-sm font-semibold text-navy border-2 border-navy hover:bg-navy hover:text-white rounded-xl transition-all">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" wire:navigate
                            class="px-4 py-2 text-sm font-semibold bg-orange-500 hover:bg-orange-600 active:bg-orange-700 text-white rounded-xl transition-all shadow-sm hover:shadow-md">
                            Daftar Gratis
                        </a>
                    </div>
                @endguest

                {{-- ---------- AUTHENTICATED — ROLE-BASED ---------- --}}
                @auth
                    @switch(auth()->user()->role?->value)
                        {{-- ADMIN --}}
                        @case('admin')
                            <x-nav-link href="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.dashboard')">
                                Dashboard
                            </x-nav-link>
                            <x-nav-link href="{{ route('admin.verification.index') }}" :active="request()->routeIs('admin.verification.*')">
                                Verifikasi Mandor
                            </x-nav-link>

                            {{-- Dropdown Data Master --}}
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="inline-flex items-center gap-1 px-3 py-2 text-sm font-medium text-slate-600 hover:text-navy transition {{ request()->routeIs('admin.users.*') || request()->routeIs('admin.services.*') ? 'text-navy font-semibold border-b-2 border-orange-500' : '' }}">
                                        Data Master
                                        <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    <x-dropdown-link href="{{ route('admin.users.index') }}" wire:navigate>
                                        👥 Manajemen Pengguna
                                    </x-dropdown-link>
                                    <x-dropdown-link href="{{ route('admin.services.index') }}" wire:navigate>
                                        🛠️ Kelola Layanan
                                    </x-dropdown-link>
                                </x-slot>
                            </x-dropdown>
                        @break

                        {{-- CONTRACTOR --}}
                        @case('contractor')
                            <x-nav-link href="{{ route('contractor.dashboard') }}" :active="request()->routeIs('contractor.dashboard')">
                                Dashboard
                            </x-nav-link>
                            <x-nav-link href="{{ route('contractor.profile.show') }}" :active="request()->routeIs('contractor.profile.*')">
                                Profil Mandor
                            </x-nav-link>
                            <x-nav-link href="{{ route('contractor.projects.index') }}" :active="request()->routeIs('contractor.projects.*')">
                                Kelola Proyek
                            </x-nav-link>
                        @break

                        {{-- CUSTOMER --}}
                        @case('customer')
                            <x-nav-link href="{{ route('customer.dashboard') }}" :active="request()->routeIs('customer.dashboard')">
                                Dashboard
                            </x-nav-link>
                            <x-nav-link href="{{ route('customer.projects.index') }}" :active="request()->routeIs('customer.projects.*')">
                                Proyek Saya
                            </x-nav-link>
                        @break
                    @endswitch

                    {{-- User Area (Notif + Avatar Dropdown) — hanya untuk authenticated --}}
                    <div class="ml-3 flex items-center gap-3 pl-3 border-l border-slate-200">
                        {{-- Notification Bell with Dropdown --}}
                        <div x-data="{ openNotif: false }" class="relative" @click.outside="openNotif = false">
                            <button @click="openNotif = !openNotif"
                                class="relative p-2 rounded-lg text-slate-500 hover:text-navy hover:bg-slate-100 transition">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                                @php $unreadCount = auth()->user()->notifications()->where('is_read', false)->count(); @endphp
                                @if($unreadCount > 0)
                                    <span class="absolute top-0.5 right-0.5 w-4 h-4 bg-orange-500 rounded-full border-2 border-white flex items-center justify-center text-[9px] text-white font-bold">
                                        {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                                    </span>
                                @endif
                            </button>

                            {{-- Dropdown Panel --}}
                            <div x-show="openNotif"
                                x-transition:enter="transition ease-out duration-150"
                                x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-100"
                                x-transition:leave-start="opacity-100"
                                x-transition:leave-end="opacity-0 scale-95"
                                class="absolute right-0 mt-2 w-80 bg-white rounded-xl border border-slate-200 shadow-lg shadow-slate-200/60 z-50"
                                style="display:none;">
                                <div class="flex items-center justify-between px-4 py-3 border-b border-slate-100">
                                    <h3 class="text-sm font-bold text-slate-800">Notifikasi</h3>
                                    @if($unreadCount > 0)
                                        <span class="px-2 py-0.5 bg-orange-100 text-orange-700 rounded-full text-xs font-semibold">
                                            {{ $unreadCount }} baru
                                        </span>
                                    @endif
                                </div>

                                @php
                                    $notifs = auth()->user()->notifications()->latest()->take(6)->get();
                                @endphp

                                <div class="max-h-80 overflow-y-auto">
                                    @forelse($notifs as $notif)
                                        <div class="flex items-start gap-3 px-4 py-3 border-b border-slate-50 hover:bg-slate-50 transition {{ $notif->is_read ? '' : 'bg-orange-50/50' }}">
                                            <div class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0 mt-0.5
                                                {{ $notif->type === 'verification' ? 'bg-green-100 text-green-600' : 'bg-navy/10 text-navy' }}">
                                                @if($notif->type === 'verification')
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                @else
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                                                @endif
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-xs font-semibold text-slate-800 leading-snug">{{ $notif->title }}</p>
                                                <p class="text-xs text-slate-500 mt-0.5 leading-relaxed line-clamp-2">{{ $notif->message }}</p>
                                                <p class="text-[10px] text-slate-400 mt-1">{{ $notif->created_at->diffForHumans() }}</p>
                                            </div>
                                            @if(!$notif->is_read)
                                                <div class="w-2 h-2 bg-orange-400 rounded-full mt-1.5 flex-shrink-0"></div>
                                            @endif
                                        </div>
                                    @empty
                                        <div class="px-4 py-8 text-center">
                                            <svg class="w-8 h-8 text-slate-300 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                            </svg>
                                            <p class="text-xs text-slate-400">Belum ada notifikasi</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        {{-- User Dropdown --}}
                        <x-dropdown align="right" width="56">
                            <x-slot name="trigger">
                                <button
                                    class="inline-flex items-center gap-2 px-2 py-1.5 rounded-xl text-sm font-medium text-slate-700 hover:bg-slate-100 focus:outline-none transition">
                                    <div
                                        class="w-8 h-8 rounded-full bg-navy flex items-center justify-center text-white text-sm font-bold">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    </div>
                                    <span class="max-w-[100px] truncate hidden md:block text-sm">
                                        {{ auth()->user()->name }}
                                    </span>
                                    <svg class="fill-current h-4 w-4 text-slate-400" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <div class="px-4 py-3 border-b border-slate-100">
                                    <p class="text-sm font-semibold text-slate-800">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-slate-500 truncate mt-0.5">{{ auth()->user()->email }}</p>
                                    <span
                                        class="inline-block mt-1.5 px-2 py-0.5 bg-slate-100 text-slate-600 rounded-full text-xs font-medium">
                                        {{ ucfirst(auth()->user()->role?->value ?? 'user') }}
                                    </span>
                                </div>

                                <div class="py-1">
                                    <x-dropdown-link :href="$this->dashboardRoute()" wire:navigate>
                                        <span class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                            </svg>
                                            Dashboard
                                        </span>
                                    </x-dropdown-link>

                                    <x-dropdown-link :href="route('profile')" wire:navigate>
                                        <span class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            Pengaturan Akun
                                        </span>
                                    </x-dropdown-link>
                                </div>

                                <div class="border-t border-slate-100 py-1">
                                    <button
                                        @click="Swal.fire({ icon: 'warning', title: 'Keluar dari Mandorin?', text: 'Sesi Anda akan diakhiri. Anda perlu login kembali untuk mengakses akun.', showCancelButton: true, confirmButtonText: 'Ya, Keluar', cancelButtonText: 'Batal', confirmButtonColor: '#ef4444', cancelButtonColor: '#64748b' }).then(r => { if (r.isConfirmed) { $wire.logout(); } })"
                                        class="w-full text-start">
                                        <x-dropdown-link class="text-red-600 hover:bg-red-50">
                                            <span class="flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                                </svg>
                                                Keluar
                                            </span>
                                        </x-dropdown-link>
                                    </button>
                                </div>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @endauth
            </div>

            {{-- ============================================ --}}
            {{-- MOBILE HAMBURGER --}}
            {{-- ============================================ --}}
            <button @click="open = !open"
                class="md:hidden p-2 rounded-lg text-slate-600 hover:text-navy hover:bg-slate-100 transition"
                aria-label="Buka menu navigasi">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round"
                        stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                        stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    {{-- ============================================ --}}
    {{-- MOBILE MENU --}}
    {{-- ============================================ --}}
    <div x-show="open" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        class="md:hidden border-t border-slate-200 bg-white shadow-lg" x-cloak>
        <div class="px-4 pt-3 pb-5 space-y-1">

            {{-- ---------- MENU PUBLIK MOBILE (SEMUA ROLE) ---------- --}}
            <x-navigation.public-links-mobile />

            {{-- ---------- GUEST MOBILE ---------- --}}
            @guest
                <div class="flex gap-2 mt-3 pt-3 border-t border-slate-200">
                    <a href="{{ route('login') }}" wire:navigate
                        class="flex-1 text-center px-3 py-2.5 text-sm font-semibold text-navy border-2 border-navy hover:bg-navy hover:text-white rounded-xl transition-all">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" wire:navigate
                        class="flex-1 text-center px-3 py-2.5 text-sm font-semibold bg-orange-500 hover:bg-orange-600 text-white rounded-xl transition shadow-sm">
                        Daftar Gratis
                    </a>
                </div>
            @endguest

            {{-- ---------- AUTHENTICATED MOBILE ---------- --}}
            @auth
                @switch(auth()->user()->role?->value)
                    {{-- ADMIN MOBILE --}}
                    @case('admin')
                        <a href="{{ route('admin.dashboard') }}" wire:navigate
                            class="block px-3 py-2.5 text-sm font-medium text-slate-700 hover:text-navy hover:bg-slate-100 rounded-lg transition">
                            📊 Dashboard
                        </a>
                        <a href="{{ route('admin.verification.index') }}" wire:navigate
                            class="block px-3 py-2.5 text-sm font-medium text-slate-700 hover:text-navy hover:bg-slate-100 rounded-lg transition">
                            ✅ Verifikasi Mandor
                        </a>
                        <div class="px-3 py-1 text-xs font-bold text-slate-400 uppercase tracking-wider mt-2">Data Master</div>
                        <a href="{{ route('admin.users.index') }}" wire:navigate
                            class="block px-3 py-2 text-sm font-medium text-slate-700 hover:text-navy hover:bg-slate-100 rounded-lg transition pl-5">
                            👥 Manajemen Pengguna
                        </a>
                        <a href="{{ route('admin.services.index') }}" wire:navigate
                            class="block px-3 py-2 text-sm font-medium text-slate-700 hover:text-navy hover:bg-slate-100 rounded-lg transition pl-5">
                            🛠️ Kelola Layanan
                        </a>
                    @break

                    {{-- CONTRACTOR MOBILE --}}
                    @case('contractor')
                        <a href="{{ route('contractor.dashboard') }}" wire:navigate
                            class="block px-3 py-2.5 text-sm font-medium text-slate-700 hover:text-navy hover:bg-slate-100 rounded-lg transition">
                            📊 Dashboard
                        </a>
                        <a href="{{ route('contractor.profile.show') }}" wire:navigate
                            class="block px-3 py-2.5 text-sm font-medium text-slate-700 hover:text-navy hover:bg-slate-100 rounded-lg transition">
                            👤 Profil Mandor
                        </a>
                    @break

                    {{-- CUSTOMER MOBILE --}}
                    @case('customer')
                        <a href="{{ route('customer.dashboard') }}" wire:navigate
                            class="block px-3 py-2.5 text-sm font-medium text-slate-700 hover:text-navy hover:bg-slate-100 rounded-lg transition">
                            📊 Dashboard
                        </a>
                        <a href="{{ route('customer.projects.index') }}" wire:navigate
                            class="block px-3 py-2.5 text-sm font-medium text-slate-700 hover:text-navy hover:bg-slate-100 rounded-lg transition">
                            📋 Proyek Saya
                        </a>
                    @break
                @endswitch

                {{-- Divider + Settings/Logout (Mobile) --}}
                <div class="mt-3 pt-3 border-t border-slate-200 space-y-1">
                    <a href="{{ route('profile') }}" wire:navigate
                        class="block px-3 py-2.5 text-sm font-medium text-slate-700 hover:text-navy hover:bg-slate-100 rounded-lg transition">
                        ⚙️ Pengaturan Akun
                    </a>
                    <button @click="Swal.fire({ icon: 'warning', title: 'Keluar dari Mandorin?', text: 'Sesi Anda akan diakhiri. Anda perlu login kembali untuk mengakses akun.', showCancelButton: true, confirmButtonText: 'Ya, Keluar', cancelButtonText: 'Batal', confirmButtonColor: '#ef4444', cancelButtonColor: '#64748b' }).then(r => { if (r.isConfirmed) { $wire.logout(); } })"
                        class="w-full text-left px-3 py-2.5 text-sm font-medium text-red-600 hover:bg-red-50 rounded-lg transition">
                        🚪 Keluar
                    </button>
                </div>
            @endauth
        </div>
    </div>
</nav>
