<?php

namespace App\Livewire\Verifier;

use App\Enums\ProgramStatus;
use App\Enums\ProposalStatus;
use App\Models\Program;
use Livewire\Component;

class ProposalDetail extends Component
{
    public Program $program;
    public $notes = '';

    public function mount($program)
    {
        $id = $program instanceof Program ? $program->id : $program;
        $this->program = Program::with('organization', 'category', 'leader', 'members.user', 'creator')->findOrFail($id);
        $this->notes = $this->program->proposal_notes ?? '';
    }

    public function approve()
    {
        $this->program->update([
            'proposal_status' => ProposalStatus::Verified,
            'status' => ProgramStatus::Approved,
            'verified_by' => auth()->id(),
            'verified_at' => now(),
            'proposal_notes' => $this->notes,
        ]);

        $this->dispatch('swal:success', message: 'Proposal program berhasil disetujui!');
    }

    public function revision()
    {
        $this->validate(['notes' => 'required|string|min:5']);

        $this->program->update([
            'proposal_status' => ProposalStatus::Revision,
            'proposal_notes' => $this->notes,
        ]);

        $this->dispatch('swal:success', message: 'Catatan revisi proposal telah dikirimkan ke Ketua Pelaksana!');
    }

    public function reject()
    {
        $this->validate(['notes' => 'required|string|min:5']);

        $this->program->update([
            'proposal_status' => ProposalStatus::Rejected,
            'status' => ProgramStatus::Cancelled,
            'verified_by' => auth()->id(),
            'verified_at' => now(),
            'proposal_notes' => $this->notes,
        ]);

        $this->dispatch('swal:success', message: 'Proposal program ditolak.');
    }

    public function render()
    {
        return view('livewire.verifier.proposal-detail')
            ->layout('layouts.app');
    }
}
