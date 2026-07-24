<?php

namespace App\Livewire\Admin;

use App\Models\ProgramCategory;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class ProgramCategoryManagement extends Component
{
    use WithPagination;

    public $name = '';
    public $description = '';
    public $icon = 'heroicon-o-academic-cap';
    public $editingCategoryId = null;
    public $isModalOpen = false;

    public $search = '';
    public $perPage = 10;

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['search', 'perPage'])) {
            $this->resetPage();
        }
    }

    protected $rules = [
        'name' => 'required|string|max:100',
        'description' => 'nullable|string|max:255',
        'icon' => 'nullable|string|max:50',
    ];

    public function openModal()
    {
        $this->resetInput();
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetInput();
    }

    public function resetInput()
    {
        $this->name = '';
        $this->description = '';
        $this->icon = 'heroicon-o-academic-cap';
        $this->editingCategoryId = null;
    }

    public function edit($id)
    {
        $category = ProgramCategory::findOrFail($id);
        $this->editingCategoryId = $category->id;
        $this->name = $category->name;
        $this->description = $category->description;
        $this->icon = $category->icon;
        $this->isModalOpen = true;
    }

    public function save()
    {
        $this->validate();

        ProgramCategory::updateOrCreate(
            ['id' => $this->editingCategoryId],
            [
                'name' => $this->name,
                'slug' => Str::slug($this->name),
                'description' => $this->description,
                'icon' => $this->icon,
            ]
        );

        $this->closeModal();
        $this->dispatch('swal:success', message: 'Kategori program berhasil disimpan!');
    }

    public function delete($id)
    {
        ProgramCategory::findOrFail($id)->delete();
        $this->dispatch('swal:success', message: 'Kategori program berhasil dihapus!');
    }

    public function render()
    {
        $categories = ProgramCategory::withCount('programs')
            ->when($this->search, function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                  ->orWhere('description', 'like', "%{$this->search}%");
            })
            ->latest()
            ->paginate((int) $this->perPage);

        return view('livewire.admin.program-category-management', compact('categories'))
            ->layout('layouts.app');
    }
}
