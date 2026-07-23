<?php

namespace App\Livewire\Customer;

use App\Models\Project;
use App\Models\ProjectStatusHistory;
use App\Enums\ProjectStatus;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Detail Proyek')]
class ProjectDetail extends Component
{
    public Project $project;

    public function mount(Project $project): void
    {
        if ($project->customer_id !== auth()->id()) {
            abort(403);
        }
        
        $this->project = $project->load([
            'contractor.contractorProfile',
            'service',
            'statusHistories.changedBy',
            'dailyReports' => function($q) {
                $q->orderBy('date', 'desc');
            }
        ]);
    }

    public function cancel()
    {
        if ($this->project->status === \App\Enums\ProjectStatus::Pending) {
            $this->project->update(['status' => 'cancelled']);
            
            ProjectStatusHistory::create([
                'project_id' => $this->project->id,
                'status' => 'cancelled',
                'changed_by' => auth()->id(),
            ]);
            
            $this->project->refresh()->load([
                'contractor.contractorProfile',
                'service',
                'statusHistories.changedBy',
                'dailyReports' => function($q) {
                    $q->orderBy('date', 'desc');
                }
            ]);

            $this->dispatch('swal-success', title: 'Proyek Dibatalkan', text: 'Proyek Anda berhasil dibatalkan.');
        }
    }

    public function render()
    {
        return view('livewire.customer.project-detail');
    }
}
