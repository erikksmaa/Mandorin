<div>
    <h1 class="text-2xl font-bold text-slate-800 mb-6" style="font-family: 'Big Shoulders Display', sans-serif;">
        Proyek Saya
    </h1>

    <!-- Filter Chips -->
    <div class="flex flex-wrap gap-2 mb-6">
        @php
            $filters = [
                '' => 'Semua',
                'pending' => 'Menunggu',
                'accepted' => 'Diterima',
                'in_progress' => 'Berjalan',
                'completed' => 'Selesai',
                'rejected' => 'Ditolak',
            ];
        @endphp

        @foreach($filters as $val => $label)
            <button wire:click="setFilterStatus('{{ $val }}')" class="px-4 py-1.5 rounded-full text-sm font-medium transition {{ $filterStatus === $val ? 'bg-navy text-white' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
                {{ $label }}
            </button>
        @endforeach
    </div>

    <!-- Project List -->
    <div class="space-y-4">
        @forelse ($projects as $project)
            <div class="bg-white border border-slate-200 shadow-sm rounded-2xl p-5">
                <div class="flex flex-col md:flex-row md:items-center gap-4">
                    <div class="w-full md:w-1/3">
                        <span class="text-xs font-mono text-slate-500 mb-1 block">{{ $project->project_code }}</span>
                        <h3 class="font-bold text-lg text-slate-800 line-clamp-1">{{ $project->title }}</h3>
                        <span class="inline-block mt-2 px-2 py-1 bg-slate-100 text-slate-600 text-xs rounded-md">
                            {{ $project->service->name }}
                        </span>
                    </div>

                    <div class="w-full md:w-1/3 flex flex-col justify-center border-t border-b md:border-y-0 md:border-x border-slate-100 py-3 md:py-0 md:px-4">
                        <p class="text-sm text-slate-600 mb-1">
                            <span class="font-medium">Kontraktor:</span> {{ $project->contractor ? $project->contractor->name : 'Belum ditentukan' }}
                        </p>
                        <p class="text-xs text-slate-500 line-clamp-1">
                            📍 {{ $project->address }}
                        </p>
                        <p class="text-xs text-slate-400 mt-2">
                            🗓️ Request: {{ $project->requested_at ? $project->requested_at->format('d M Y') : $project->created_at->format('d M Y') }}
                        </p>
                    </div>

                    <div class="w-full md:w-1/3 flex flex-col items-start md:items-end justify-center">
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

                        <div class="flex items-center justify-between w-full md:w-auto md:justify-end gap-4 mb-3">
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $statusColor }}">
                                {{ $project->status->label() }}
                            </span>
                        </div>

                        <div class="w-full md:w-32 bg-slate-100 rounded-full h-2 mb-3">
                            <div class="bg-navy h-2 rounded-full" style="width: {{ $project->progress_percentage }}%"></div>
                        </div>

                        <a href="{{ route('customer.projects.show', $project) }}" class="w-full md:w-auto px-4 py-2 text-sm border-2 border-orange-500 text-orange-500 hover:bg-orange-50 text-center rounded-xl font-medium transition block">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white border border-slate-200 shadow-sm rounded-2xl p-10 text-center text-slate-500">
                <div class="text-4xl mb-3">📋</div>
                <p>Belum ada proyek yang sesuai.</p>
                <a href="{{ route('customer.contractors.index') }}" class="inline-block mt-4 text-orange-500 font-medium hover:underline">
                    Cari Kontraktor Sekarang
                </a>
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $projects->links() }}
    </div>
</div>