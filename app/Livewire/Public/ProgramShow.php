<?php

namespace App\Livewire\Public;

use App\Models\Program;
use Livewire\Component;

class ProgramShow extends Component
{
    public Program $program;

    public function mount($program)
    {
        $id = $program instanceof Program ? $program->id : $program;
        $this->program = Program::with('organization', 'category', 'leader', 'activityLogs.photos', 'members.user')->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.public.program-show')
            ->layout('layouts.app');
    }
}
