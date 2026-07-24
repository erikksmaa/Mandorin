<?php

namespace App\Livewire\Public;

use App\Models\Organization;
use Livewire\Component;

class OrganizationShow extends Component
{
    public Organization $organization;

    public function mount($organization)
    {
        $id = $organization instanceof Organization ? $organization->id : $organization;
        $this->organization = Organization::with('category', 'creator', 'programs.category', 'members.user')->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.public.organization-show')
            ->layout('layouts.app');
    }
}
