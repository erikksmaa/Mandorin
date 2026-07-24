<?php

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\OrganizationMember;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrganizationMemberSeeder extends Seeder
{
    public function run(): void
    {
        $organizations = Organization::query()->get();
        $users = User::query()->whereIn('email', ['leader@sipora.id', 'member@sipora.id', 'verifikator@sipora.id'])->get();

        foreach ($organizations as $index => $organization) {
            $user = $users->get($index) ?? $users->first();

            if (! $user) {
                continue;
            }

            OrganizationMember::updateOrCreate(
                [
                    'organization_id' => $organization->id,
                    'user_id' => $user->id,
                ],
                [
                    'position' => $index === 0 ? 'Ketua' : 'Anggota',
                    'joined_at' => now()->subMonths(2)->toDateString(),
                    'status' => 'active',
                ]
            );
        }
    }
}
