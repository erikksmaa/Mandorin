<?php

namespace App\Livewire\Admin;

use App\Models\OrganizationCategory;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class OrganizationCategoryManagement extends Component
{
    use WithPagination;

    public $name = '';
    public $description = '';
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
        $this->editingCategoryId = null;
    }

    public function edit($id)
    {
        $category = OrganizationCategory::findOrFail($id);
        $this->editingCategoryId = $category->id;
        $this->name = $category->name;
        $this->description = $category->description;
        $this->isModalOpen = true;
    }

    public function save()
    {
        $this->validate();

        OrganizationCategory::updateOrCreate(
            ['id' => $this->editingCategoryId],
            [
                'name' => $this->name,
                'slug' => Str::slug($this->name),
                'description' => $this->description,
            ]
        );

        $this->closeModal();
        $this->dispatch('swal:success', message: 'Kategori organisasi berhasil disimpan!');
    }

    public function delete($id)
    {
        OrganizationCategory::findOrFail($id)->delete();
        $this->dispatch('swal:success', message: 'Kategori organisasi berhasil dihapus!');
    }

    public function render()
    {
        $categories = OrganizationCategory::withCount('organizations')
            ->when($this->search, function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                  ->orWhere('description', 'like', "%{$this->search}%");
            })
            ->latest()
            ->paginate((int) $this->perPage);

        return view('livewire.admin.organization-category-management', compact('categories'))
            ->layout('layouts.app');
    }
}
