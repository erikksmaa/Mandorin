<?php

namespace App\Livewire\Contractor;

use App\Models\Project;
use App\Models\DailyReport;
use Livewire\Component;

class DailyReportHistory extends Component
{
    public Project $project;

    public function mount(Project $project)
    {
        $this->project = $project;
    }

    public function render()
    {
        $reports = DailyReport::where('project_id', $this->project->id)
            ->with('creator')
            ->orderBy('date', 'desc')
            ->get();

        return view('livewire.contractor.daily-report-history', [
            'reports' => $reports,
        ]);
    }
}
