<div>
    <h1 class="text-2xl font-bold text-slate-800 mb-6" style="font-family: 'Big Shoulders Display', sans-serif;">
        Dashboard Kontraktor
    </h1>

    @if($contractorProfile && $contractorProfile->verification_status?->value !== 'verified')
        <div class="mb-6 px-4 py-3 bg-amber-100 text-amber-700 rounded-xl border border-amber-200">
            <div class="flex justify-between items-center">
                <span>Status profil Anda saat ini adalah <strong>{{ $contractorProfile->verification_status?->label() ?? 'Pending' }}</strong>. Beberapa fitur mungkin dibatasi sampai profil Anda diverifikasi.</span>
                <a href="{{ route('profile.edit') }}" class="text-sm font-medium underline">Lihat Profil</a>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white border border-slate-200 shadow-sm rounded-2xl p-5">
            <h3 class="text-sm font-medium text-slate-500 mb-1">Permintaan Masuk</h3>
            <div class="text-3xl font-bold text-orange-500">{{ $stats['pending'] }}</div>
        </div>
        <div class="bg-white border border-slate-200 shadow-sm rounded-2xl p-5">
            <h3 class="text-sm font-medium text-slate-500 mb-1">Proyek Aktif</h3>
            <div class="text-3xl font-bold text-navy">{{ $stats['active'] }}</div>
        </div>
        <div class="bg-white border border-slate-200 shadow-sm rounded-2xl p-5">
            <h3 class="text-sm font-medium text-slate-500 mb-1">Selesai</h3>
            <div class="text-3xl font-bold text-green-600">{{ $stats['completed'] }}</div>
        </div>
    </div>

    <div class="mb-8">
        <h2 class="text-xl font-bold text-slate-800 mb-4" style="font-family: 'Big Shoulders Display', sans-serif;">Permintaan Masuk</h2>
        
        @if($pendingRequests->isEmpty())
            <div class="bg-white border border-slate-200 shadow-sm rounded-2xl p-8 text-center text-slate-500">
                Belum ada permintaan masuk saat ini.
            </div>
        @else
            <div class="space-y-4">
                @foreach($pendingRequests as $project)
                <div class="bg-white border border-slate-200 shadow-sm rounded-2xl p-5">
                    <div class="flex flex-col md:flex-row md:items-start gap-4 justify-between">
                        <div>
                            <h3 class="font-bold text-slate-800 text-lg">{{ $project->title }}</h3>
                            <div class="text-sm text-slate-600 mt-1">
                                <span class="font-medium text-slate-800">{{ $project->customer->name }}</span> 
                                &bull; {{ $project->service?->name ?? 'Layanan' }}
                            </div>
                            <div class="text-sm text-slate-500 mt-1">
                                <span>Alamat: {{ Str::limit($project->address, 50) }}</span>
                            </div>
                            <div class="text-xs text-slate-400 mt-2">
                                Tanggal Masuk: {{ $project->created_at->format('d M Y') }}
                            </div>
                        </div>
                        <div class="mt-4 md:mt-0 self-start">
                            <a href="{{ route('contractor.requests.show', $project) }}" class="inline-block px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-xl font-medium transition text-sm">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>

    <div>
        <h2 class="text-xl font-bold text-slate-800 mb-4" style="font-family: 'Big Shoulders Display', sans-serif;">Proyek Aktif</h2>
        
        @if($activeProjects->isEmpty())
            <div class="bg-white border border-slate-200 shadow-sm rounded-2xl p-8 text-center text-slate-500">
                Tidak ada proyek aktif saat ini.
            </div>
        @else
            <div class="space-y-4">
                @foreach($activeProjects as $project)
                <div class="bg-white border border-slate-200 shadow-sm rounded-2xl p-5">
                    <div class="flex flex-col md:flex-row md:items-center gap-4 justify-between">
                        <div class="flex-grow">
                            <div class="flex items-center gap-3 mb-1">
                                <h3 class="font-bold text-slate-800 text-lg">{{ $project->title }}</h3>
                                <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $project->status->value === 'in_progress' ? 'bg-navy text-white' : 'bg-amber-100 text-amber-700' }}">
                                    {{ $project->status->label() }}
                                </span>
                            </div>
                            <div class="text-sm text-slate-600">
                                Klien: <span class="font-medium">{{ $project->customer->name }}</span>
                            </div>
                            
                            <div class="mt-4 max-w-md">
                                <div class="flex justify-between text-xs mb-1">
                                    <span class="text-slate-500">Progress</span>
                                    <span class="font-medium text-slate-800">{{ $project->progress_percentage ?? 0 }}%</span>
                                </div>
                                <div class="w-full bg-slate-100 rounded-full h-2">
                                    <div class="bg-green-500 h-2 rounded-full" style="width: {{ $project->progress_percentage ?? 0 }}%"></div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 md:mt-0 flex-shrink-0">
                            <a href="{{ route('contractor.projects.show', $project) }}" class="inline-block px-4 py-2 border border-slate-300 hover:bg-slate-50 text-slate-700 rounded-xl font-medium transition text-sm">
                                Kelola
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
