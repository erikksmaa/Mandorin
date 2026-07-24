<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest-public')] class extends Component {
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $role = 'customer';
    public string $password = '';
    public string $password_confirmation = '';

    public function register(): void
    {
        $validated = $this->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
                'phone' => ['nullable', 'string', 'max:20'],
                'role' => ['required', 'in:customer,contractor'],
                'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            ],
            [
                'name.required' => 'Nama lengkap wajib diisi.',
                'email.required' => 'Alamat email wajib diisi.',
                'email.unique' => 'Email ini sudah terdaftar.',
                'role.required' => 'Silakan pilih peran Anda.',
                'password.required' => 'Password wajib diisi.',
                'password.confirmed' => 'Konfirmasi password tidak cocok.',
            ],
        );

        $roleSlug = $validated['role'] === 'contractor' ? 'leader' : 'verifikator';
        $roleModel = Role::where('slug', $roleSlug)->first() ?? Role::firstOrCreate(['slug' => $roleSlug], ['name' => ucfirst($roleSlug)]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'password' => Hash::make($validated['password']),
            'role_id' => $roleModel?->id,
        ]);

        event(new Registered($user));

        Auth::login($user);

        $this->redirect(
            match ($roleSlug) {
                'leader' => route('leader.dashboard', absolute: false),
                default => route('verifier.dashboard', absolute: false),
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

    {{-- Main Card --}}
    <div class="relative flex-1 flex items-start justify-center px-4 sm:px-6 pb-8">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-xl shadow-slate-200/50 border border-slate-100 p-8 mt-4">

            {{-- Header --}}
            <div class="text-center mb-8">
                <h1 class="text-3xl font-black text-navy"
                    style="font-family: 'Big Shoulders Display', sans-serif;">
                    DAFTAR AKUN BARU
                </h1>
                <div class="relative mb-3 mt-1 flex justify-center">
                    <a href="{{ route('home') }}" wire:navigate class="flex items-center gap-2 group">
                        <img src="{{ asset('logo.png') }}" alt="SIPORA Logo" class="w-[150px] object-contain">
                    </a>
                </div>
                <p class="text-slate-500 text-sm mt-1">Gratis, cepat, dan aman. Mulai dalam 2 menit.</p>
            </div>

            <form wire:submit="register" class="space-y-5" x-data="{ role: $wire.entangle('role') }">

                {{-- PILIHAN ROLE --}}
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">
                        Daftar Sebagai
                    </label>
                    <div class="grid grid-cols-2 gap-3">
                        {{-- Verifikator --}}
                        <label for="role_customer"
                            class="relative flex flex-col gap-2 p-4 border-2 rounded-xl cursor-pointer transition-all select-none"
                            :class="role === 'customer' ? 'border-navy bg-navy/[0.03] shadow-sm' :
                                'border-slate-200 hover:border-slate-300 hover:bg-slate-50'">
                            <input type="radio" id="role_customer" wire:model.live="role" value="customer"
                                class="sr-only">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center transition-all"
                                    :class="role === 'customer' ? 'bg-navy text-white shadow-sm' : 'bg-slate-100 text-slate-500'">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                    </svg>
                                </div>
                                <span class="font-bold text-sm transition-all"
                                    :class="role === 'customer' ? 'text-navy' : 'text-slate-600'">Verifikator</span>
                            </div>
                            <p class="text-xs text-slate-500 leading-tight">Verifikasi & evaluasi program kepemudaan</p>
                            <div x-show="role === 'customer'" x-transition.scale
                                class="absolute top-2 right-2 w-4 h-4 bg-navy rounded-full flex items-center justify-center">
                                <svg class="w-2.5 h-2.5 text-white" fill="currentColor" viewBox="0 0 20 20"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </label>

                        {{-- Contractor -> Leader --}}
                        <label for="role_contractor"
                            class="relative flex flex-col gap-2 p-4 border-2 rounded-xl cursor-pointer transition-all select-none"
                            :class="role === 'contractor' ? 'border-orange-500 bg-orange-50 shadow-sm' :
                                'border-slate-200 hover:border-slate-300 hover:bg-slate-50'">
                            <input type="radio" id="role_contractor" wire:model.live="role" value="contractor"
                                class="sr-only">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center transition-all"
                                    :class="role === 'contractor' ? 'bg-orange-500 text-white shadow-sm' :
                                        'bg-slate-100 text-slate-500'">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <span class="font-bold text-sm transition-all"
                                    :class="role === 'contractor' ? 'text-orange-600' : 'text-slate-600'">Ketua Pelaksana</span>
                            </div>
                            <p class="text-xs text-slate-500 leading-tight">Kelola organisasi & ajukan program</p>
                            <div x-show="role === 'contractor'" x-transition.scale
                                class="absolute top-2 right-2 w-4 h-4 bg-orange-500 rounded-full flex items-center justify-center">
                                <svg class="w-2.5 h-2.5 text-white" fill="currentColor" viewBox="0 0 20 20"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </label>
                    </div>
                    @error('role')
                        <p class="mt-1.5 text-xs text-danger-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Nama Lengkap --}}
                <div>
                    <label for="name" class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1.5">
                        Nama Lengkap
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg class="w-4.5 h-4.5 text-slate-400" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <input wire:model="name" id="name" type="text" autocomplete="name" required
                            class="w-full pl-10 pr-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-slate-800 text-sm outline-none transition-all
                                      focus:bg-white focus:border-navy focus:ring-4 focus:ring-navy/5
                                      placeholder:text-slate-400"
                            placeholder="Nama lengkap Anda" aria-label="Nama lengkap">
                    </div>
                    @error('name')
                        <p class="mt-1.5 text-xs text-danger-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label for="reg_email"
                        class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1.5">
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
                        <input wire:model="email" id="reg_email" type="email" autocomplete="username" required
                            class="w-full pl-10 pr-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-slate-800 text-sm outline-none transition-all
                                      focus:bg-white focus:border-navy focus:ring-4 focus:ring-navy/5
                                      placeholder:text-slate-400"
                            placeholder="nama@email.com" aria-label="Alamat email">
                    </div>
                    @error('email')
                        <p class="mt-1.5 text-xs text-danger-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- No HP --}}
                <div>
                    <label for="reg_phone"
                        class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1.5">
                        Nomor HP <span class="text-slate-400 font-normal normal-case tracking-normal">(Opsional)</span>
                    </label>
                    <div
                        class="flex rounded-xl overflow-hidden border-2 border-slate-200 focus-within:border-navy focus-within:ring-4 focus-within:ring-navy/5 transition-all">
                        <span
                            class="inline-flex items-center px-3.5 bg-slate-100 border-r border-slate-200 text-slate-500 text-sm font-medium">+62</span>
                        <input wire:model="phone" id="reg_phone" type="tel" autocomplete="tel"
                            class="flex-1 px-4 py-3 bg-slate-50 text-slate-800 text-sm outline-none placeholder:text-slate-400 focus:bg-white"
                            placeholder="81234567890" aria-label="Nomor HP">
                    </div>
                    @error('phone')
                        <p class="mt-1.5 text-xs text-danger-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div x-data="{ show: false }">
                    <label for="reg_password"
                        class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1.5">
                        Password
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg class="w-4.5 h-4.5 text-slate-400" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input wire:model="password" id="reg_password" :type="show ? 'text' : 'password'"
                            autocomplete="new-password" required
                            class="w-full pl-10 pr-12 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-slate-800 text-sm outline-none transition-all
                                      focus:bg-white focus:border-navy focus:ring-4 focus:ring-navy/5
                                      placeholder:text-slate-400"
                            placeholder="Minimal 8 karakter" aria-label="Password">
                        <button type="button" @click="show = !show"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 p-1 rounded-lg hover:bg-slate-100 transition"
                            :aria-label="show ? 'Sembunyikan' : 'Tampilkan'">
                            <svg x-show="!show" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg x-show="show" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1.5 text-xs text-danger-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Konfirmasi Password --}}
                <div>
                    <label for="reg_password_confirmation"
                        class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-1.5">
                        Konfirmasi Password
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg class="w-4.5 h-4.5 text-slate-400" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input wire:model="password_confirmation" id="reg_password_confirmation" type="password"
                            autocomplete="new-password" required
                            class="w-full pl-10 pr-4 py-3 bg-slate-50 border-2 border-slate-200 rounded-xl text-slate-800 text-sm outline-none transition-all
                                      focus:bg-white focus:border-navy focus:ring-4 focus:ring-navy/5
                                      placeholder:text-slate-400"
                            placeholder="Ulangi password" aria-label="Konfirmasi password">
                    </div>
                    @error('password_confirmation')
                        <p class="mt-1.5 text-xs text-danger-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit Button --}}
                <button type="submit"
                    class="w-full py-3.5 px-6 font-bold rounded-xl transition-all shadow-sm hover:shadow-md text-sm text-white"
                    :class="role === 'contractor' ? 'bg-orange-500 hover:bg-orange-600 active:bg-orange-700' :
                        'bg-navy hover:bg-navy-700 active:bg-navy-800'"
                    id="register-submit-btn">
                    <span wire:loading.remove wire:target="register">
                        <span x-show="role === 'customer'">Daftar Sebagai Verifikator — Gratis</span>
                        <span x-show="role === 'contractor'">Daftar Sebagai Ketua Pelaksana — Gratis</span>
                    </span>
                    <span wire:loading wire:target="register" class="flex items-center justify-center gap-2">
                        <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4" />
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                        </svg>
                        Membuat Akun...
                    </span>
                </button>
            </form>

            {{-- Footer Link --}}
            <p class="mt-5 text-center text-sm text-slate-500">
                Sudah punya akun?
                <a href="{{ route('login') }}" wire:navigate
                    class="font-semibold text-navy hover:text-orange-500 transition ml-1">
                    Masuk di sini
                </a>
            </p>

        </div>
    </div>

    {{-- Footer --}}
    <div class="relative pb-6 pt-2 text-center text-xs text-slate-400">
        &copy; {{ date('Y') }} SIPORA. Hak cipta dilindungi.
    </div>
</div>
