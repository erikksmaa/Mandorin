<?php

namespace App\Livewire\Admin;

use App\Models\FinancialReport;
use App\Models\Organization;
use App\Models\Program;
use App\Models\User;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $totalUsers          = User::count();
        $totalOrganizations  = Organization::count();
        $pendingVerifications = Organization::where('status', 'inactive')->count();
        $totalPrograms       = Program::count();
        $totalFinancialReports = FinancialReport::count();

        $recentOrganizations = Organization::with('category', 'creator')
            ->latest()
            ->take(5)
            ->get();

        $recentPrograms = Program::with('organization', 'category', 'leader')
            ->latest()
            ->take(5)
            ->get();

        return view('livewire.admin.dashboard', compact(
            'totalUsers',
            'totalOrganizations',
            'pendingVerifications',
            'totalPrograms',
            'totalFinancialReports',
            'recentOrganizations',
            'recentPrograms'
        ))->layout('layouts.app');
    }
}
