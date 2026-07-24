<?php

namespace App\Livewire\Admin;

use App\Models\Role;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UserManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $filterRole = '';
    public $perPage = 10;

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['search', 'filterRole', 'perPage'])) {
            $this->resetPage();
        }
    }

    public function deleteUser($userId)
    {
        $user = User::findOrFail($userId);

        if ($user->id === auth()->id()) {
            $this->dispatch('swal:error', message: 'Anda tidak dapat menghapus akun Anda sendiri!');
            return;
        }

        $user->delete();
        $this->dispatch('swal:success', message: 'Pengguna berhasil dihapus!');
    }

    public function render()
    {
        $roles = Role::all();

        $users = User::with('role')
            ->when($this->search, function ($q) {
                $q->where(function ($sub) {
                    $sub->where('name', 'like', "%{$this->search}%")
                        ->orWhere('email', 'like', "%{$this->search}%")
                        ->orWhere('phone', 'like', "%{$this->search}%");
                });
            })
            ->when($this->filterRole !== '', function ($q) {
                $q->whereHas('role', function ($r) {
                    $r->where('slug', $this->filterRole);
                });
            })
            ->latest()
            ->paginate((int) $this->perPage);

        return view('livewire.admin.user-management', compact('users', 'roles'))
            ->layout('layouts.app');
    }
}
