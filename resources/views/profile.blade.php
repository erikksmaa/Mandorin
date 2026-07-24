<x-app-layout>
    <div class="max-w-4xl mx-auto">

        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-800" style="font-family: 'Big Shoulders Display', sans-serif;">
                Pengaturan Akun
            </h1>
            <p class="text-slate-500 mt-1 text-sm">Kelola informasi akun dan keamanan Anda.</p>
        </div>

        {{-- Role-based Banner for Contractor --}}
        @if(auth()->user()->role?->slug === 'leader')
            <div class="mb-6 flex items-center gap-3 bg-amber-50 border border-amber-200 rounded-2xl p-4">
                <div class="text-amber-500 shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-amber-800">Anda terdaftar sebagai <strong>Ketua Pelaksana/Organisasi</strong>.</p>
                    <p class="text-xs text-amber-700 mt-0.5">Untuk mengelola profil organisasi dan dokumen, kunjungi halaman Profil Organisasi.</p>
                </div>
                <a href="{{ route('leader.profile.show') }}" class="shrink-0 text-xs font-semibold bg-amber-500 text-white py-1.5 px-3 rounded-lg hover:bg-amber-600 transition">
                    Profil Organisasi →
                </a>
            </div>
        @endif

        <div class="grid grid-cols-1 gap-6">
            {{-- Update Profile Info --}}
            <div class="bg-white border border-slate-200 shadow-sm rounded-2xl overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                    <h2 class="text-base font-semibold text-slate-800 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-navy" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" /></svg>
                        Informasi Profil
                    </h2>
                </div>
                <div class="p-6">
                    <livewire:profile.update-profile-information-form />
                </div>
            </div>

            {{-- Update Password --}}
            <div class="bg-white border border-slate-200 shadow-sm rounded-2xl overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                    <h2 class="text-base font-semibold text-slate-800 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-navy" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" /></svg>
                        Ubah Password
                    </h2>
                </div>
                <div class="p-6">
                    <livewire:profile.update-password-form />
                </div>
            </div>

            {{-- Delete Account --}}
            <div class="bg-white border border-red-100 shadow-sm rounded-2xl overflow-hidden">
                <div class="px-6 py-4 border-b border-red-100 bg-red-50/50">
                    <h2 class="text-base font-semibold text-red-700 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                        Hapus Akun
                    </h2>
                </div>
                <div class="p-6">
                    <livewire:profile.delete-user-form />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
