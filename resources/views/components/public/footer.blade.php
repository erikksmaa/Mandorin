<footer class="bg-navy border-t border-white/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10">
        <div class="flex flex-col gap-8 lg:flex-row lg:items-start lg:justify-between">
            <div class="max-w-md">
                <a href="{{ route('home') }}" wire:navigate class="inline-flex items-center gap-2 mb-3">
                    <svg class="w-6 h-6 text-orange-400" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 8.25h3m-3 3.75h3M6.75 15h.008v.008H6.75V15z"/>
                    </svg>
                    <span class="text-white font-bold text-lg" style="font-family: 'Big Shoulders Display', sans-serif;">Mandorin</span>
                </a>
                <p class="text-white/60 text-sm leading-relaxed">
                    Platform digital yang menghubungkan pemilik properti dengan kontraktor & mandor terpercaya di seluruh Indonesia.
                </p>
            </div>

            <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3 lg:min-w-[540px]">
                <div>
                    <h4 class="text-white/80 text-xs font-bold uppercase tracking-widest mb-3">Platform</h4>
                    <nav class="space-y-2" aria-label="Footer platform links">
                        <a href="{{ route('public.contractors.index') }}" wire:navigate class="block text-white/60 hover:text-white text-sm transition">Cari Kontraktor</a>
                        <a href="{{ route('public.portfolios.index') }}" wire:navigate class="block text-white/60 hover:text-white text-sm transition">Galeri Portfolio</a>
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
                            <a href="{{ match(auth()->user()->role?->value) { 'contractor' => route('contractor.dashboard'), 'admin' => route('admin.dashboard'), default => route('customer.dashboard') } }}" wire:navigate
                               class="block text-white/60 hover:text-white text-sm transition">Dashboard</a>
                            <a href="{{ route('profile') }}" wire:navigate class="block text-white/60 hover:text-white text-sm transition">Pengaturan Akun</a>
                        @endauth
                    </nav>
                </div>

                <div>
                    <h4 class="text-white/80 text-xs font-bold uppercase tracking-widest mb-3">Kontak</h4>
                    <div class="space-y-2">
                        <p class="text-white/60 text-sm">Jawa Tengah, Indonesia</p>
                        <p class="text-white/60 text-sm">mandorin@platform.id</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-8 pt-6 border-t border-white/10 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <p class="text-center sm:text-left text-white/40 text-xs">&copy; {{ date('Y') }} Mandorin. Hak cipta dilindungi.</p>
            <p class="text-center sm:text-right text-white/30 text-xs">Platform Digital Konstruksi Indonesia</p>
        </div>
    </div>
</footer>
