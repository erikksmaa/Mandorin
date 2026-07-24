<footer class="bg-navy border-t border-white/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10">
        <div class="flex flex-col gap-8 lg:flex-row lg:items-start lg:justify-between">
            <div class="max-w-md">
                <a href="{{ route('home') }}" wire:navigate class="inline-flex items-center gap-2 mb-3 group">
                    <div class="w-8 h-8 rounded-lg bg-orange-500 text-white flex items-center justify-center font-black text-base shadow-sm">
                        S
                    </div>
                    <span class="text-white font-bold text-lg" style="font-family: 'Big Shoulders Display', sans-serif;">SIPORA</span>
                </a>
                <p class="text-white/60 text-sm leading-relaxed">
                    Platform Digital Tata Kelola Program Kepemudaan yang Transparan, Terintegrasi, dan Akuntabel. Dindikpora Kabupaten Pemalang.
                </p>
            </div>

            <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3 lg:min-w-[540px]">
                <div>
                    <h4 class="text-white/80 text-xs font-bold uppercase tracking-widest mb-3">Platform</h4>
                    <nav class="space-y-2" aria-label="Footer platform links">
                        <a href="{{ route('public.organizations.index') }}" wire:navigate class="block text-white/60 hover:text-white text-sm transition">Cari Organisasi</a>
                        <a href="{{ route('public.programs.index') }}" wire:navigate class="block text-white/60 hover:text-white text-sm transition">Program Kepemudaan</a>
                        <a href="{{ route('public.search') }}" wire:navigate class="block text-white/60 hover:text-white text-sm transition">Pencarian</a>
                    </nav>
                </div>

                <div>
                    <h4 class="text-white/80 text-xs font-bold uppercase tracking-widest mb-3">Akun</h4>
                    <nav class="space-y-2" aria-label="Footer account links">
                        @guest
                            <a href="{{ route('login') }}" wire:navigate class="block text-white/60 hover:text-white text-sm transition">Masuk</a>
                            <a href="{{ route('register') }}" wire:navigate class="block text-white/60 hover:text-white text-sm transition">Daftar Gratis</a>
                        @endguest
                        @auth
                            <a href="{{ match(auth()->user()->role?->slug) { 'leader' => route('leader.dashboard'), 'administrator' => route('admin.dashboard'), default => route('verifier.dashboard') } }}" wire:navigate
                               class="block text-white/60 hover:text-white text-sm transition">Dashboard</a>
                            <a href="{{ route('profile') }}" wire:navigate class="block text-white/60 hover:text-white text-sm transition">Pengaturan Akun</a>
                        @endauth
                    </nav>
                </div>

                <div>
                    <h4 class="text-white/80 text-xs font-bold uppercase tracking-widest mb-3">Kontak</h4>
                    <div class="space-y-2">
                        <p class="text-white/60 text-sm">Dindikpora Kab. Pemalang</p>
                        <p class="text-white/60 text-sm">Jawa Tengah, Indonesia</p>
                        <p class="text-white/60 text-sm">dindikpora@pemalangkab.go.id</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-8 pt-6 border-t border-white/10 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <p class="text-center sm:text-left text-white/40 text-xs">&copy; {{ date('Y') }} SIPORA. Hak cipta dilindungi.</p>
            <p class="text-center sm:text-right text-white/30 text-xs">Dindikpora Kabupaten Pemalang</p>
        </div>
    </div>
</footer>
