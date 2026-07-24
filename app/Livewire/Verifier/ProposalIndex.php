<?php

namespace App\Livewire\Verifier;

use App\Models\Program;
use Livewire\Component;
use Livewire\WithPagination;

class ProposalIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = 'all';
    public $categoryFilter = '';
    public $yearFilter = '';
    public $perPage = 10;

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['search', 'statusFilter', 'categoryFilter', 'yearFilter', 'perPage'])) {
            $this->resetPage();
        }
    }

    public function render()
    {
        $categories = \App\Models\ProgramCategory::all();

        $proposals = Program::with('organization', 'category', 'leader')
            ->when($this->search, function ($q) {
                $q->where(function ($sub) {
                    $sub->where('title', 'like', "%{$this->search}%")
                        ->orWhere('program_code', 'like', "%{$this->search}%")
                        ->orWhereHas('organization', fn($org) => $org->where('name', 'like', "%{$this->search}%"))
                        ->orWhereHas('category', fn($cat) => $cat->where('name', 'like', "%{$this->search}%"))
                        ->orWhereHas('leader', fn($ldr) => $ldr->where('name', 'like', "%{$this->search}%"));
                });
            })
            ->when($this->statusFilter !== 'all', function ($q) {
                $q->where('proposal_status', $this->statusFilter);
            })
            ->when($this->categoryFilter !== '', function ($q) {
                $q->where('category_id', $this->categoryFilter);
            })
            ->when($this->yearFilter !== '', function ($q) {
                $q->whereYear('created_at', $this->yearFilter);
            })
            ->latest()
            ->paginate((int) $this->perPage);

        return view('livewire.verifier.proposal-index', compact('proposals', 'categories'))
            ->layout('layouts.app');
    }
}
