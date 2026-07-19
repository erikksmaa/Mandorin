<?php

namespace App\Livewire\Customer;

use App\Models\ContractorProfile;
use App\Models\Service;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Cari Kontraktor')]
class ContractorSearch extends Component
{
    use WithPagination;

    public $search = '';
    public $filterService = null;

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function setFilterService($serviceId)
    {
        $this->filterService = $serviceId;
        $this->resetPage();
    }

    public function render()
    {
        $services = Service::all();

        $query = ContractorProfile::where('verification_status', 'verified')
            ->with(['user', 'services']);

        if (!empty($this->search)) {
            $query->whereHas('user', function ($q) {
                $q->where('name', 'LIKE', '%' . $this->search . '%');
            });
        }

        if ($this->filterService) {
            $query->whereHas('services', function ($q) {
                $q->where('services.id', $this->filterService);
            });
        }

        $contractors = $query->paginate(9);

        return view('livewire.customer.contractor-search', [
            'services' => $services,
            'contractors' => $contractors,
        ]);
    }
}
