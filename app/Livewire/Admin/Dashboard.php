<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Project;
use App\Models\ContractorProfile;
use App\Enums\VerificationStatus;
use App\Enums\ProjectStatus;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Dashboard Admin')]
class Dashboard extends Component
{
    public function render()
    {
        $stats = [
            'totalUsers' => User::count(),
            'totalContractors' => User::where('role', 'contractor')->count(),
            'totalProjects' => Project::count(),
            'pendingVerifications' => ContractorProfile::where('verification_status', 'pending')->count(),
        ];

        $recentProjects = Project::with(['customer', 'contractor'])
            ->latest()
            ->take(5)
            ->get();

        $pendingContractors = ContractorProfile::with('user')
            ->where('verification_status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        return view('livewire.admin.dashboard', [
            'stats' => $stats,
            'recentProjects' => $recentProjects,
            'pendingContractors' => $pendingContractors,
        ]);
    }
}
