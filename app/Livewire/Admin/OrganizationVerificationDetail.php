<?php

namespace App\Livewire\Admin;

use App\Enums\OrganizationStatus;
use App\Models\Organization;
use Livewire\Component;

class OrganizationVerificationDetail extends Component
{
    public Organization $organization;

    public function mount($organization)
    {
        $id = $organization instanceof Organization ? $organization->id : $organization;
        $this->organization = Organization::with('category', 'creator', 'members.user')->findOrFail($id);
    }

    public function approve()
    {
        $this->organization->update(['status' => OrganizationStatus::Active]);
        $this->dispatch('swal:success', message: 'Organisasi berhasil diverifikasi dan diaktifkan!');
    }

    public function reject()
    {
        $this->organization->update(['status' => OrganizationStatus::Inactive]);
        $this->dispatch('swal:success', message: 'Organisasi ditolak / dinonaktifkan.');
    }

    public function render()
    {
        return view('livewire.admin.organization-verification-detail')
            ->layout('layouts.app');
    }
}
