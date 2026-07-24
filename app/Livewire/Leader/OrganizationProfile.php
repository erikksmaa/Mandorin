<?php

namespace App\Livewire\Leader;

use App\Models\Organization;
use App\Models\OrganizationCategory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class OrganizationProfile extends Component
{
    use WithFileUploads;

    public $organization;
    public $name = '';
    public $category_id = '';
    public $description = '';
    public $address = '';
    public $phone = '';
    public $email = '';
    public $website = '';
    public $established_at = '';
    
    public $logo;
    public $existing_logo;
    
    public $legal_docs = [];
    public $existing_docs = [];

    public function mount()
    {
        $this->organization = Organization::where('created_by', auth()->id())->first();

        if ($this->organization) {
            $this->name = $this->organization->name;
            $this->category_id = $this->organization->category_id;
            $this->description = $this->organization->description;
            $this->address = $this->organization->address;
            $this->phone = $this->organization->phone;
            $this->email = $this->organization->email;
            $this->website = $this->organization->website;
            $this->established_at = $this->organization->established_at ? $this->organization->established_at->format('Y-m-d') : '';
            $this->existing_logo = $this->organization->logo;
            
            $this->loadExistingDocs();
        }
    }

    public function loadExistingDocs()
    {
        if ($this->organization) {
            $path = 'organizations/' . $this->organization->id . '/documents';
            if (Storage::disk('public')->exists($path)) {
                $this->existing_docs = Storage::disk('public')->files($path);
            }
        }
    }

    public function deleteDocument($file)
    {
        if (Storage::disk('public')->exists($file)) {
            Storage::disk('public')->delete($file);
            $this->loadExistingDocs();
            $this->dispatch('swal:success', message: 'Dokumen berhasil dihapus.');
        }
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:150',
            'category_id' => 'required|exists:organization_categories,id',
            'description' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'logo' => 'nullable|image|max:2048',
            'legal_docs.*' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:5120',
        ]);

        $logoPath = $this->existing_logo;
        if ($this->logo) {
            $logoPath = $this->logo->store('organizations/logos', 'public');
        }

        $org = Organization::updateOrCreate(
            ['created_by' => auth()->id()],
            [
                'category_id' => $this->category_id,
                'name' => $this->name,
                'slug' => Str::slug($this->name),
                'description' => $this->description,
                'address' => $this->address,
                'phone' => $this->phone,
                'email' => $this->email,
                'website' => $this->website,
                'established_at' => $this->established_at ?: null,
                'logo' => $logoPath,
                'organization_code' => $this->organization ? $this->organization->organization_code : 'ORG-' . strtoupper(Str::random(6)),
            ]
        );

        // Upload Legal Docs
        if (!empty($this->legal_docs)) {
            foreach ($this->legal_docs as $doc) {
                $doc->store('organizations/' . $org->id . '/documents', 'public');
            }
        }

        $this->organization = $org;
        $this->existing_logo = $logoPath;
        $this->logo = null;
        $this->legal_docs = [];
        $this->loadExistingDocs();

        $this->dispatch('swal:success', message: 'Profil Organisasi berhasil disimpan!');
    }

    public function render()
    {
        $categories = OrganizationCategory::all();

        return view('livewire.leader.organization-profile', compact('categories'))
            ->layout('layouts.app');
    }
}
