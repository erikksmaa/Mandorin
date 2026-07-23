<?php

namespace App\Livewire\Public;

use App\Models\Portfolio;
use App\Models\Service;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;

#[Layout('layouts.guest-public')]
#[Title('Galeri Portfolio — Mandorin')]
class PortfolioIndex extends Component
{
    use WithPagination;

    #[Url(as: 'q')]
    public string $search = '';

    #[Url(as: 'layanan')]
    public ?int $serviceId = null;

    public function updatedSearch(): void { $this->resetPage(); }
    public function updatedServiceId(): void { $this->resetPage(); }

    public function render()
    {
        $portfolios = Portfolio::with(['contractorProfile.user', 'contractorProfile.services'])
            ->whereHas('contractorProfile', fn($q) => $q->where('verification_status', 'verified'))
            ->when($this->search, fn($q) => $q->where(function ($sub) {
                $sub->where('title', 'like', "%{$this->search}%")
                    ->orWhere('description', 'like', "%{$this->search}%")
                    ->orWhereHas('contractorProfile.user', fn($u) => $u->where('name', 'like', "%{$this->search}%"));
            }))
            ->when($this->serviceId, fn($q) => $q->whereHas(
                'contractorProfile.services', fn($s) => $s->where('services.id', $this->serviceId)
            ))
            ->latest()
            ->paginate(15);

        $services = Service::orderBy('name')->get();

        return view('livewire.public.portfolio-index', compact('portfolios', 'services'));
    }
}
