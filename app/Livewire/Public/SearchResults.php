<?php

namespace App\Livewire\Public;

use App\Models\Organization;
use App\Models\Program;
use Livewire\Component;

class SearchResults extends Component
{
    public $query = '';

    public function mount()
    {
        $this->query = request()->query('q', '');
    }

    public function render()
    {
        $organizations = Organization::with('category')
            ->where('status', \App\Enums\OrganizationStatus::Active)
            ->when($this->query, function ($q) {
                $q->where(function ($query) {
                    $query->where('name', 'like', "%{$this->query}%")
                          ->orWhere('description', 'like', "%{$this->query}%");
                });
            })
            ->take(6)
            ->get();

        $programs = Program::with('category', 'organization')
            ->where('title', 'like', "%{$this->query}%")
            ->orWhere('description', 'like', "%{$this->query}%")
            ->take(6)
            ->get();

        return view('livewire.public.search-results', compact('organizations', 'programs'))
            ->layout('layouts.app');
    }
}
