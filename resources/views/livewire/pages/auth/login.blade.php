<?php

use App\Livewire\Forms\LoginForm;
use App\Enums\UserRole;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest-public')] class extends Component {
    public LoginForm $form;

    public function login(): void
    {
        $this->validate();
        $this->form->authenticate();
        Session::regenerate();

        session()->flash('swal_success', 'Selamat datang kembali!');

        $role = Auth::user()->role;
        $roleValue = $role instanceof UserRole ? $role->value : $role;

        $this->redirectIntended(
            default: match ($roleValue) {
                'contractor' => route('contractor.dashboard', absolute: false),
                'admin' => route('admin.dashboard', absolute: false),
                default => route('customer.dashboard', absolute: false),
            },
            navigate: true,
        );
    }
}; ?>

<div class="min-h-screen flex flex-col bg-slate-50">

    {{-- Subtle background pattern --}}
    <div class="fixed inset-0 pointer-events-none opacity-[0.015]" aria-hidden="true"
        style="background-image: repeating-linear-gradient(0deg, #2C3E7A, #2C3E7A 1px, transparent 1px, transparent 40px), repeating-linear-gradient(90deg, #2C3E7A, #2C3E7A 1px, transparent 1px, transparent 40px);">
    </div>

    {{-- Decorative blobs --}}
    <div class="fixed -top-40 -right-40 w-96 h-96 bg-orange-100 rounded-full blur-3xl opacity-20 pointer-events-none"
        aria-hidden="true"></div>
    <div class="fixed -bottom-40 -left-40 w-96 h-96 bg-navy-100 rounded-full blur-3xl opacity-20 pointer-events-none"
        aria-hidden="true"></div>

    {{-- Header: Logo only --}}


    {{-- Main Card --}}
    <div class="relative flex-1 flex items-start justify-center px-4 sm:px-6 mt-[50px]">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-xl shadow-slate-200/50 border border-slate-100 p-8 mt-4">

            {{-- Header --}}
            <div class="text-center mb-5">
                <div class="relative mb-8 mt-3 flex justify-center">
                    <a href="{{ route('home') }}" wire:navigate class="flex items-center gap-2 group">
                        <img src="{{ asset('logo.png') }}" alt="Mandorin Logo" class="w-[150px] object-contain">
                    </a>
                </div>
                <p class="text-slate-500 text-sm mt-1">Masuk ke akun Mandorin Anda untuk melanjutkan.</p>
            </div>

            {{-- Session Status --}}
            @if (session('status'))
                <div
                    class="mb-6 px-4 py-3 bg-verified-50 border border-verified-200 rounded-xl text-sm text-verified-700 flex items-center gap-2">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    {{ session('status') }}
                </div>
            @endif

            <form wire:submit="login" class="space-y-5">

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1.5">
                        Email
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg class="w-4.5 h-4.5 text-slate-400" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <input wire:model="form.email" id="email" type="email" autocomplete="username" required
                            class="w-full pl-10 pr-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-slate-800 text-sm outline-none transition-all
                                   focus:bg-white focus:border-navy focus:ring-4 focus:ring-navy/5
                                   placeholder:text-slate-400"
                            placeholder="nama@email.com" aria-label="Alamat email">
                    </div>
                    @error('form.email')
                        <p class="mt-1.5 text-xs text-danger-600 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Password --}}
                <div x-data="{ show: false }">
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="block text-xs font-bold text-slate-500 uppercase tracking-wide">
                            Password
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" wire:navigate
                                class="text-xs font-medium text-orange-500 hover:text-orange-600 transition">
                                Lupa password?
                            </a>
                        @endif
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg class="w-4.5 h-4.5 text-slate-400" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input wire:model="form.password" id="password" :type="show ? 'text' : 'password'"
                            autocomplete="current-password" required
                            class="w-full pl-10 pr-12 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-slate-800 text-sm outline-none transition-all
                                   focus:bg-white focus:border-navy focus:ring-4 focus:ring-navy/5
                                   placeholder:text-slate-400"
                            placeholder="Masukkan password" aria-label="Password">
                        <button type="button" @click="show = !show"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 p-1 rounded-lg hover:bg-slate-100 transition"
                            :aria-label="show ? 'Sembunyikan password' : 'Tampilkan password'">
                            <svg x-show="!show" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg x-show="show" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                            </svg>
                        </button>
                    </div>
                    @error('form.password')
                        <p class="mt-1.5 text-xs text-danger-600 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Remember Me --}}
                <label class="flex items-center gap-2 cursor-pointer group">
                    <input wire:model="form.remember" type="checkbox" id="remember"
                        class="w-4 h-4 rounded border-slate-300 text-navy focus:ring-navy focus:ring-offset-0 cursor-pointer">
                    <span class="text-sm text-slate-600 group-hover:text-slate-800 transition">Ingat saya di perangkat
                        ini</span>
                </label>

                {{-- Submit Button --}}
                <button type="submit"
                    class="w-full py-3.5 px-6 bg-navy hover:bg-navy-700 active:bg-navy-800 text-white font-bold rounded-xl transition-all shadow-sm hover:shadow-md text-sm"
                    id="login-submit-btn">
                    <span wire:loading.remove wire:target="login">Masuk ke Akun</span>
                    <span wire:loading wire:target="login" class="flex items-center justify-center gap-2">
                        <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4" />
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                        </svg>
                        Memproses...
                    </span>
                </button>
            </form>

            {{-- Divider --}}
            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-slate-200"></div>
                </div>
                <div class="relative flex justify-center"><span
                        class="bg-white px-4 text-xs text-slate-400 font-medium">Belum punya akun?</span></div>
            </div>

            {{-- Register CTA --}}
            <a href="{{ route('register') }}" wire:navigate
                class="block w-full text-center py-3.5 px-6 bg-slate-50 hover:bg-slate-100 border-2 border-slate-200 hover:border-navy/30 text-navy font-bold rounded-xl transition-all text-sm">
                Daftar Gratis Sekarang →
            </a>

            {{-- Trust badges --}}
            <div class="mt-6 flex items-center justify-center gap-6 text-xs text-slate-400">
                <span class="flex items-center gap-1">
                    <svg class="w-3.5 h-3.5 text-verified-500" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    SSL Enkripsi
                </span>
                <span class="flex items-center gap-1">
                    <svg class="w-3.5 h-3.5 text-verified-500" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    Data Aman
                </span>
            </div>
        </div>
    </div>

    {{-- Footer --}}
    <div class="relative pb-6 pt-4 text-center text-xs text-slate-400">
        &copy; {{ date('Y') }} Mandorin. Hak cipta dilindungi.
    </div>
</div>
