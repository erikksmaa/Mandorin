<?php

namespace App\Livewire\Public;

use App\Models\ActivityPhoto;
use Livewire\Component;
use Livewire\WithPagination;

class PortfolioIndex extends Component
{
    use WithPagination;

    public $search = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $photos = ActivityPhoto::with(['activityLog.program.organization', 'activityLog.program.category'])
            ->whereHas('activityLog.program', function ($q) {
                $q->where('status', 'Completed');
            })
            ->when($this->search, function ($q) {
                $q->whereHas('activityLog.program', function ($query) {
                    $query->where('title', 'like', "%{$this->search}%");
                });
            })
            ->latest()
            ->paginate(8);

        return view('livewire.public.portfolio-index', compact('photos'))
            ->layout('layouts.app');
    }
}
