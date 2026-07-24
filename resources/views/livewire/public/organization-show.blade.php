<x-slot:seo>
    <x-public.seo
        :title="($organization->name ?? 'Organisasi') . ' — Profil Organisasi | SIPORA'"
        :description="$organization->description ?? 'Lihat profil dan program ' . ($organization->name ?? '') . ' di SIPORA.'"
    />
</x-slot:seo>

<div>
    <main>
        {{-- Breadcrumb --}}
        <div class="bg-slate-50 border-b border-slate-200 py-3">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <nav class="flex items-center gap-2 text-sm text-slate-500" aria-label="Breadcrumb">
                    <a href="{{ route('home') }}" wire:navigate class="hover:text-navy transition">Beranda</a>
                    <span aria-hidden="true">›</span>
                    <a href="{{ route('public.organizations.index') }}" wire:navigate class="hover:text-navy transition">Organisasi</a>
                    <span aria-hidden="true">›</span>
                    <span class="text-slate-800 font-medium truncate">{{ $organization->name }}</span>
                </nav>
            </div>
        </div>

        <div class="bg-slate-50 min-h-screen py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-3 gap-8">

                    {{-- LEFT: Sidebar Info --}}
                    <aside class="lg:col-span-1 space-y-5">

                        {{-- Profil Card --}}
                        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm text-center">
                            {{-- Logo --}}
                            <div class="w-24 h-24 rounded-2xl overflow-hidden bg-slate-100 mx-auto mb-4 border-2 border-slate-200">
                                @if($organization->logo)
                                    <img src="{{ asset('storage/' . $organization->logo) }}"
                                         alt="Logo {{ $organization->name }}"
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-navy text-white font-black text-3xl">
                                        {{ strtoupper(substr($organization->name, 0, 1)) }}
                                    </div>
                                @endif
                            </div>

                            <h1 class="text-xl font-bold text-slate-800 mb-1">{{ $organization->name }}</h1>
                            <p class="text-xs text-orange-600 font-semibold mb-3">{{ $organization->category?->name ?? 'Organisasi Kepemudaan' }}</p>

                            {{-- Status --}}
                            @if(($organization->status?->value ?? $organization->status) === 'active')
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700 mb-3">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    Terverifikasi
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700 mb-3">Belum Terverifikasi</span>
                            @endif

                            {{-- Details --}}
                            <div class="text-xs text-slate-600 text-left space-y-2 mt-4 pt-4 border-t border-slate-100">
                                @if($organization->address)
                                    <div>
                                        <span class="font-semibold block text-slate-500">Alamat:</span>
                                        <span>{{ $organization->address }}</span>
                                    </div>
                                @endif
                                @if($organization->email)
                                    <div>
                                        <span class="font-semibold block text-slate-500">Email:</span>
                                        <span>{{ $organization->email }}</span>
                                    </div>
                                @endif
                                @if($organization->phone)
                                    <div>
                                        <span class="font-semibold block text-slate-500">No. HP:</span>
                                        <span>{{ $organization->phone }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </aside>

                    {{-- RIGHT: Detail Content --}}
                    <div class="lg:col-span-2 space-y-6">

                        {{-- Deskripsi --}}
                        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                            <h2 class="font-bold text-slate-800 text-lg mb-3" style="font-family: 'Big Shoulders Display', sans-serif;">
                                Tentag Organisasi
                            </h2>
                            <p class="text-slate-600 text-sm leading-relaxed whitespace-pre-line">
                                {{ $organization->description ?? 'Belum ada deskripsi profil.' }}
                            </p>
                        </div>

                        {{-- Daftar Program --}}
                        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                            <h2 class="font-bold text-slate-800 text-lg mb-4" style="font-family: 'Big Shoulders Display', sans-serif;">
                                Program Organisasi ({{ $organization->programs?->count() ?? 0 }})
                            </h2>
                            @if($organization->programs && $organization->programs->isNotEmpty())
                                <div class="space-y-3">
                                    @foreach($organization->programs as $program)
                                        <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl flex items-center justify-between">
                                            <div>
                                                <h3 class="font-bold text-slate-800 text-sm">{{ $program->title }}</h3>
                                                <p class="text-xs text-slate-500 mt-0.5">📂 {{ $program->category?->name ?? 'Program' }}</p>
                                            </div>
                                            <a href="{{ route('public.programs.show', $program) }}" wire:navigate class="text-xs font-semibold text-orange-500 hover:underline">
                                                Lihat →
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-slate-500 text-sm">Belum ada program publik yang terdaftar.</p>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
