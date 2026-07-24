<?php

namespace App\Livewire\Leader;

use App\Models\ActivityLog;
use Livewire\Component;

class ActivityLogDetail extends Component
{
    public ActivityLog $activityLog;

    public function mount($activityLog)
    {
        $id = $activityLog instanceof ActivityLog ? $activityLog->id : $activityLog;
        $this->activityLog = ActivityLog::with([
            'program.organization',
            'program.leader',
            'program.category',
            'photos',
            'creator',
        ])->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.leader.activity-log-detail')
            ->layout('layouts.app');
    }
}
