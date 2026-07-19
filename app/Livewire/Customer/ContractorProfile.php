<?php

namespace App\Livewire\Customer;

use App\Models\ContractorProfile as ContractorProfileModel;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Profil Kontraktor')]
class ContractorProfile extends Component
{
    public ContractorProfileModel $contractorProfile;

    public function mount(ContractorProfileModel $contractorProfile): void
    {
        $this->contractorProfile = $contractorProfile->load(['user', 'services', 'portfolios']);
    }

    public function render()
    {
        return view('livewire.customer.contractor-profile');
    }
}
