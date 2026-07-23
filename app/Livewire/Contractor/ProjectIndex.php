<?php

namespace App\Livewire\Contractor;

use App\Models\Project;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Kelola Proyek')]
class ProjectIndex extends Component
{
    use WithPagination;

    public $filterStatus = '';
    public $search = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function setFilterStatus($status)
    {
        $this->filterStatus = $status;
        $this->resetPage();
    }

    public function render()
    {
        $query = Project::where('contractor_id', auth()->id())
            ->with(['customer', 'service'])
            ->orderBy('created_at', 'desc');

        if (!empty($this->filterStatus)) {
            $query->where('status', $this->filterStatus);
        }

        if (!empty($this->search)) {
            $query->where('title', 'like', '%' . $this->search . '%');
        }

        $projects = $query->paginate(10);

        return view('livewire.contractor.project-index', [
            'projects' => $projects,
        ]);
    }
}
