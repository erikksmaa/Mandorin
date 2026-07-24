<?php

namespace App\Livewire\Admin;

use App\Models\Service;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Kelola Kategori Program')]
class ServiceManagement extends Component
{
    use WithPagination;

    public string $search = '';
    public bool $isModalOpen = false;

    public ?int $serviceId = null;
    public string $name = '';
    public string $description = '';
    public string $icon = '';

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'icon' => 'nullable|string|max:100',
        ];
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function createService(): void
    {
        $this->resetForm();
        $this->isModalOpen = true;
    }

    public function editService(int $id): void
    {
        $service = Service::findOrFail($id);
        $this->serviceId = $service->id;
        $this->name = $service->name;
        $this->description = $service->description ?? '';
        $this->icon = $service->icon ?? '';
        $this->isModalOpen = true;
    }

    public function saveService(): void
    {
        $this->validate();

        if ($this->serviceId) {
            $service = Service::findOrFail($this->serviceId);
            $service->update([
                'name' => $this->name,
                'description' => $this->description,
                'icon' => $this->icon,
            ]);
            $this->dispatch('swal-success', [['title' => 'Berhasil!', 'text' => 'Layanan berhasil diperbarui.']]);
        } else {
            Service::create([
                'name' => $this->name,
                'description' => $this->description,
                'icon' => $this->icon,
            ]);
            $this->dispatch('swal-success', [['title' => 'Berhasil!', 'text' => 'Layanan baru berhasil ditambahkan.']]);
        }

        $this->closeModal();
    }

    public function deleteService(int $id): void
    {
        $service = Service::findOrFail($id);
        $service->delete();

        $this->dispatch('swal-success', [['title' => 'Berhasil!', 'text' => 'Layanan berhasil dihapus.']]);
    }

    public function closeModal(): void
    {
        $this->isModalOpen = false;
        $this->resetForm();
    }

    private function resetForm(): void
    {
        $this->serviceId = null;
        $this->name = '';
        $this->description = '';
        $this->icon = '';
        $this->resetValidation();
    }

    public function render()
    {
        $services = Service::query()
            ->when($this->search, function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->orderBy('name')
            ->paginate(10);

        return view('livewire.admin.service-management', [
            'services' => $services,
        ]);
    }
}
