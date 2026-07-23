<?php

namespace App\Livewire\Public;

use App\Models\ContractorProfile;
use App\Models\Portfolio;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;

#[Layout('layouts.guest-public')]
#[Title('Hasil Pencarian — Mandorin')]
class SearchResults extends Component
{
    #[Url(as: 'q')]
    public string $query = '';

    #[Url(as: 'tipe')]
    public string $type = 'all'; // all | contractors | portfolios

    public function updatedQuery(): void {}
    public function updatedType(): void {}

    public function render()
    {
        $contractors = collect();
        $portfolios  = collect();

        if ($this->query) {
            if (in_array($this->type, ['all', 'contractors'])) {
                $contractors = ContractorProfile::with(['user', 'services'])
                    ->where('verification_status', 'verified')
                    ->where(function ($q) {
                        $q->whereHas('user', fn($u) => $u->where('name', 'like', "%{$this->query}%"))
                          ->orWhere('address', 'like', "%{$this->query}%")
                          ->orWhere('bio', 'like', "%{$this->query}%")
                          ->orWhereHas('services', fn($s) => $s->where('name', 'like', "%{$this->query}%"));
                    })
                    ->orderByDesc('rating')
                    ->take(8)
                    ->get();
            }

            if (in_array($this->type, ['all', 'portfolios'])) {
                $portfolios = Portfolio::with(['contractorProfile.user'])
                    ->whereHas('contractorProfile', fn($q) => $q->where('verification_status', 'verified'))
                    ->where(function ($q) {
                        $q->where('title', 'like', "%{$this->query}%")
                          ->orWhere('description', 'like', "%{$this->query}%")
                          ->orWhereHas('contractorProfile.user', fn($u) => $u->where('name', 'like', "%{$this->query}%"))
                          ->orWhereHas('contractorProfile.services', fn($s) => $s->where('name', 'like', "%{$this->query}%"));
                    })
                    ->latest()
                    ->take(9)
                    ->get();
            }
        }

        return view('livewire.public.search-results', compact('contractors', 'portfolios'));
    }
}
