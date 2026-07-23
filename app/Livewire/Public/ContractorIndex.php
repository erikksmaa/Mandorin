<?php

namespace App\Livewire\Public;

use App\Models\ContractorProfile;
use App\Models\Service;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;

#[Layout('layouts.guest-public')]
#[Title('Cari Kontraktor — Mandorin')]
class ContractorIndex extends Component
{
    use WithPagination;

    #[Url(as: 'q')]
    public string $search = '';

    #[Url(as: 'lokasi')]
    public string $location = '';

    #[Url(as: 'layanan')]
    public ?int $serviceId = null;

    #[Url(as: 'rating')]
    public string $minRating = '';

    public function updatedSearch(): void { $this->resetPage(); }
    public function updatedLocation(): void { $this->resetPage(); }
    public function updatedServiceId(): void { $this->resetPage(); }
    public function updatedMinRating(): void { $this->resetPage(); }

    public function render()
    {
        $contractors = ContractorProfile::with(['user', 'services'])
            ->where('verification_status', 'verified')
            ->when($this->search, function ($q) {
                $q->whereHas('user', fn($u) => $u->where('name', 'like', "%{$this->search}%"));
            })
            ->when($this->location, fn($q) => $q->where('address', 'like', "%{$this->location}%"))
            ->when($this->serviceId, fn($q) => $q->whereHas('services', fn($s) => $s->where('services.id', $this->serviceId)))
            ->when($this->minRating !== '', fn($q) => $q->where('rating', '>=', (float) $this->minRating))
            ->orderByDesc('rating')
            ->paginate(12);

        $services = Service::orderBy('name')->get();

        return view('livewire.public.contractor-index', compact('contractors', 'services'));
    }
}
