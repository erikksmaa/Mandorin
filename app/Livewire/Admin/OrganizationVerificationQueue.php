<?php

namespace App\Livewire\Admin;

use App\Models\Organization;
use Livewire\Component;
use Livewire\WithPagination;

class OrganizationVerificationQueue extends Component
{
    use WithPagination;

    public $search = '';
    public $filterStatus = '';
    public $perPage = 10;

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['search', 'filterStatus', 'perPage'])) {
            $this->resetPage();
        }
    }

    public function render()
    {
        $organizations = Organization::with('category', 'creator')
            ->when($this->search, function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                  ->orWhere('organization_code', 'like', "%{$this->search}%");
            })
            ->when($this->filterStatus !== '', function ($q) {
                $q->where('status', $this->filterStatus);
            })
            ->latest()
            ->paginate((int) $this->perPage);

        return view('livewire.admin.organization-verification-queue', compact('organizations'))
            ->layout('layouts.app');
    }
}
