<?php

namespace App\Livewire\Public;

use App\Models\ContractorProfile;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.guest-public')]
class ContractorShow extends Component
{
    public ContractorProfile $contractor;

    public function mount(ContractorProfile $contractor): void
    {
        // Guest boleh akses — tidak ada auth guard di sini.
        // Data dimuat dengan eager loading untuk menghindari N+1.
        $this->contractor = $contractor->load([
            'user',
            'services',
            'portfolios' => fn($q) => $q->latest()->take(6),
        ]);
    }

    public function hire(): void
    {
        if (! auth()->check()) {
            // Simpan intended URL lalu redirect ke login
            session()->put('url.intended', route('customer.hire.create', $this->contractor));
            $this->redirect(route('login'), navigate: true);
            return;
        }

        $this->redirect(route('customer.hire.create', $this->contractor), navigate: true);
    }

    public function render()
    {
        // Ambil kontraktor lain untuk bagian "Kontraktor Terkait"
        $related = ContractorProfile::with(['user', 'services'])
            ->where('verification_status', 'verified')
            ->where('id', '!=', $this->contractor->id)
            ->orderByDesc('rating')
            ->take(3)
            ->get();

        return view('livewire.public.contractor-show', compact('related'))
            ->title($this->contractor->user->name . ' — Profil Kontraktor | Mandorin');
    }
}
