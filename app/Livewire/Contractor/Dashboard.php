<?php

namespace App\Livewire\Contractor;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Models\Project;
use App\Enums\ProjectStatus;

#[Layout('layouts.app')]
#[Title('Dashboard Kontraktor')]
class Dashboard extends Component
{
    public function render()
    {
        $user = auth()->user();
        $contractorProfile = $user->contractorProfile;
        
        $pendingRequests = Project::with(['customer', 'service'])
            ->where('contractor_id', $user->id)
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();
            
        $activeProjects = Project::with(['customer', 'service'])
            ->where('contractor_id', $user->id)
            ->whereIn('status', ['accepted', 'in_progress'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        $stats = [
            'pending' => $pendingRequests->count(),
            'active' => $activeProjects->count(),
            'completed' => Project::where('contractor_id', $user->id)
                ->where('status', 'completed')
                ->count(),
        ];
        
        return view('livewire.contractor.dashboard', [
            'contractorProfile' => $contractorProfile,
            'pendingRequests' => $pendingRequests,
            'activeProjects' => $activeProjects,
            'stats' => $stats,
        ]);
    }
}
