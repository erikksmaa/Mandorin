<?php

namespace App\Livewire\Admin;

use App\Enums\OrganizationStatus;
use App\Models\Organization;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class OrganizationVerificationDetail extends Component
{
    public Organization $organization;
    public array $documents = [];

    public function mount($organization)
    {
        $id = $organization instanceof Organization ? $organization->id : $organization;
        $this->organization = Organization::with('category', 'creator', 'members.user')->findOrFail($id);
        $this->loadDocuments();
    }

    public function loadDocuments()
    {
        $path = 'organizations/' . $this->organization->id . '/documents';
        if (Storage::disk('public')->exists($path)) {
            $this->documents = Storage::disk('public')->files($path);
        } else {
            $this->documents = [];
        }
    }

    public function downloadDocument($filePath)
    {
        if (Storage::disk('public')->exists($filePath)) {
            return Storage::disk('public')->download($filePath);
        }

        $this->dispatch('swal:error', message: 'File dokumen tidak ditemukan.');
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
