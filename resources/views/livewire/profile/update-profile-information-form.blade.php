<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $phone = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name  = Auth::user()->name;
        $this->email = Auth::user()->email;
        $this->phone = Auth::user()->phone ?? '';
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate(
            [
                'name'  => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
                'phone' => ['nullable', 'string', 'max:20'],
            ],
            [
                'name.required'  => 'Nama lengkap wajib diisi.',
                'email.required' => 'Alamat email wajib diisi.',
                'email.email'    => 'Format email tidak valid.',
                'email.unique'   => 'Email ini sudah digunakan oleh akun lain.',
                'phone.max'      => 'Nomor HP maksimal 20 karakter.',
            ]
        );

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('swal-success', title: 'Profil Diperbarui!', text: 'Informasi akun Anda berhasil disimpan.');
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function sendVerification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $roleSlug = $user->role?->slug ?? '';
            $targetRoute = match ($roleSlug) {
                'administrator', 'admin'  => route('admin.dashboard', absolute: false),
                'leader', 'contractor'    => route('leader.dashboard', absolute: false),
                default                   => route('verifier.dashboard', absolute: false),
            };
            $this->redirectIntended(default: $targetRoute);
            return;
        }

        $user->sendEmailVerificationNotification();
        Session::flash('status', 'verification-link-sent');
    }
}; ?>



<section>
    <form wire:submit="updateProfileInformation" class="space-y-5">
        <div>
            <label for="name" class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap *</label>
            <input wire:model="name" id="name" name="name" type="text"
                   class="w-full rounded-xl border-slate-300 focus:border-navy focus:ring-navy shadow-sm"
                   required autofocus autocomplete="name">
            @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Alamat Email *</label>
            <input wire:model="email" id="email" name="email" type="email"
                   class="w-full rounded-xl border-slate-300 focus:border-navy focus:ring-navy shadow-sm"
                   required autocomplete="username">
            @error('email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror

            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="text-sm text-slate-700">
                        Email belum terverifikasi.
                        <button wire:click.prevent="sendVerification" class="underline text-sm text-orange-500 hover:text-orange-700">
                            Kirim ulang email verifikasi.
                        </button>
                    </p>
                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            Link verifikasi baru telah dikirim ke email Anda.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div>
            <label for="phone" class="block text-sm font-medium text-slate-700 mb-1">Nomor HP / WhatsApp</label>
            <div class="flex">
                <span class="inline-flex items-center px-3 rounded-l-xl border border-r-0 border-slate-300 bg-slate-50 text-slate-500 text-sm">+62</span>
                <input wire:model="phone" id="phone" name="phone" type="tel" placeholder="81234567890"
                       class="flex-1 rounded-r-xl border-slate-300 focus:border-navy focus:ring-navy shadow-sm"
                       autocomplete="tel">
            </div>
            <p class="text-xs text-slate-400 mt-1">Nomor ini digunakan untuk fitur Chat via WhatsApp dengan pelanggan.</p>
            @error('phone') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div class="pt-2">
            <button type="submit"
                    class="px-6 py-2.5 bg-navy hover:bg-navy/90 text-white text-sm font-semibold rounded-xl transition shadow-sm">
                <span wire:loading.remove wire:target="updateProfileInformation">Simpan Perubahan</span>
                <span wire:loading wire:target="updateProfileInformation">Menyimpan...</span>
            </button>
        </div>
    </form>
</section>
