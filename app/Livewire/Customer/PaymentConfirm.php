<?php

namespace App\Livewire\Customer;

use App\Models\Project;
use App\Models\PaymentLog;
use App\Models\Notification;
use Livewire\Component;

class PaymentConfirm extends Component
{
    public Project $project;

    public function mount(Project $project)
    {
        $this->project = $project;
    }

    public function confirmPayment($paymentLogId)
    {
        $log = PaymentLog::findOrFail($paymentLogId);
        
        if ($log->project_id !== $this->project->id) abort(403);

        $log->update(['status' => 'confirmed']);

        Notification::create([
            'user_id' => $this->project->contractor_id,
            'type' => 'payment',
            'title' => 'Pembayaran Dikonfirmasi',
            'message' => 'Pembayaran termin ' . $log->payment_number . ' untuk proyek ' . $this->project->title . ' telah dikonfirmasi.',
            'is_read' => false,
        ]);

        $this->project->refresh();
        $this->dispatch('swal-success', title: 'Pembayaran Dikonfirmasi!', text: 'Status pembayaran berhasil diperbarui.');
    }

    public function rejectPayment($paymentLogId)
    {
        $log = PaymentLog::findOrFail($paymentLogId);
        
        if ($log->project_id !== $this->project->id) abort(403);

        $log->update(['status' => 'rejected']);

        Notification::create([
            'user_id' => $this->project->contractor_id,
            'type' => 'payment',
            'title' => 'Pembayaran Ditolak',
            'message' => 'Pembayaran termin ' . $log->payment_number . ' untuk proyek ' . $this->project->title . ' ditolak. Harap cek kembali.',
            'is_read' => false,
        ]);

        $this->project->refresh();
        $this->dispatch('swal-error', title: 'Pembayaran Ditolak', text: 'Bukti pembayaran ditolak. Kontraktor akan diberitahu.');
    }

    public function render()
    {
        $paymentLogs = $this->project->paymentLogs()->orderBy('payment_number')->get();
        $totalConfirmed = $paymentLogs->where('status', 'confirmed')->sum('amount');
        
        return view('livewire.customer.payment-confirm', [
            'paymentLogs' => $paymentLogs,
            'totalConfirmed' => $totalConfirmed,
        ]);
    }
}
