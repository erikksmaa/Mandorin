<?php

namespace App\Livewire\Leader;

use App\Models\Program;
use Livewire\Component;
use Livewire\WithPagination;

class ProgramIndex extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        $programs = Program::with('category', 'organization')
            ->where('leader_id', auth()->id())
            ->when($this->search, function ($q) {
                $q->where('title', 'like', "%{$this->search}%");
            })
            ->latest()
            ->paginate(10);

        return view('livewire.leader.program-index', compact('programs'))
            ->layout('layouts.app');
    }
}
