<?php

namespace App\Livewire\Contractor;

use App\Models\ContractorProfile;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Profil Kontraktor')]
class Profile extends Component
{
    use WithFileUploads;

    public $bio;
    public $address;
    public $profilePhoto;
    public $identityDocument;
    public $certificateDocument;

    public function mount()
    {
        $user = auth()->user();
        $profile = $user->contractorProfile;

        if (!$profile) {
            $profile = ContractorProfile::create([
                'user_id' => $user->id,
            ]);
        }

        $this->bio = $profile->bio;
        $this->address = $profile->address;
    }

    public function save()
    {
        $this->validate([
            'bio' => 'nullable|string|max:500',
            'address' => 'required|string|max:255',
            'profilePhoto' => 'nullable|image|max:2048',
            'identityDocument' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:4096',
            'certificateDocument' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:4096',
        ]);

        $profile = auth()->user()->contractorProfile;
        
        $data = [
            'bio' => $this->bio,
            'address' => $this->address,
        ];

        if ($this->profilePhoto) {
            $data['profile_photo'] = $this->profilePhoto->store('profiles', 'public');
        }

        if ($this->identityDocument) {
            $data['identity_document'] = $this->identityDocument->store('documents', 'public');
            // reset verification if identity changes?
            // $data['verification_status'] = 'pending';
        }

        if ($this->certificateDocument) {
            $data['certificate_document'] = $this->certificateDocument->store('documents', 'public');
        }

        $profile->update($data);

        session()->flash('success', 'Profil berhasil diperbarui.');
    }

    public function render()
    {
        $user = auth()->user();
        $profile = $user->contractorProfile()->with('portfolios', 'services')->first();

        return view('livewire.contractor.profile', [
            'user' => $user,
            'profile' => $profile,
        ]);
    }
}
