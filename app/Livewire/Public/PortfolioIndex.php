<?php

namespace App\Livewire\Public;

use App\Models\ActivityPhoto;
use Livewire\Component;
use Livewire\WithPagination;

class PortfolioIndex extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        $photos = ActivityPhoto::with(['activityLog.program.organization'])
            ->whereHas('activityLog.program', function ($q) {
                // Only show photos from Approved, Running, or Completed programs
                $q->whereIn('status', ['Approved', 'Running', 'Completed']);
            })
            ->when($this->search, function ($q) {
                $q->whereHas('activityLog.program', function ($query) {
                    $query->where('title', 'like', "%{$this->search}%");
                });
            })
            ->latest()
            ->paginate(16);

        return view('livewire.public.portfolio-index', compact('photos'))
            ->layout('layouts.app');
    }
}
