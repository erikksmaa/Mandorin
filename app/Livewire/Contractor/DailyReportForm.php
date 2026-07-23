<?php

namespace App\Livewire\Contractor;

use App\Models\Project;
use App\Models\DailyReport;
use App\Models\ProjectStatusHistory;
use App\Enums\ProjectStatus;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Laporan Harian')]
class DailyReportForm extends Component
{
    use WithFileUploads;

    public Project $project;
    public $date;
    public $progressPercentage = 0;
    public $notes;
    public $beforePhoto;
    public $afterPhoto;

    public function mount(Project $project)
    {
        $this->project = $project;
        $this->date = date('Y-m-d');
        $this->progressPercentage = $project->progress_percentage ?? 0;
    }

    public function save()
    {
        $this->validate(
            [
                'date'               => 'required|date|before_or_equal:today',
                'progressPercentage' => 'required|integer|min:0|max:100',
                'notes'              => 'required|string|min:10',
                'beforePhoto'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
                'afterPhoto'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            ],
            [
                'date.required'               => 'Tanggal laporan wajib diisi.',
                'date.before_or_equal'        => 'Tanggal laporan tidak boleh melebihi hari ini.',
                'progressPercentage.required' => 'Persentase progres wajib diisi.',
                'progressPercentage.min'      => 'Progres tidak boleh kurang dari 0%.',
                'progressPercentage.max'      => 'Progres tidak boleh melebihi 100%.',
                'notes.required'              => 'Catatan harian wajib diisi.',
                'notes.min'                   => 'Catatan minimal 10 karakter.',
                'beforePhoto.image'           => 'File foto sebelum harus berupa gambar.',
                'beforePhoto.max'             => 'Ukuran foto sebelum maksimal 2MB.',
                'afterPhoto.image'            => 'File foto sesudah harus berupa gambar.',
                'afterPhoto.max'              => 'Ukuran foto sesudah maksimal 2MB.',
            ]
        );

        $exists = DailyReport::where('project_id', $this->project->id)
            ->where('date', $this->date)
            ->exists();

        if ($exists) {
            $this->addError('date', 'Laporan harian untuk tanggal ini sudah ada.');
            return;
        }

        $beforePhotoPath = $this->beforePhoto ? $this->beforePhoto->store('daily-reports', 'public') : null;
        $afterPhotoPath = $this->afterPhoto ? $this->afterPhoto->store('daily-reports', 'public') : null;

        DailyReport::create([
            'project_id' => $this->project->id,
            'created_by' => auth()->id(),
            'date' => $this->date,
            'progress_percentage' => $this->progressPercentage,
            'notes' => $this->notes,
            'before_photo' => $beforePhotoPath,
            'after_photo' => $afterPhotoPath,
        ]);

        $this->project->update([
            'progress_percentage' => $this->progressPercentage,
        ]);

        if ($this->progressPercentage == 100 && $this->project->status != ProjectStatus::Completed) {
            ProjectStatusHistory::create([
                'project_id' => $this->project->id,
                'status' => ProjectStatus::Completed,
                'changed_by' => auth()->id(),
            ]);
            
            $this->project->update([
                'status' => ProjectStatus::Completed,
                'completed_at' => now(),
            ]);
        }

        $this->dispatch('swal-success', title: 'Laporan Tersimpan!', text: 'Laporan harian berhasil disimpan.');
        return redirect()->route('contractor.projects.show', $this->project->id)->with('swal_redirect', 'success');
    }

    public function render()
    {
        return view('livewire.contractor.daily-report-form');
    }
}
