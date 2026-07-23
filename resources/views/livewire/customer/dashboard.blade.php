<div>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800" style="font-family: 'Big Shoulders Display', sans-serif;">
            Selamat datang, {{ auth()->user()->name }}!
        </h1>
        <p class="text-slate-500">Pantau aktivitas dan proyek konstruksi Anda di sini.</p>
    </div>

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
        <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-5 border-l-4 border-l-amber-500">
            <h3 class="text-sm font-medium text-slate-500">Menunggu</h3>
            <p class="text-3xl font-bold font-mono text-slate-800 mt-2">{{ $pendingCount }}</p>
        </div>
        <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-5 border-l-4 border-l-navy">
            <h3 class="text-sm font-medium text-slate-500">Aktif</h3>
            <p class="text-3xl font-bold font-mono text-slate-800 mt-2">{{ $activeCount }}</p>
        </div>
        <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-5 border-l-4 border-l-green-500">
            <h3 class="text-sm font-medium text-slate-500">Selesai</h3>
            <p class="text-3xl font-bold font-mono text-slate-800 mt-2">{{ $completedCount }}</p>
        </div>
    </div>

    <!-- CTA Banner -->
    <div class="bg-navy rounded-xl p-6 flex flex-col md:flex-row items-center justify-between mb-8 text-white shadow-sm">
        <div>
            <h2 class="text-xl font-bold mb-2">Belum punya kontraktor?</h2>
            <p class="text-slate-300 text-sm">Cari dan temukan kontraktor terbaik untuk proyek Anda sekarang.</p>
        </div>
        <a href="{{ route('public.contractors.index') }}" class="mt-4 md:mt-0 px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white rounded-xl font-medium transition whitespace-nowrap inline-block text-center">
            Cari Sekarang
        </a>
    </div>

    <!-- Recent Projects -->
    <h2 class="text-lg font-bold text-slate-800 mb-4" style="font-family: 'Big Shoulders Display', sans-serif;">Proyek Terbaru</h2>
    <div class="space-y-4">
        @forelse ($recentProjects as $project)
            <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-5">
                <div class="flex flex-col md:flex-row md:items-center gap-4">
                    <div class="flex-grow">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-xs font-mono text-slate-500">{{ $project->project_code }}</span>
                            <h3 class="font-bold text-lg text-slate-800">{{ $project->title }}</h3>
                        </div>
                        <p class="text-sm text-slate-600">Layanan: <span class="font-medium">{{ $project->service->name }}</span></p>
                        <p class="text-sm text-slate-600">Kontraktor: <span class="font-medium">{{ $project->contractor ? $project->contractor->name : 'Belum ditentukan' }}</span></p>
                    </div>
                    <div class="flex flex-col items-end gap-2 shrink-0">
                        @php
                            $statusColors = [
                                'pending' => 'bg-amber-100 text-amber-700',
                                'accepted' => 'bg-blue-100 text-blue-700',
                                'in_progress' => 'bg-indigo-100 text-indigo-700',
                                'completed' => 'bg-green-100 text-green-700',
                                'rejected' => 'bg-red-100 text-red-700',
                                'cancelled' => 'bg-slate-100 text-slate-700',
                            ];
                            $statusColor = $statusColors[$project->status->value] ?? 'bg-slate-100 text-slate-700';
                        @endphp
                        <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $statusColor }}">
                            {{ $project->status->label() }}
                        </span>

                        <div class="w-32 bg-slate-100 rounded-full h-2 mt-2">
                            <div class="bg-navy h-2 rounded-full" style="width: {{ $project->progress_percentage }}%"></div>
                        </div>

                        <a href="{{ route('customer.projects.show', $project) }}" class="mt-2 text-sm text-orange-500 hover:text-orange-600 font-medium">
                            Lihat Detail &rarr;
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-8 text-center text-sm text-slate-500">
                Belum ada proyek terbaru.
            </div>
        @endforelse
    </div>
</div>