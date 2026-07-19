<?php

namespace App\Livewire\Customer;

use App\Models\Project;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Dashboard Customer')]
class Dashboard extends Component
{
    public function render()
    {
        $user = auth()->user();
        
        $projects = $user->customerProjects()->with(['contractor', 'service'])->get();
        
        $pendingCount = $projects->where('status', 'pending')->count();
        $activeCount = $projects->whereIn('status', ['accepted', 'in_progress'])->count();
        $completedCount = $projects->where('status', 'completed')->count();
        
        $recentProjects = $user->customerProjects()
            ->with(['contractor', 'service'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('livewire.customer.dashboard', [
            'pendingCount' => $pendingCount,
            'activeCount' => $activeCount,
            'completedCount' => $completedCount,
            'recentProjects' => $recentProjects,
        ]);
    }
}
