<?php

namespace App\Livewire\Contractor;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Models\Project;
use App\Models\ProjectStatusHistory;
use App\Models\Notification;
use App\Enums\ProjectStatus;

#[Layout('layouts.app')]
#[Title('Detail Proyek')]
class ProjectDetail extends Component
{
    public Project $project;
    public string $activeTab = 'info';
    public string $estimatedFinishDate = '';

    public function mount(Project $project): void
    {
        if ($project->contractor_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this project.');
        }

        $this->project = $project->load(['customer', 'service', 'workers']);
        $this->estimatedFinishDate = $project->estimated_finish_date ? $project->estimated_finish_date->format('Y-m-d') : '';
    }

    public function updateEstimatedFinishDate()
    {
        $this->validate([
            'estimatedFinishDate' => 'required|date',
        ]);

        $this->project->update([
            'estimated_finish_date' => $this->estimatedFinishDate,
        ]);

        $this->project->refresh();
        $this->dispatch('swal-success', [['title' => 'Berhasil!', 'text' => 'Target selesai berhasil diperbarui.']]);
    }

    public function updateProgress(int $percentage)
    {
        $this->project->update([
            'progress_percentage' => $percentage,
        ]);
        
        // Refresh project
        $this->project->refresh();
    }

    public function markInProgress()
    {
        $this->project->update([
            'status' => 'in_progress',
        ]);

        ProjectStatusHistory::create([
            'project_id' => $this->project->id,
            'changed_by' => auth()->id(),
            'status' => 'in_progress',
        ]);
        
        $this->project->refresh();
    }

    public function markCompleted()
    {
        $this->project->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        ProjectStatusHistory::create([
            'project_id' => $this->project->id,
            'changed_by' => auth()->id(),
            'status' => 'completed',
        ]);

        Notification::create([
            'user_id' => $this->project->customer_id,
            'type' => 'project',
            'title' => 'Proyek Selesai',
            'message' => 'Proyek ' . $this->project->title . ' telah ditandai selesai oleh kontraktor.',
            'is_read' => false,
        ]);
        
        $this->project->refresh();
    }

    public function render()
    {
        return view('livewire.contractor.project-detail');
    }
}
