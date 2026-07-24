<?php

namespace App\Livewire\Verifier;

use App\Enums\FinancialStatus;
use App\Models\FinancialReport;
use Livewire\Component;
use Livewire\WithPagination;

class ElpjVerification extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = 'all';
    public $yearFilter = '';
    public $programFilter = '';
    public $perPage = 10;

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['search', 'statusFilter', 'yearFilter', 'programFilter', 'perPage'])) {
            $this->resetPage();
        }
    }

    public function approve($id)
    {
        $report = FinancialReport::findOrFail($id);
        $report->update([
            'status' => FinancialStatus::Approved,
            'verified_by' => auth()->id(),
            'verified_at' => now(),
        ]);

        $this->dispatch('swal:success', message: 'Laporan Keuangan E-LPJ berhasil disetujui!');
    }

    public function requestRevision($id)
    {
        $report = FinancialReport::findOrFail($id);
        $report->update([
            'status' => FinancialStatus::Revision,
        ]);

        $this->dispatch('swal:success', message: 'Permintaan revisi E-LPJ berhasil dikirimkan!');
    }

    public function render()
    {
        $reports = FinancialReport::with('program.organization', 'items', 'verifier')
            ->when($this->search, function ($q) {
                $q->where(function ($sub) {
                    $sub->where('report_number', 'like', "%{$this->search}%")
                        ->orWhereHas('program', function ($p) {
                            $p->where('title', 'like', "%{$this->search}%")
                              ->orWhereHas('organization', fn($o) => $o->where('name', 'like', "%{$this->search}%"));
                        });
                });
            })
            ->when($this->statusFilter !== 'all', function ($q) {
                $q->where('status', $this->statusFilter);
            })
            ->when($this->programFilter !== '', function ($q) {
                $q->where('program_id', $this->programFilter);
            })
            ->when($this->yearFilter !== '', function ($q) {
                $q->whereYear('created_at', $this->yearFilter);
            })
            ->latest()
            ->paginate((int) $this->perPage);

        return view('livewire.verifier.elpj-verification', compact('reports'))
            ->layout('layouts.app');
    }
}
