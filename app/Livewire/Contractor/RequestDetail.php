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
#[Title('Detail Permintaan Proyek')]
class RequestDetail extends Component
{
    public Project $project;

    public function mount(Project $project): void
    {
        if ($project->contractor_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this project.');
        }

        $this->project = $project->load(['customer', 'service']);
    }

    public function accept()
    {
        $this->project->update([
            'status' => 'accepted',
            'start_date' => now(),
        ]);

        ProjectStatusHistory::create([
            'project_id' => $this->project->id,
            'changed_by' => auth()->id(),
            'status' => 'accepted',
        ]);

        Notification::create([
            'user_id' => $this->project->customer_id,
            'type' => 'project',
            'title' => 'Permintaan Diterima',
            'message' => 'Kontraktor ' . auth()->user()->name . ' telah menerima permintaan proyek ' . $this->project->title,
            'is_read' => false,
        ]);

        return redirect()->route('contractor.projects.show', $this->project);
    }

    public function reject()
    {
        $this->project->update([
            'status' => 'rejected',
        ]);

        ProjectStatusHistory::create([
            'project_id' => $this->project->id,
            'changed_by' => auth()->id(),
            'status' => 'rejected',
        ]);

        Notification::create([
            'user_id' => $this->project->customer_id,
            'type' => 'project',
            'title' => 'Permintaan Ditolak',
            'message' => 'Kontraktor ' . auth()->user()->name . ' telah menolak permintaan proyek ' . $this->project->title,
            'is_read' => false,
        ]);

        return redirect()->route('contractor.dashboard');
    }

    public function render()
    {
        return view('livewire.contractor.request-detail');
    }
}
