<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Volt\Component;

new class extends Component
{
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Update the password for the currently authenticated user.
     */
    public function updatePassword(): void
    {
        try {
            $validated = $this->validate([
                'current_password' => ['required', 'string', 'current_password'],
                'password' => ['required', 'string', Password::defaults(), 'confirmed'],
            ]);
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');

            throw $e;
        }

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');

        $this->dispatch('password-updated');
    }
}; ?>

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form wire:submit="updatePassword" class="space-y-5">
        <div>
            <label for="update_password_current_password" class="block text-sm font-medium text-slate-700 mb-1">Password Saat Ini *</label>
            <input wire:model="current_password" id="update_password_current_password" name="current_password" type="password"
                   class="w-full rounded-xl border-slate-300 focus:border-navy focus:ring-navy shadow-sm"
                   autocomplete="current-password">
            @error('current_password') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="update_password_password" class="block text-sm font-medium text-slate-700 mb-1">Password Baru *</label>
            <input wire:model="password" id="update_password_password" name="password" type="password"
                   class="w-full rounded-xl border-slate-300 focus:border-navy focus:ring-navy shadow-sm"
                   autocomplete="new-password">
            @error('password') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="update_password_password_confirmation" class="block text-sm font-medium text-slate-700 mb-1">Konfirmasi Password Baru *</label>
            <input wire:model="password_confirmation" id="update_password_password_confirmation" name="password_confirmation" type="password"
                   class="w-full rounded-xl border-slate-300 focus:border-navy focus:ring-navy shadow-sm"
                   autocomplete="new-password">
            @error('password_confirmation') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div class="pt-2">
            <button type="submit"
                    class="px-6 py-2.5 bg-navy hover:bg-navy/90 text-white text-sm font-semibold rounded-xl transition shadow-sm">
                <span wire:loading.remove wire:target="updatePassword">Ubah Password</span>
                <span wire:loading wire:target="updatePassword">Menyimpan...</span>
            </button>
        </div>
    </form>
</section>
