<?php

namespace App\Livewire\Public;

use App\Models\Organization;
use App\Models\OrganizationCategory;
use Livewire\Component;
use Livewire\WithPagination;

class OrganizationIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $category = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $categories = OrganizationCategory::all();

        $organizations = Organization::with('category', 'creator')
            ->where('status', 'active')
            ->when($this->search, function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                  ->orWhere('description', 'like', "%{$this->search}%");
            })
            ->when($this->category, function ($q) {
                $q->where('category_id', $this->category);
            })
            ->latest()
            ->paginate(12);

        return view('livewire.public.organization-index', compact('organizations', 'categories'))
            ->layout('layouts.app');
    }
}
