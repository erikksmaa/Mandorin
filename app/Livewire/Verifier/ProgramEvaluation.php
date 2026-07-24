<?php

namespace App\Livewire\Verifier;

use App\Enums\ProgramStatus;
use App\Models\Program;
use Livewire\Component;

class ProgramEvaluation extends Component
{
    public Program $program;
    public $notes = '';

    public function mount($program)
    {
        $id = $program instanceof Program ? $program->id : $program;
        $this->program = Program::with('organization', 'category', 'leader', 'activityLogs', 'financialReport')->findOrFail($id);
    }

    public function completeProgram()
    {
        if (!$this->program->financialReport || $this->program->financialReport->status->value !== 'Approved') {
            $this->dispatch('swal:error', message: 'Program tidak dapat diselesaikan karena E-LPJ belum disetujui!');
            return;
        }

        $this->program->update([
            'status' => ProgramStatus::Completed,
            'completed_at' => now(),
        ]);

        $this->dispatch('swal:success', message: 'Program resmi dinyatakan selesai & dievaluasi!');
    }

    public function approveLogbook($logId)
    {
        $log = \App\Models\ActivityLog::find($logId);
        if ($log) {
            $log->update(['status' => \App\Enums\ActivityStatus::Approved]);
            $this->dispatch('swal:success', message: 'Logbook disetujui.');
            $this->program->load('activityLogs');
        }
    }

    public function reviseLogbook($logId, $notes)
    {
        $log = \App\Models\ActivityLog::find($logId);
        if ($log) {
            $log->update([
                'status' => \App\Enums\ActivityStatus::Revised,
                'verifier_notes' => $notes
            ]);
            $this->dispatch('swal:success', message: 'Logbook dikembalikan untuk revisi.');
            $this->program->load('activityLogs');
        }
    }

    public function render()
    {
        return view('livewire.verifier.program-evaluation')
            ->layout('layouts.app');
    }
}
