<?php

namespace App\Livewire\Contractor;

use App\Models\Portfolio;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Form Portfolio')]
class PortfolioForm extends Component
{
    use WithFileUploads;

    public ?Portfolio $portfolio = null;
    public $title;
    public $description;
    public $beforePhoto;
    public $afterPhoto;
    public $isEditing = false;

    public function mount(?Portfolio $portfolio = null)
    {
        if ($portfolio && $portfolio->exists) {
            $this->portfolio = $portfolio;
            $this->title = $portfolio->title;
            $this->description = $portfolio->description;
            $this->isEditing = true;
            
            // verify ownership
            if ($portfolio->contractor_profile_id !== auth()->user()->contractorProfile->id) {
                abort(403);
            }
        }
    }

    public function save()
    {
        $this->validate(
            [
                'title'       => 'required|string|min:5|max:100',
                'description' => 'nullable|string|max:500',
                'beforePhoto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
                'afterPhoto'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            ],
            [
                'title.required' => 'Judul portofolio wajib diisi.',
                'title.min'      => 'Judul portofolio minimal 5 karakter.',
                'title.max'      => 'Judul portofolio maksimal 100 karakter.',
                'beforePhoto.image' => 'File foto sebelum harus berupa gambar.',
                'beforePhoto.max'   => 'Ukuran foto sebelum maksimal 4MB.',
                'afterPhoto.image'  => 'File foto sesudah harus berupa gambar.',
                'afterPhoto.max'    => 'Ukuran foto sesudah maksimal 4MB.',
            ]
        );

        $data = [
            'title' => $this->title,
            'description' => $this->description,
        ];

        if ($this->beforePhoto) {
            $data['before_photo'] = $this->beforePhoto->store('portfolio', 'public');
        }

        if ($this->afterPhoto) {
            $data['after_photo'] = $this->afterPhoto->store('portfolio', 'public');
        }

        if ($this->isEditing) {
            $this->portfolio->update($data);
            $msg = 'Portfolio berhasil diperbarui.';
        } else {
            $data['contractor_profile_id'] = auth()->user()->contractorProfile->id;
            Portfolio::create($data);
            $msg = 'Portfolio baru berhasil ditambahkan.';
        }

        $this->dispatch('swal-success', title: 'Portofolio Disimpan!', text: $msg);
        return redirect()->route('contractor.profile.show');
    }

    public function deletePortfolio()
    {
        if ($this->isEditing) {
            $this->portfolio->delete();
            $this->dispatch('swal-success', title: 'Portofolio Dihapus!', text: 'Portofolio berhasil dihapus.');
            return redirect()->route('contractor.profile.show');
        }
    }

    public function render()
    {
        return view('livewire.contractor.portfolio-form');
    }
}
