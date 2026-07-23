<?php

namespace App\Livewire\Contractor;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Project;
use App\Models\ProjectWorker;

class WorkerManager extends Component
{
    use WithPagination;

    public Project $project;
    public $search = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

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
        $query = $this->project->workers();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('role', 'like', '%' . $this->search . '%');
            });
        }

        $workers = $query->paginate(10);

        return view('livewire.contractor.worker-manager', [
            'workers' => $workers
        ]);
    }
}
