<?php

namespace App\Livewire\Leader;

use App\Enums\PhotoType;
use App\Models\ActivityLog;
use App\Models\ActivityPhoto;
use App\Models\Program;
use Livewire\Component;
use Livewire\WithFileUploads;

class ActivityLogForm extends Component
{
    use WithFileUploads;

    public Program $program;

    public $title = '';
    public $description = '';
    public $activity_date = '';
    public $progress_percentage = 0;
    public $issues = '';
    public $solutions = '';
    
    public $before_photo;
    public $progress_photo;
    public $after_photo;
    public $documentation_photos = [];

    public function mount($program)
    {
        $id = $program instanceof Program ? $program->id : $program;
        $this->program = Program::findOrFail($id);
        $this->activity_date = now()->format('Y-m-d');
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:200',
            'description' => 'required|string',
            'activity_date' => 'required|date',
            'progress_percentage' => 'required|integer|min:0|max:100',
            'before_photo' => 'nullable|image|max:2048',
            'progress_photo' => 'nullable|image|max:2048',
            'after_photo' => 'nullable|image|max:2048',
            'documentation_photos' => 'nullable|array|max:5',
            'documentation_photos.*' => 'image|max:2048',
        ]);

        $log = ActivityLog::create([
            'program_id' => $this->program->id,
            'created_by' => auth()->id(),
            'title' => $this->title,
            'description' => $this->description,
            'activity_date' => $this->activity_date,
            'progress_percentage' => $this->progress_percentage,
            'issues' => $this->issues,
            'solutions' => $this->solutions,
            'status' => 'Submitted',
        ]);

        $this->savePhoto($log->id, $this->before_photo, PhotoType::Before);
        $this->savePhoto($log->id, $this->progress_photo, PhotoType::Progress);
        $this->savePhoto($log->id, $this->after_photo, PhotoType::After);

        if (!empty($this->documentation_photos)) {
            foreach ($this->documentation_photos as $photo) {
                $this->savePhoto($log->id, $photo, PhotoType::Documentation);
            }
        }

        $this->dispatch('swal:success', message: 'Logbook kegiatan berhasil ditambahkan!');
        return redirect()->route('leader.programs.show', $this->program->id);
    }

    private function savePhoto($logId, $photoFile, $photoType)
    {
        if ($photoFile) {
            $path = $photoFile->store('activity-photos', 'public');
            ActivityPhoto::create([
                'activity_log_id' => $logId,
                'photo' => $path,
                'photo_type' => $photoType,
            ]);
        }
    }

    public function render()
    {
        return view('livewire.leader.activity-log-form')
            ->layout('layouts.app');
    }
}
