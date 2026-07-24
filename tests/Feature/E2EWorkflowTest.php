<?php

namespace Tests\Feature;

use App\Models\Organization;
use App\Models\Program;
use App\Models\ActivityLog;
use App\Models\FinancialReport;
use App\Models\Role;
use App\Models\User;
use App\Enums\ProgramStatus;
use App\Enums\FinancialStatus;
use App\Enums\NotificationType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class E2EWorkflowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Seed roles
        Role::firstOrCreate(['slug' => 'administrator', 'name' => 'Administrator']);
        Role::firstOrCreate(['slug' => 'verifikator', 'name' => 'Verifikator']);
        Role::firstOrCreate(['slug' => 'leader', 'name' => 'Ketua Pelaksana']);
        Role::firstOrCreate(['slug' => 'member', 'name' => 'Anggota']);
    }

    public function test_end_to_end_sipora_workflow(): void
    {
        // 1. Create Users
        $admin = User::factory()->create([
            'role_id' => Role::where('slug', 'administrator')->first()->id,
        ]);
        $verifier = User::factory()->create([
            'role_id' => Role::where('slug', 'verifikator')->first()->id,
        ]);
        $leader = User::factory()->create([
            'role_id' => Role::where('slug', 'leader')->first()->id,
        ]);

        $orgCategory = \App\Models\OrganizationCategory::create([
            'name' => 'Karang Taruna',
            'slug' => 'karang-taruna',
        ]);

        $programCategory = \App\Models\ProgramCategory::create([
            'name' => 'Pendidikan',
            'slug' => 'pendidikan',
        ]);

        $this->actingAs($leader);

        // 2. Leader creates Organization
        $organization = Organization::create([
            'name' => 'Pemuda Mandiri',
            'category_id' => $orgCategory->id,
            'email' => 'pemuda@example.com',
            'phone' => '08123456789',
            'address' => 'Jl. Merdeka No 1',
            'status' => \App\Enums\OrganizationStatus::Active,
            'created_by' => $leader->id,
        ]);

        $this->assertDatabaseHas('organizations', ['name' => 'Pemuda Mandiri']);

        // 3. Leader submits a Program (Proposal)
        $program = Program::create([
            'program_code' => 'PRG-' . time(),
            'title' => 'Pelatihan IT Pemuda',
            'description' => 'Pelatihan untuk pemuda desa',
            'category_id' => $programCategory->id,
            'leader_id' => $leader->id,
            'organization_id' => $organization->id,
            'budget' => 5000000,
            'start_date' => now()->addDays(5),
            'end_date' => now()->addDays(10),
            'status' => ProgramStatus::Submitted,
            'created_by' => $leader->id,
        ]);

        $this->assertDatabaseHas('programs', ['title' => 'Pelatihan IT Pemuda', 'status' => 'Submitted']);

        // 4. Verifier approves the Proposal
        $this->actingAs($verifier);
        $program->update([
            'status' => ProgramStatus::Approved,
            'verified_by' => $verifier->id,
            'verified_at' => now(),
        ]);

        $this->assertEquals(ProgramStatus::Approved, $program->fresh()->status);
        
        // 5. Leader submits an Activity Log (Logbook)
        $this->actingAs($leader);
        $activityLog = ActivityLog::create([
            'program_id' => $program->id,
            'activity_date' => now()->addDays(6),
            'title' => 'Pembukaan Pelatihan',
            'description' => 'Acara pembukaan dihadiri 50 orang',
            'status' => \App\Enums\ActivityStatus::Draft,
            'created_by' => $leader->id,
        ]);
        $activityLog->update(['status' => \App\Enums\ActivityStatus::Submitted]);

        $this->assertDatabaseHas('activity_logs', ['title' => 'Pembukaan Pelatihan', 'status' => 'Submitted']);

        // 6. Leader submits E-LPJ
        $elpj = FinancialReport::create([
            'program_id' => $program->id,
            'total_budget' => 5000000,
            'total_expense' => 1000000,
            'status' => FinancialStatus::Submitted,
        ]);

        $this->assertDatabaseHas('financial_reports', ['program_id' => $program->id, 'status' => 'Submitted']);

        // 7. Verifier approves E-LPJ and Program is Completed
        $this->actingAs($verifier);
        $elpj->update([
            'status' => FinancialStatus::Approved,
            'verified_by' => $verifier->id,
            'verified_at' => now(),
        ]);

        $program->update([
            'status' => ProgramStatus::Completed,
        ]);

        $this->assertEquals(FinancialStatus::Approved, $elpj->fresh()->status);
        $this->assertEquals(ProgramStatus::Completed, $program->fresh()->status);
    }
}
