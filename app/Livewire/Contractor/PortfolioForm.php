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
        $this->validate([
            'title' => 'required|string|max:100',
            'description' => 'nullable|string',
            'beforePhoto' => 'nullable|image|max:4096',
            'afterPhoto' => 'nullable|image|max:4096',
        ]);

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

        session()->flash('success', $msg);
        return redirect()->route('contractor.profile.show');
    }

    public function deletePortfolio()
    {
        if ($this->isEditing) {
            $this->portfolio->delete();
            session()->flash('success', 'Portfolio berhasil dihapus.');
            return redirect()->route('contractor.profile.show');
        }
    }

    public function render()
    {
        return view('livewire.contractor.portfolio-form');
    }
}
