<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Models\ContractorProfile;
use App\Enums\VerificationStatus;

#[Layout('layouts.app')]
#[Title('Antrian Verifikasi')]
class VerificationQueue extends Component
{
    use WithPagination;

    public $search = '';
    public $filterStatus = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedFilterStatus()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = ContractorProfile::with(['user', 'services']);

        if ($this->search) {
            $query->whereHas('user', function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filterStatus) {
            $query->where('verification_status', $this->filterStatus);
        }

        $contractors = $query->latest()->paginate(12);

        return view('livewire.admin.verification-queue', [
            'contractors' => $contractors
        ]);
    }
}
