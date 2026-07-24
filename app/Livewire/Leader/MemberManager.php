<?php

namespace App\Livewire\Leader;

use App\Enums\OrganizationPosition;
use App\Enums\MemberStatus;
use App\Models\Organization;
use App\Models\OrganizationMember;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class MemberManager extends Component
{
    use WithFileUploads, WithPagination;

    public Organization $organization;

    public $name = '';
    public $phone = '';
    public $position = 'Anggota';
    public $status = 'active';
    public $joined_at = '';
    public $avatar;

    public $editingMemberId = null;

    public $search = '';
    public $positionFilter = '';
    public $perPage = 10;

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['search', 'positionFilter', 'perPage'])) {
            $this->resetPage();
        }
    }

    public function mount()
    {
        $userId = auth()->id();
        $user = auth()->user();

        $org = Organization::where('created_by', $userId)->first();

        if (!$org) {
            $org = Organization::whereHas('programs', fn($q) => $q->where('leader_id', $userId))->first();
        }

        if (!$org) {
            $cat = \App\Models\OrganizationCategory::first();
            $org = Organization::create([
                'created_by' => $userId,
                'category_id' => $cat?->id ?? 1,
                'organization_code' => 'ORG-' . strtoupper(Str::random(6)),
                'name' => 'Organisasi ' . ($user->name ?? 'Leader'),
                'slug' => Str::slug('Organisasi ' . ($user->name ?? 'Leader') . '-' . rand(100, 999)),
                'email' => $user->email,
                'phone' => $user->phone,
                'status' => \App\Enums\OrganizationStatus::Active,
            ]);
        }

        $this->organization = Organization::with('members.user')->find($org->id);
        $this->joined_at = now()->format('Y-m-d');
    }

    public function editMember($id)
    {
        $member = OrganizationMember::with('user')->where('id', $id)->where('organization_id', $this->organization->id)->first();
        if ($member) {
            $this->editingMemberId = $member->id;
            $this->name = $member->user?->name ?? '';
            $this->phone = $member->user?->phone ?? '';
            $this->position = $member->position instanceof \BackedEnum ? $member->position->value : (string) $member->position;
            $this->status = $member->status instanceof \BackedEnum ? $member->status->value : (string) $member->status;
            $this->joined_at = $member->joined_at ? $member->joined_at->format('Y-m-d') : now()->format('Y-m-d');
        }
    }

    public function cancelEdit()
    {
        $this->editingMemberId = null;
        $this->reset(['name', 'phone', 'avatar']);
        $this->position = 'Anggota';
        $this->status = 'active';
        $this->joined_at = now()->format('Y-m-d');
    }

    public function addMember()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:30',
            'position' => 'required|string',
            'status' => 'required|string',
            'joined_at' => 'required|date',
            'avatar' => 'nullable|image|max:2048',
        ]);

        $trimName = trim($this->name);
        $trimPhone = trim($this->phone);

        $avatarPath = null;
        if ($this->avatar) {
            $avatarPath = $this->avatar->store('avatars', 'public');
        }

        $enumPos = OrganizationPosition::tryFrom($this->position) ?? OrganizationPosition::Anggota;
        $enumStatus = MemberStatus::tryFrom($this->status) ?? MemberStatus::Active;

        if ($this->editingMemberId) {
            $member = OrganizationMember::where('id', $this->editingMemberId)->where('organization_id', $this->organization->id)->first();
            if ($member && $member->user) {
                $userUpdates = ['name' => $trimName];
                if ($trimPhone) $userUpdates['phone'] = $trimPhone;
                if ($avatarPath) $userUpdates['avatar'] = $avatarPath;
                $member->user->update($userUpdates);

                $member->update([
                    'position' => $enumPos,
                    'status' => $enumStatus,
                    'joined_at' => $this->joined_at,
                ]);

                $this->dispatch('swal:success', message: 'Data anggota berhasil diperbarui!');
            }
            $this->cancelEdit();
        } else {
            $user = User::where('name', $trimName)->first();

            if (!$user) {
                $memberRoleId = Role::where('slug', 'member')->value('id') ?? Role::first()->id;
                $slugName = Str::slug($trimName);
                $email = ($slugName ?: 'member') . '_' . rand(100, 999) . '@sipora.id';

                $user = User::create([
                    'name' => $trimName,
                    'email' => $email,
                    'phone' => $trimPhone ?: null,
                    'password' => Hash::make('password'),
                    'role_id' => $memberRoleId,
                    'avatar' => $avatarPath,
                ]);
            } else {
                $updateData = [];
                if ($trimPhone) $updateData['phone'] = $trimPhone;
                if ($avatarPath) $updateData['avatar'] = $avatarPath;
                if (!empty($updateData)) $user->update($updateData);
            }

            OrganizationMember::firstOrCreate(
                [
                    'organization_id' => $this->organization->id,
                    'user_id' => $user->id,
                ],
                [
                    'position' => $enumPos,
                    'status' => $enumStatus,
                    'joined_at' => $this->joined_at,
                ]
            );

            $this->reset(['name', 'phone', 'avatar']);
            $this->position = 'Anggota';
            $this->status = 'active';
            $this->joined_at = now()->format('Y-m-d');
            
            $this->dispatch('swal:success', message: 'Anggota organisasi berhasil ditambahkan!');
        }

        $this->organization->load('members.user');
    }

    public function removeMember($id)
    {
        OrganizationMember::where('id', $id)->where('organization_id', $this->organization->id)->delete();
        $this->dispatch('swal:success', message: 'Anggota dihapus dari organisasi.');
        $this->organization->load('members.user');
    }

    public function render()
    {
        $members = OrganizationMember::with('user')
            ->where('organization_id', $this->organization->id)
            ->when($this->search, function ($q) {
                $q->whereHas('user', function ($u) {
                    $u->where('name', 'like', "%{$this->search}%")
                      ->orWhere('email', 'like', "%{$this->search}%")
                      ->orWhere('phone', 'like', "%{$this->search}%");
                });
            })
            ->when($this->positionFilter !== '', function ($q) {
                $q->where('position', $this->positionFilter);
            })
            ->latest()
            ->paginate((int) $this->perPage);

        return view('livewire.leader.member-manager', compact('members'))
            ->layout('layouts.app');
    }
}

