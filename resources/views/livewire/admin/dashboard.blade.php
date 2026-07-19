<div>
    <h1 class="text-2xl font-bold text-slate-800 mb-6" style="font-family: 'Big Shoulders Display', sans-serif;">
        Dashboard Admin
    </h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-navy text-white rounded-2xl p-5 shadow-sm">
            <div class="text-sm opacity-80 mb-1">Total Pengguna</div>
            <div class="text-3xl font-bold">{{ $stats['totalUsers'] }}</div>
        </div>
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
            <div class="text-sm text-slate-500 mb-1">Total Kontraktor</div>
            <div class="text-3xl font-bold text-slate-800">{{ $stats['totalContractors'] }}</div>
        </div>
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
            <div class="text-sm text-slate-500 mb-1">Total Proyek</div>
            <div class="text-3xl font-bold text-slate-800">{{ $stats['totalProjects'] }}</div>
        </div>
        <div class="bg-amber-100 border border-amber-200 rounded-2xl p-5 shadow-sm">
            <div class="text-sm text-amber-800 mb-1">Antrian Verifikasi</div>
            <div class="text-3xl font-bold text-amber-900">{{ $stats['pendingVerifications'] }}</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-4">
            <h2 class="text-xl font-bold text-slate-800" style="font-family: 'Big Shoulders Display', sans-serif;">Proyek Terbaru</h2>
            <div class="bg-white border border-slate-200 shadow-sm rounded-2xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-600">
                        <thead class="bg-slate-50 text-slate-800 border-b border-slate-200">
                            <tr>
                                <th class="px-6 py-4 font-medium">Proyek</th>
                                <th class="px-6 py-4 font-medium">Customer</th>
                                <th class="px-6 py-4 font-medium">Kontraktor</th>
                                <th class="px-6 py-4 font-medium">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($recentProjects as $project)
                                <tr class="hover:bg-slate-50">
                                    <td class="px-6 py-4">{{ $project->title ?? 'Proyek #' . $project->id }}</td>
                                    <td class="px-6 py-4">{{ $project->customer->name ?? '-' }}</td>
                                    <td class="px-6 py-4">{{ $project->contractor->name ?? '-' }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $project->status->color() }}">
                                            {{ $project->status->label() }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-slate-500">Belum ada proyek.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <h2 class="text-xl font-bold text-slate-800" style="font-family: 'Big Shoulders Display', sans-serif;">Antrian Verifikasi Terbaru</h2>
            <div class="space-y-3">
                @forelse($pendingContractors as $contractor)
                    <div class="bg-white border border-slate-200 shadow-sm rounded-2xl p-4 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-navy flex-shrink-0 flex items-center justify-center text-white font-bold">
                                {{ substr($contractor->user->name ?? '?', 0, 1) }}
                            </div>
                            <div>
                                <div class="font-medium text-slate-800">{{ $contractor->user->name ?? '-' }}</div>
                                <div class="text-xs text-slate-500">{{ $contractor->address ?? 'Kontraktor' }}</div>
                            </div>
                        </div>
                        <a href="{{ route('admin.verification.show', $contractor) }}" class="px-3 py-1.5 bg-orange-50 text-orange-600 hover:bg-orange-100 rounded-lg text-sm font-medium transition">
                            Cek
                        </a>
                    </div>
                @empty
                    <div class="bg-white border border-slate-200 shadow-sm rounded-2xl p-6 text-center text-slate-500">
                        Tidak ada antrian verifikasi.
                    </div>
                @endforelse
            </div>
            <a href="{{ route('admin.verification.index') }}" class="block w-full py-2.5 border border-slate-200 text-center rounded-xl text-slate-600 hover:bg-slate-50 font-medium transition">
                Lihat Semua Antrian
            </a>
        </div>
    </div>
</div>
