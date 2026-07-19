<?php

namespace App\Livewire\Contractor;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Models\Project;
use App\Models\ProjectWorker;

#[Layout('layouts.app')]
#[Title('Form Pekerja')]
class WorkerForm extends Component
{
    public Project $project;
    public ?ProjectWorker $worker = null;
    
    public $name = '';
    public $phone = '';
    public $role = '';

    public function mount(Project $project, ?ProjectWorker $worker = null): void
    {
        $this->project = $project;
        
        if ($worker && $worker->exists) {
            $this->worker = $worker;
            $this->name = $worker->name;
            $this->phone = $worker->phone;
            $this->role = $worker->role;
        }
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:100',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|string|max:50',
        ]);

        if ($this->worker && $this->worker->exists) {
            $this->worker->update([
                'name' => $this->name,
                'phone' => $this->phone,
                'role' => $this->role,
            ]);
        } else {
            ProjectWorker::create([
                'project_id' => $this->project->id,
                'name' => $this->name,
                'phone' => $this->phone,
                'role' => $this->role,
            ]);
        }

        return redirect()->route('contractor.projects.show', $this->project);
    }

    public function render()
    {
        return view('livewire.contractor.worker-form');
    }
}
