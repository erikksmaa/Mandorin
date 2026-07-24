<?php

namespace App\Livewire\Leader;

use App\Models\Organization;
use App\Models\Program;
use App\Enums\ProgramStatus;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $user = auth()->user();

        $organization = Organization::where('created_by', $user->id)->first();

        $myProgramsCount      = Program::where('leader_id', $user->id)->count();
        $activeProgramsCount  = Program::where('leader_id', $user->id)->where('status', ProgramStatus::Running)->count();
        $approvedProgramsCount = Program::where('leader_id', $user->id)->where('status', ProgramStatus::Approved)->count();
        $completedProgramsCount = Program::where('leader_id', $user->id)->where('status', ProgramStatus::Completed)->count();

        $recentPrograms = Program::with('category', 'organization')
            ->where('leader_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('livewire.leader.dashboard', compact(
            'organization',
            'myProgramsCount',
            'activeProgramsCount',
            'approvedProgramsCount',
            'completedProgramsCount',
            'recentPrograms'
        ))->layout('layouts.app');
    }
}
