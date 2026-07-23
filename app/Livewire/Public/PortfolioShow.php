<?php

namespace App\Livewire\Public;

use App\Models\Portfolio;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.guest-public')]
class PortfolioShow extends Component
{
    public Portfolio $portfolio;

    public function mount(Portfolio $portfolio): void
    {
        $this->portfolio = $portfolio->load([
            'contractorProfile.user',
            'contractorProfile.services',
        ]);
    }

    public function render()
    {
        // Portfolio terkait: milik kontraktor yang sama, beda item
        $related = Portfolio::with(['contractorProfile.user'])
            ->where('contractor_profile_id', $this->portfolio->contractor_profile_id)
            ->where('id', '!=', $this->portfolio->id)
            ->latest()
            ->take(4)
            ->get();

        return view('livewire.public.portfolio-show', compact('related'))
            ->title($this->portfolio->title . ' — Portfolio | Mandorin');
    }
}
