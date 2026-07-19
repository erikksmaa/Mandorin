<?php

namespace App\Livewire\Contractor;

use Livewire\Component;
use App\Models\Project;
use App\Models\ProjectWorker;

class WorkerManager extends Component
{
    public Project $project;

    public function mount(Project $project): void
    {
        $this->project = $project;
    }

    public function deleteWorker(int $workerId)
    {
        ProjectWorker::where('id', $workerId)
            ->where('project_id', $this->project->id)
            ->delete();
    }

    public function render()
    {
        $workers = $this->project->workers()->get();
        return view('livewire.contractor.worker-manager', [
            'workers' => $workers
        ]);
    }
}
