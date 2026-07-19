<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component {
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }

    /**
     * Kembalikan URL dashboard sesuai role user yang sedang login.
     * PENTING: gunakan nilai enum->value ('customer','contractor','admin')
     * yang konsisten dengan database & middleware.
     */
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

<nav x-data="{ open: false }" class="bg-navy text-white border-b border-white/10 shadow-sm">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center gap-8">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ $this->dashboardRoute() }}" wire:navigate
                        class="flex items-center gap-2 text-xl font-bold tracking-wide">
                        <svg class="w-7 h-7 text-orange-400" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 8.25h3m-3 3.75h3M6.75 15h.008v.008H6.75V15z" />
                        </svg>
                        <span class="text-white">Mandorin</span>
                    </a>
                </div>

                <!-- Navigation Links (per-role, desktop) -->
                @auth
                    <div class="hidden sm:flex sm:items-center sm:gap-1">
                        @if (auth()->user()->role?->value === 'admin')
                            <a href="{{ route('admin.dashboard') }}" wire:navigate
                                class="px-3 py-2 rounded-lg text-sm text-white/80 hover:text-white hover:bg-white/10 transition">Dashboard</a>
                            <a href="{{ route('admin.verification.index') }}" wire:navigate
                                class="px-3 py-2 rounded-lg text-sm text-white/80 hover:text-white hover:bg-white/10 transition">Verifikasi</a>
                            <a href="{{ route('admin.users.index') }}" wire:navigate
                                class="px-3 py-2 rounded-lg text-sm text-white/80 hover:text-white hover:bg-white/10 transition">Pengguna</a>
                        @elseif(auth()->user()->role?->value === 'contractor')
                            <a href="{{ route('contractor.dashboard') }}" wire:navigate
                                class="px-3 py-2 rounded-lg text-sm text-white/80 hover:text-white hover:bg-white/10 transition">Dashboard</a>
                            <a href="{{ route('contractor.profile.show') }}" wire:navigate
                                class="px-3 py-2 rounded-lg text-sm text-white/80 hover:text-white hover:bg-white/10 transition">Profil</a>
                        @elseif(auth()->user()->role?->value === 'customer')
                            <a href="{{ route('customer.dashboard') }}" wire:navigate
                                class="px-3 py-2 rounded-lg text-sm text-white/80 hover:text-white hover:bg-white/10 transition">Dashboard</a>
                            <a href="{{ route('customer.contractors.index') }}" wire:navigate
                                class="px-3 py-2 rounded-lg text-sm text-white/80 hover:text-white hover:bg-white/10 transition">Cari
                                Kontraktor</a>
                            <a href="{{ route('customer.projects.index') }}" wire:navigate
                                class="px-3 py-2 rounded-lg text-sm text-white/80 hover:text-white hover:bg-white/10 transition">Proyek
                                Saya</a>
                        @endif
                    </div>
                @endauth
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:gap-3">
                @auth
                    <!-- Notification bell placeholder -->
                    <button class="p-2 rounded-lg text-white/70 hover:text-white hover:bg-white/10 transition">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </button>

                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium text-white/90 hover:bg-white/10 focus:outline-none transition">
                                <div
                                    class="w-7 h-7 rounded-full bg-orange-500 flex items-center justify-center text-white text-xs font-bold">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <span x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name"
                                    x-on:profile-updated.window="name = $event.detail.name"
                                    class="max-w-[120px] truncate hidden md:block">
                                </span>
                                <svg class="fill-current h-4 w-4 text-white/60" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="px-4 py-3 border-b border-slate-100">
                                <p class="text-sm font-medium text-slate-800">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-slate-500 truncate">{{ auth()->user()->email }}</p>
                            </div>

                            <x-dropdown-link :href="$this->dashboardRoute()" wire:navigate>
                                {{ __('Dashboard') }}
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('profile')" wire:navigate>
                                {{ __('Pengaturan Akun') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <div class="border-t border-slate-100 mt-1">
                                <button wire:click="logout" class="w-full text-start">
                                    <x-dropdown-link class="text-red-600 hover:bg-red-50">
                                        {{ __('Keluar') }}
                                    </x-dropdown-link>
                                </button>
                            </div>
                        </x-slot>
                    </x-dropdown>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-white/70 hover:text-white hover:bg-white/10 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden border-t border-white/10">
        <div class="pt-2 pb-3 space-y-1 px-3">
            @auth
                @if (auth()->user()->role?->value === 'admin')
                    <x-responsive-nav-link :href="route('admin.dashboard')" wire:navigate>Dashboard</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.verification.index')" wire:navigate>Verifikasi</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.users.index')" wire:navigate>Pengguna</x-responsive-nav-link>
                @elseif(auth()->user()->role?->value === 'contractor')
                    <x-responsive-nav-link :href="route('contractor.dashboard')" wire:navigate>Dashboard</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('contractor.profile.show')" wire:navigate>Profil Saya</x-responsive-nav-link>
                @elseif(auth()->user()->role?->value === 'customer')
                    <x-responsive-nav-link :href="route('customer.dashboard')" wire:navigate>Dashboard</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('customer.contractors.index')" wire:navigate>Cari Kontraktor</x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('customer.projects.index')" wire:navigate>Proyek Saya</x-responsive-nav-link>
                @endif
            @endauth
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-white/10">
            @auth
                <div class="px-4 mb-3">
                    <div class="font-medium text-base text-white" x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name"
                        x-on:profile-updated.window="name = $event.detail.name">
                    </div>
                    <div class="font-medium text-sm text-white/60">{{ auth()->user()->email }}</div>
                </div>

                <div class="space-y-1 px-3">
                    <x-responsive-nav-link :href="route('profile')" wire:navigate>
                        {{ __('Pengaturan Akun') }}
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <button wire:click="logout" class="w-full text-start">
                        <x-responsive-nav-link>
                            {{ __('Keluar') }}
                        </x-responsive-nav-link>
                    </button>
                </div>
            @endauth
        </div>
    </div>
</nav>
