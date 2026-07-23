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
    public $estimatedFinishDate = '';

    public function mount(ContractorProfile $contractorProfile): void
    {
        $this->contractorProfile = $contractorProfile->load(['user', 'services']);
    }

    public function submit()
    {
        $this->validate(
            [
                'serviceId'           => 'required|exists:services,id',
                'title'               => 'required|string|min:5|max:100',
                'description'         => 'required|string|min:20',
                'address'             => 'required|string|min:10',
                'estimatedFinishDate' => 'nullable|date|after_or_equal:today',
            ],
            [
                'serviceId.required'        => 'Silakan pilih layanan yang diinginkan.',
                'serviceId.exists'          => 'Layanan tidak valid.',
                'title.required'            => 'Judul proyek wajib diisi.',
                'title.min'                 => 'Judul proyek minimal 5 karakter.',
                'title.max'                 => 'Judul proyek maksimal 100 karakter.',
                'description.required'      => 'Deskripsi proyek wajib diisi.',
                'description.min'           => 'Deskripsi proyek minimal 20 karakter agar mudah dipahami mandor.',
                'address.required'          => 'Alamat proyek wajib diisi.',
                'address.min'               => 'Mohon isi alamat proyek lebih lengkap (minimal 10 karakter).',
                'estimatedFinishDate.date'  => 'Format tanggal target selesai tidak valid.',
                'estimatedFinishDate.after_or_equal' => 'Target selesai harus hari ini atau tanggal setelahnya.',
            ]
        );

        if ($this->contractorProfile->verification_status !== \App\Enums\VerificationStatus::Verified) {
            $this->dispatch('swal-error', title: 'Kontraktor Belum Terverifikasi!', text: 'Kontraktor ini belum diverifikasi dan tidak dapat menerima proyek saat ini.');
            return;
        }

        $project = Project::create([
            'customer_id' => auth()->id(),
            'contractor_id' => $this->contractorProfile->user_id,
            'service_id' => $this->serviceId,
            'title' => $this->title,
            'description' => $this->description,
            'address' => $this->address,
            'estimated_finish_date' => $this->estimatedFinishDate ?: null,
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
