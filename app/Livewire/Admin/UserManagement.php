<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Models\User;

#[Layout('layouts.app')]
#[Title('Manajemen Pengguna')]
class UserManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $filterRole = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedFilterRole()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = User::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filterRole) {
            $query->where('role', $this->filterRole);
        }

        $users = $query->latest()->paginate(15);

        return view('livewire.admin.user-management', [
            'users' => $users
        ]);
    }
}
