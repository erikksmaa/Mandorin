<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Models\ContractorProfile;
use App\Models\Notification;
use App\Enums\VerificationStatus;

#[Layout('layouts.app')]
#[Title('Detail Verifikasi')]
class VerificationDetail extends Component
{
    public ContractorProfile $contractorProfile;

    public function mount(ContractorProfile $contractorProfile): void
    {
        $this->contractorProfile = $contractorProfile->load(['user', 'services']);
    }

    public function approve()
    {
        $this->contractorProfile->update([
            'verification_status' => 'verified'
        ]);

        Notification::create([
            'user_id' => $this->contractorProfile->user_id,
            'type' => 'verification',
            'title' => 'Verifikasi Disetujui',
            'message' => 'Selamat! Profil kontraktor Anda telah diverifikasi oleh Admin. Anda sekarang dapat menerima proyek.',
            'is_read' => false,
        ]);

        session()->flash('status', 'Kontraktor berhasil diverifikasi.');
        return redirect()->route('admin.verification.index');
    }

    public function reject()
    {
        $this->contractorProfile->update([
            'verification_status' => 'rejected'
        ]);

        Notification::create([
            'user_id' => $this->contractorProfile->user_id,
            'type' => 'verification',
            'title' => 'Verifikasi Ditolak',
            'message' => 'Mohon maaf, profil kontraktor Anda tidak dapat diverifikasi saat ini. Silakan periksa kembali dokumen Anda.',
            'is_read' => false,
        ]);

        session()->flash('status', 'Kontraktor ditolak.');
        return redirect()->route('admin.verification.index');
    }

    public function render()
    {
        return view('livewire.admin.verification-detail');
    }
}
