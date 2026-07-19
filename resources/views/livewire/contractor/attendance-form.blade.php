<div class="bg-white border border-slate-200 shadow-sm rounded-2xl p-5 mb-6">
    <div class="flex justify-between items-center mb-5">
        <h2 class="text-xl font-bold text-slate-800" style="font-family: 'Big Shoulders Display', sans-serif;">
            Absensi Pekerja
        </h2>
        <div>
            <input type="date" wire:model.live="selectedDate" class="border-slate-300 rounded-lg text-sm focus:border-navy focus:ring focus:ring-navy focus:ring-opacity-50">
        </div>
    </div>

    @if (session()->has('attendance_success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg text-sm">
            {{ session('attendance_success') }}
        </div>
    @endif

    @if($project->workers->isEmpty())
        <div class="text-center py-8">
            <p class="text-slate-500">Belum ada pekerja di proyek ini.</p>
        </div>
    @else
        <div class="overflow-x-auto mb-4">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-slate-700">
                    <tr>
                        <th class="px-4 py-3 font-medium rounded-l-lg">Nama Pekerja</th>
                        <th class="px-4 py-3 font-medium">Peran</th>
                        <th class="px-4 py-3 font-medium rounded-r-lg text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($project->workers as $worker)
                        <tr class="border-b border-slate-100 last:border-0">
                            <td class="px-4 py-3">{{ $worker->name }}</td>
                            <td class="px-4 py-3">{{ $worker->role }}</td>
                            <td class="px-4 py-3">
                                <div class="flex justify-center gap-4">
                                    <label class="inline-flex items-center gap-1 cursor-pointer">
                                        <input type="radio" wire:model="attendances.{{ $worker->id }}" value="present" class="text-navy focus:ring-navy">
                                        <span class="text-xs">Hadir</span>
                                    </label>
                                    <label class="inline-flex items-center gap-1 cursor-pointer">
                                        <input type="radio" wire:model="attendances.{{ $worker->id }}" value="absent" class="text-navy focus:ring-navy">
                                        <span class="text-xs">Absen</span>
                                    </label>
                                    <label class="inline-flex items-center gap-1 cursor-pointer">
                                        <input type="radio" wire:model="attendances.{{ $worker->id }}" value="leave" class="text-navy focus:ring-navy">
                                        <span class="text-xs">Izin</span>
                                    </label>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="flex justify-end">
            <button wire:click="saveAttendances" class="px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-xl font-medium transition">
                Simpan Absensi
            </button>
        </div>
    @endif
</div>
