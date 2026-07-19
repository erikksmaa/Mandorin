<?php

namespace App\Livewire\Contractor;

use App\Models\Project;
use App\Models\PaymentLog;
use App\Models\Notification;
use App\Enums\PaymentStatus;
use Livewire\Component;
use Livewire\WithFileUploads;

class PaymentLogForm extends Component
{
    use WithFileUploads;

    public Project $project;
    public $amount;
    public $paymentDate;
    public $receipt;
    public $showForm = false;

    public function mount(Project $project)
    {
        $this->project = $project;
        $this->paymentDate = date('Y-m-d');
    }

    public function toggleForm()
    {
        $this->showForm = !$this->showForm;
    }

    public function addPayment()
    {
        $this->validate([
            'amount' => 'required|numeric|min:0',
            'paymentDate' => 'required|date',
            'receipt' => 'nullable|file|max:4096|mimes:jpg,jpeg,png,pdf',
        ]);

        $receiptPath = $this->receipt ? $this->receipt->store('payments', 'public') : null;
        $paymentCount = $this->project->paymentLogs()->count();

        PaymentLog::create([
            'project_id' => $this->project->id,
            'payment_number' => $paymentCount + 1,
            'amount' => $this->amount,
            'payment_date' => $this->paymentDate,
            'receipt' => $receiptPath,
            'status' => PaymentStatus::Pending,
        ]);

        Notification::create([
            'user_id' => $this->project->customer_id,
            'title' => 'Log Pembayaran Baru',
            'message' => 'Kontraktor telah menambahkan log pembayaran untuk proyek ' . $this->project->title,
            'type' => 'payment',
            'is_read' => false,
        ]);

        $this->reset(['amount', 'receipt']);
        $this->paymentDate = date('Y-m-d');
        $this->showForm = false;
        
        session()->flash('payment_success', 'Log pembayaran berhasil ditambahkan.');
    }

    public function render()
    {
        $paymentLogs = $this->project->paymentLogs()->orderBy('payment_date', 'desc')->get();

        return view('livewire.contractor.payment-log-form', [
            'paymentLogs' => $paymentLogs,
        ]);
    }
}
