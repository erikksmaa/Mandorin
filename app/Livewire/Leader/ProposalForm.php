<?php

namespace App\Livewire\Leader;

use App\Models\Organization;
use App\Models\Program;
use App\Models\ProgramCategory;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProposalForm extends Component
{
    use WithFileUploads;

    public $program;
    public $organization_id = '';
    public $title = '';
    public $category_id = '';
    public $description = '';
    public $objective = '';
    public $target = '';
    public $location = '';
    public $budget = 0;
    public $start_date = '';
    public $end_date = '';
    public $proposal_file;

    public function mount(Program $program = null)
    {
        if ($program && $program->exists) {
            $this->program = $program;
            $this->organization_id = $program->organization_id;
            $this->title = $program->title;
            $this->category_id = $program->category_id;
            $this->description = $program->description;
            $this->objective = $program->objective;
            $this->target = $program->target;
            $this->location = $program->location;
            $this->budget = $program->budget;
            $this->start_date = $program->start_date ? $program->start_date->format('Y-m-d') : '';
            $this->end_date = $program->end_date ? $program->end_date->format('Y-m-d') : '';
        }
    }

    protected function rules()
    {
        return [
            'organization_id' => 'required|exists:organizations,id',
            'title' => 'required|string|max:200',
            'category_id' => 'required|exists:program_categories,id',
            'description' => 'required|string',
            'budget' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'proposal_file' => 'nullable|file|mimes:pdf,doc,docx,zip|max:10240', // Max 10MB
        ];
    }

    public function saveDraft()
    {
        $this->save('Draft');
    }

    public function submit()
    {
        $this->save('Submitted');
    }

    private function save($status)
    {
        $this->validate();

        // Handle file upload
        $filePath = $this->program ? $this->program->proposal_file : null;
        if ($this->proposal_file) {
            $filePath = $this->proposal_file->store('proposals', 'public');
        }

        $data = [
            'organization_id' => $this->organization_id,
            'category_id' => $this->category_id,
            'title' => $this->title,
            'description' => $this->description,
            'objective' => $this->objective,
            'target' => $this->target,
            'location' => $this->location,
            'budget' => $this->budget,
            'proposal_status' => $status === 'Submitted' ? 'Pending' : 'Pending',
            'status' => $status,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'proposal_file' => $filePath,
        ];

        if ($this->program) {
            $this->program->update($data);
            $message = $status === 'Draft' ? 'Draft proposal berhasil diperbarui!' : 'Proposal program berhasil diajukan ulang!';
        } else {
            $data['leader_id'] = auth()->id();
            $data['created_by'] = auth()->id();
            $data['program_code'] = 'PRG-' . strtoupper(Str::random(6));
            $data['slug'] = Str::slug($this->title) . '-' . Str::random(4);
            Program::create($data);
            $message = $status === 'Draft' ? 'Draft proposal berhasil disimpan!' : 'Proposal program berhasil diajukan!';
        }

        $this->dispatch('swal:success', message: $message);
        
        return redirect()->route('leader.programs.index');
    }

    public function render()
    {
        $categories = ProgramCategory::all();
        $organizations = Organization::where('created_by', auth()->id())->get();

        return view('livewire.leader.proposal-form', compact('categories', 'organizations'))
            ->layout('layouts.app');
    }
}
