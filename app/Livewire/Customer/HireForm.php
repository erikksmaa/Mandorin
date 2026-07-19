<?php

namespace App\Livewire\Customer;

use App\Models\ContractorProfile;
use App\Models\Project;
use App\Models\ProjectStatusHistory;
use App\Models\Notification;
use App\Enums\ProjectStatus;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Ajukan Proyek')]
class HireForm extends Component
{
    public ContractorProfile $contractorProfile;
    
    public $serviceId = '';
    public $title = '';
    public $description = '';
    public $address = '';

    public function mount(ContractorProfile $contractorProfile): void
    {
        $this->contractorProfile = $contractorProfile->load(['user', 'services']);
    }

    public function submit()
    {
        $this->validate([
            'serviceId' => 'required|exists:services,id',
            'title' => 'required|string|max:100',
            'description' => 'required|string',
            'address' => 'required|string',
        ]);

        if ($this->contractorProfile->verification_status !== \App\Enums\VerificationStatus::Verified) {
            session()->flash('error', 'Kontraktor ini belum terverifikasi atau tidak dapat menerima proyek saat ini.');
            return;
        }

        $project = Project::create([
            'customer_id' => auth()->id(),
            'contractor_id' => $this->contractorProfile->user_id,
            'service_id' => $this->serviceId,
            'title' => $this->title,
            'description' => $this->description,
            'address' => $this->address,
            'status' => 'pending',
            'requested_at' => now(),
        ]);

        ProjectStatusHistory::create([
            'project_id' => $project->id,
            'status' => 'pending',
            'changed_by' => auth()->id(),
        ]);

        Notification::create([
            'user_id' => $this->contractorProfile->user_id,
            'type' => 'project',
            'title' => 'Permintaan Proyek Baru',
            'message' => 'Anda mendapatkan permintaan proyek baru: ' . $this->title,
            'is_read' => false,
        ]);

        return redirect()->route('customer.projects.show', $project)
            ->with('success', 'Permintaan proyek berhasil diajukan.');
    }

    public function render()
    {
        return view('livewire.customer.hire-form', [
            'services' => $this->contractorProfile->services,
        ]);
    }
}
