<?php

namespace App\Livewire\Verifier;

use App\Enums\ActivityStatus;
use App\Models\ActivityLog;
use App\Models\Organization;
use App\Models\ProgramCategory;
use Livewire\Component;
use Livewire\WithPagination;

class LogbookMonitoring extends Component
{
    use WithPagination;

    public $search = '';
    public $organization_id = '';
    public $category_id = '';
    public $status = '';
    public $month = '';
    public $perPage = 10;

    public $selectedLogId = null;
    public $selectedStatus = 'Submitted';
    public $verifier_notes = '';

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['search', 'organization_id', 'category_id', 'status', 'month', 'perPage'])) {
            $this->resetPage();
        }
    }

    public function openStatusModal($logId)
    {
        $log = ActivityLog::find($logId);
        if ($log) {
            $this->selectedLogId = $log->id;
            $this->selectedStatus = $log->status instanceof \BackedEnum ? $log->status->value : (string) $log->status;
            $this->verifier_notes = $log->verifier_notes ?? '';
        }
    }

    public function closeModal()
    {
        $this->selectedLogId = null;
        $this->verifier_notes = '';
    }

    public function updateLogStatus()
    {
        $this->validate([
            'selectedStatus' => 'required|string',
            'verifier_notes' => 'nullable|string',
        ]);

        if ($this->selectedLogId) {
            $log = ActivityLog::find($this->selectedLogId);
            if ($log) {
                $enumStatus = ActivityStatus::tryFrom($this->selectedStatus) ?? ActivityStatus::Submitted;
                $log->update([
                    'status' => $enumStatus,
                    'verifier_notes' => $this->verifier_notes,
                ]);

                $this->dispatch('swal:success', message: 'Status logbook berhasil diperbarui!');
            }
        }

        $this->closeModal();
    }

    public function render()
    {
        $query = ActivityLog::with(['program.organization', 'program.category', 'program.leader', 'photos', 'creator'])
            ->latest('activity_date');

        if ($this->search) {
            $query->where('title', 'like', '%' . $this->search . '%')
                ->orWhereHas('program', fn($q) => $q->where('title', 'like', '%' . $this->search . '%'));
        }

        if ($this->organization_id) {
            $query->whereHas('program', fn($q) => $q->where('organization_id', $this->organization_id));
        }

        if ($this->category_id) {
            $query->whereHas('program', fn($q) => $q->where('category_id', $this->category_id));
        }

        if ($this->status) {
            $query->where('status', $this->status);
        }

        if ($this->month) {
            $query->whereMonth('activity_date', $this->month);
        }

        $logs = $query->paginate((int) $this->perPage);

        $organizations = Organization::orderBy('name')->get();
        $categories = ProgramCategory::orderBy('name')->get();

        return view('livewire.verifier.logbook-monitoring', [
            'logs' => $logs,
            'organizations' => $organizations,
            'categories' => $categories,
        ])->layout('layouts.app');
    }
}
