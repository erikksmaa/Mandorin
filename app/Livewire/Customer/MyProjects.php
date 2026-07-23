<?php

namespace App\Livewire\Customer;

use App\Models\Project;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Proyek Saya')]
class MyProjects extends Component
{
    use WithPagination;

    public $filterStatus = '';
    public $search = '';

    public function updatedSearch()
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
        $query = auth()->user()->customerProjects()
            ->with(['contractor', 'service'])
            ->orderBy('created_at', 'desc');

        if (!empty($this->filterStatus)) {
            $query->where('status', $this->filterStatus);
        }

        if (!empty($this->search)) {
            $query->where('title', 'like', '%' . $this->search . '%');
        }

        $projects = $query->paginate(10);

        return view('livewire.customer.my-projects', [
            'projects' => $projects,
        ]);
    }
}
