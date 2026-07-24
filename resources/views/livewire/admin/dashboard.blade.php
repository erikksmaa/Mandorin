<div>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800" style="font-family: 'Big Shoulders Display', sans-serif;">
            Selamat datang, Admin {{ auth()->user()->name }}!
        </h1>
        <p class="text-slate-500 text-sm">Ringkasan aktivitas platform SIPORA.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-5 border-l-4 border-l-blue-500">
            <div class="text-sm text-slate-500 font-medium mb-1">Total Pengguna</div>
            <div class="text-3xl font-bold text-slate-800 font-mono">{{ $totalUsers }}</div>
        </div>
        <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-5 border-l-4 border-l-orange-500">
            <div class="text-sm text-slate-500 font-medium mb-1">Total Organisasi</div>
            <div class="text-3xl font-bold text-slate-800 font-mono">{{ $totalOrganizations }}</div>
        </div>
        <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-5 border-l-4 border-l-green-500">
            <div class="text-sm text-slate-500 font-medium mb-1">Total Program</div>
            <div class="text-3xl font-bold text-slate-800 font-mono">{{ $totalPrograms }}</div>
        </div>
        <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-5 border-l-4 border-l-amber-500">
            <div class="text-sm text-slate-500 font-medium mb-1">Antrian Verifikasi</div>
            <div class="text-3xl font-bold text-amber-600 font-mono">{{ $pendingVerifications }}</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-4">
            <h2 class="text-lg font-bold text-slate-800" style="font-family: 'Big Shoulders Display', sans-serif;">Program Terbaru</h2>
            <div class="bg-white border border-slate-200 shadow-sm rounded-xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-600">
                        <thead class="bg-slate-50 text-slate-800 border-b border-slate-200">
                            <tr>
                                <th class="px-6 py-4 font-medium">Program</th>
                                <th class="px-6 py-4 font-medium">Ketua Pelaksana</th>
                                <th class="px-6 py-4 font-medium">Organisasi</th>
                                <th class="px-6 py-4 font-medium">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($recentPrograms as $program)
                                <tr class="hover:bg-slate-50">
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-slate-800">{{ $program->title }}</div>
                                        <div class="text-xs text-slate-400 font-mono">{{ $program->program_code }}</div>
                                    </td>
                                    <td class="px-6 py-4">{{ $program->leader?->name ?? '-' }}</td>
                                    <td class="px-6 py-4">{{ $program->organization?->name ?? '-' }}</td>
                                    <td class="px-6 py-4">
                                        @php
                                            $statusMap = [
                                                'Draft'     => 'bg-slate-100 text-slate-700',
                                                'Submitted' => 'bg-amber-100 text-amber-700',
                                                'Approved'  => 'bg-blue-100 text-blue-700',
                                                'Running'   => 'bg-indigo-100 text-indigo-700',
                                                'Completed' => 'bg-green-100 text-green-700',
                                                'Cancelled' => 'bg-red-100 text-red-700',
                                            ];
                                            $statusVal   = $program->status instanceof \BackedEnum ? $program->status->value : $program->status;
                                            $statusColor = $statusMap[$statusVal] ?? 'bg-slate-100 text-slate-700';
                                            $statusLabel = $program->status instanceof \BackedEnum ? $program->status->label() : ucfirst($statusVal);
                                        @endphp
                                        <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $statusColor }}">
                                            {{ $statusLabel }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-slate-500">Belum ada program.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <h2 class="text-lg font-bold text-slate-800" style="font-family: 'Big Shoulders Display', sans-serif;">Antrian Verifikasi Terbaru</h2>
            <div class="space-y-3">
                @forelse($recentOrganizations as $organization)
                    <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-4 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-navy flex-shrink-0 flex items-center justify-center text-white font-bold">
                                {{ strtoupper(substr($organization->name ?? '?', 0, 1)) }}
                            </div>
                            <div>
                                <div class="font-medium text-slate-800">{{ $organization->name ?? '-' }}</div>
                                <div class="text-xs text-slate-500">{{ $organization->category?->name ?? 'Organisasi' }}</div>
                            </div>
                        </div>
                        <a href="{{ route('admin.verification.show', $organization) }}" class="px-3 py-1.5 bg-orange-50 text-orange-600 hover:bg-orange-100 rounded-lg text-sm font-medium transition">
                            Cek
                        </a>
                    </div>
                @empty
                    <div class="bg-white border border-slate-200 shadow-sm rounded-xl p-6 text-center text-sm text-slate-500">
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
