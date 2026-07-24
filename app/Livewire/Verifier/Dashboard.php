<?php

namespace App\Livewire\Verifier;

use App\Models\FinancialReport;
use App\Models\Program;
use App\Enums\ProgramStatus;
use App\Enums\ProposalStatus;
use App\Enums\FinancialStatus;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $pendingProposalsCount  = Program::where('proposal_status', ProposalStatus::Pending)->count();
        $activeProgramsCount    = Program::where('status', ProgramStatus::Running)->count();
        $pendingElpjCount       = FinancialReport::where('status', FinancialStatus::Submitted)->count();
        $completedProgramsCount = Program::where('status', ProgramStatus::Completed)->count();

        $recentProposals = Program::with('organization', 'category', 'leader')
            ->where('proposal_status', ProposalStatus::Pending)
            ->latest()
            ->take(5)
            ->get();

        $recentElpjs = FinancialReport::with('program.organization')
            ->where('status', FinancialStatus::Submitted)
            ->latest()
            ->take(5)
            ->get();

        return view('livewire.verifier.dashboard', compact(
            'pendingProposalsCount',
            'activeProgramsCount',
            'pendingElpjCount',
            'completedProgramsCount',
            'recentProposals',
            'recentElpjs'
        ))->layout('layouts.app');
    }
}
