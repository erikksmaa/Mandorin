<?php

namespace App\Livewire\Leader;

use App\Models\Program;
use Livewire\Component;

class ProgramDetail extends Component
{
    public Program $program;

    public function mount($program)
    {
        $id = $program instanceof Program ? $program->id : $program;
        $this->program = Program::with('organization', 'category', 'activityLogs', 'members.user', 'financialReport')->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.leader.program-detail')
            ->layout('layouts.app');
    }
}
