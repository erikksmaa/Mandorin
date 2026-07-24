<?php

namespace App\Livewire\Leader;

use App\Models\Attendance;
use App\Models\Program;
use Livewire\Component;

class AttendanceForm extends Component
{
    public Program $program;
    public $attendance_date = '';

    public function mount($program)
    {
        $id = $program instanceof Program ? $program->id : $program;
        $this->program = Program::with('members.user')->findOrFail($id);
        $this->attendance_date = now()->format('Y-m-d');
    }

    public function recordAttendance($userId, $status)
    {
        Attendance::updateOrCreate(
            [
                'program_id' => $this->program->id,
                'user_id' => $userId,
                'attendance_date' => $this->attendance_date,
            ],
            [
                'status' => $status,
                'check_in' => now()->format('H:i:s'),
            ]
        );

        $this->dispatch('swal:success', message: 'Kehadiran anggota berhasil dicatat!');
    }

    public function render()
    {
        $attendances = Attendance::where('program_id', $this->program->id)
            ->where('attendance_date', $this->attendance_date)
            ->pluck('status', 'user_id')
            ->toArray();

        return view('livewire.leader.attendance-form', compact('attendances'))
            ->layout('layouts.app');
    }
}
