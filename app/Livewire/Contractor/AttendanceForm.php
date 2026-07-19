<?php

namespace App\Livewire\Contractor;

use App\Models\Project;
use App\Models\Attendance;
use App\Enums\AttendanceStatus;
use Livewire\Component;

class AttendanceForm extends Component
{
    public Project $project;
    public string $selectedDate;
    public array $attendances = [];

    public function mount(Project $project)
    {
        $this->project = $project;
        $this->selectedDate = date('Y-m-d');
        $this->loadAttendances();
    }

    public function loadAttendances()
    {
        $this->attendances = [];
        
        $workers = $this->project->workers;
        
        foreach ($workers as $worker) {
            $attendance = Attendance::where('project_worker_id', $worker->id)
                ->where('date', $this->selectedDate)
                ->first();
                
            if ($attendance) {
                // If enum is backed enum
                $this->attendances[$worker->id] = $attendance->status->value ?? $attendance->status;
            } else {
                $this->attendances[$worker->id] = 'present';
            }
        }
    }

    public function updatedSelectedDate()
    {
        $this->loadAttendances();
    }

    public function saveAttendances()
    {
        foreach ($this->attendances as $workerId => $status) {
            Attendance::updateOrCreate(
                [
                    'project_worker_id' => $workerId,
                    'date' => $this->selectedDate,
                ],
                [
                    'status' => $status,
                ]
            );
        }

        session()->flash('attendance_success', 'Data absensi berhasil disimpan.');
    }

    public function render()
    {
        return view('livewire.contractor.attendance-form');
    }
}
