<?php

namespace App\Livewire\Public;

use App\Models\Program;
use App\Models\ProgramCategory;
use Livewire\Component;
use Livewire\WithPagination;

class ProgramIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $category = '';

    public function render()
    {
        $categories = ProgramCategory::all();

        $programs = Program::with('category', 'organization', 'leader')
            ->when($this->search, function ($q) {
                $q->where('title', 'like', "%{$this->search}%")
                  ->orWhere('description', 'like', "%{$this->search}%");
            })
            ->when($this->category, function ($q) {
                $q->where('category_id', $this->category);
            })
            ->latest()
            ->paginate(12);

        return view('livewire.public.program-index', compact('programs', 'categories'))
            ->layout('layouts.app');
    }
}
