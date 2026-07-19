<div>
    <!-- Breadcrumb -->
    <div class="mb-4 text-sm text-slate-500">
        <a href="{{ route('customer.contractors.index') }}" class="hover:text-navy">Cari Kontraktor</a>
        <span class="mx-2">&rsaquo;</span>
        <span class="text-slate-700">Profil</span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Hero Section -->
            <div class="bg-white border border-slate-200 shadow-sm rounded-2xl p-6">
                <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
                    <div class="w-32 h-32 rounded-full overflow-hidden bg-slate-100 shrink-0 border-4 border-white shadow-md">
                        @if ($contractorProfile->profile_photo)
                            <img src="{{ asset('storage/' . $contractorProfile->profile_photo) }}" alt="{{ $contractorProfile->user->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-navy text-white font-bold text-4xl">
                                {{ substr($contractorProfile->user->name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    
                    <div class="text-center md:text-left flex-grow">
                        <h1 class="text-2xl font-bold text-slate-800 flex flex-col md:flex-row items-center gap-2 mb-1">
                            {{ $contractorProfile->user->name }}
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                Terverifikasi
                            </span>
                        </h1>
                        <p class="text-slate-500 mb-3">Kontraktor Mandorin</p>
                        
                        <div class="flex flex-wrap justify-center md:justify-start gap-2 mb-4">
                            @foreach ($contractorProfile->services as $svc)
                                <span class="px-3 py-1 bg-slate-100 text-slate-700 text-sm rounded-lg border border-slate-200">{{ $svc->name }}</span>
                            @endforeach
                        </div>
                        
                        <p class="text-sm text-slate-600 flex items-start gap-1">
                            <span class="shrink-0 mt-0.5">📍</span>
                            <span>{{ $contractorProfile->address ?? 'Alamat tidak tersedia' }}</span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Bio -->
            <div class="bg-white border border-slate-200 shadow-sm rounded-2xl p-6">
                <h2 class="text-xl font-bold text-slate-800 mb-4" style="font-family: 'Big Shoulders Display', sans-serif;">Tentang Kami</h2>
                <div class="prose prose-sm text-slate-600 max-w-none whitespace-pre-wrap">{{ $contractorProfile->bio ?? 'Belum ada deskripsi.' }}</div>
            </div>

            <!-- Portfolios -->
            <div class="bg-white border border-slate-200 shadow-sm rounded-2xl p-6">
                <h2 class="text-xl font-bold text-slate-800 mb-4" style="font-family: 'Big Shoulders Display', sans-serif;">Portofolio Proyek</h2>
                
                @if($contractorProfile->portfolios->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach ($contractorProfile->portfolios as $portfolio)
                            <div class="border border-slate-200 rounded-xl overflow-hidden group">
                                <div class="grid grid-cols-2">
                                    <div class="aspect-square relative bg-slate-100">
                                        @if($portfolio->before_photo)
                                            <img src="{{ asset('storage/' . $portfolio->before_photo) }}" alt="Before" class="w-full h-full object-cover">
                                        @endif
                                        <div class="absolute bottom-2 left-2 bg-black/60 text-white text-xs px-2 py-1 rounded">Sebelum</div>
                                    </div>
                                    <div class="aspect-square relative bg-slate-100">
                                        @if($portfolio->after_photo)
                                            <img src="{{ asset('storage/' . $portfolio->after_photo) }}" alt="After" class="w-full h-full object-cover">
                                        @endif
                                        <div class="absolute bottom-2 left-2 bg-black/60 text-white text-xs px-2 py-1 rounded">Sesudah</div>
                                    </div>
                                </div>
                                <div class="p-3 bg-slate-50">
                                    <h3 class="font-semibold text-slate-800 text-sm truncate">{{ $portfolio->title }}</h3>
                                    <p class="text-xs text-slate-500 mt-1 line-clamp-2">{{ $portfolio->description }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-slate-500 text-sm">Belum ada portofolio yang ditambahkan.</p>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Stats & CTA Sticky Card -->
            <div class="bg-white border border-slate-200 shadow-sm rounded-2xl p-6 sticky top-6">
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div class="text-center p-3 bg-slate-50 rounded-xl border border-slate-100">
                        <div class="text-2xl font-bold font-mono text-slate-800">{{ $contractorProfile->total_projects ?? 0 }}</div>
                        <div class="text-xs text-slate-500 mt-1">Proyek Selesai</div>
                    </div>
                    <div class="text-center p-3 bg-slate-50 rounded-xl border border-slate-100">
                        <div class="flex items-center justify-center gap-1">
                            <span class="text-amber-500">⭐</span>
                            <span class="text-2xl font-bold font-mono text-slate-800">{{ number_format($contractorProfile->rating ?? 0, 1) }}</span>
                        </div>
                        <div class="text-xs text-slate-500 mt-1">{{ $contractorProfile->total_reviews ?? 0 }} Ulasan</div>
                    </div>
                </div>

                <div class="border-t border-slate-200 pt-6">
                    <a href="{{ route('customer.hire.create', $contractorProfile) }}" class="block w-full py-3 px-4 bg-orange-500 hover:bg-orange-600 text-white text-center rounded-xl font-bold transition shadow-sm text-lg">
                        Sewa Kontraktor Ini
                    </a>
                    <p class="text-xs text-center text-slate-500 mt-3">
                        Aman dan terpercaya melalui platform Mandorin.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
