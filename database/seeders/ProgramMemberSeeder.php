<?php

namespace Database\Seeders;

use App\Models\Program;
use App\Models\ProgramMember;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProgramMemberSeeder extends Seeder
{
    public function run(): void
    {
        $programs = Program::query()->get();
        $users = User::query()->whereIn('email', ['leader@sipora.id', 'member@sipora.id'])->get();

        foreach ($programs as $index => $program) {
            $user = $users->get($index) ?? $users->first();

            if (! $user) {
                continue;
            }

            ProgramMember::updateOrCreate(
                [
                    'program_id' => $program->id,
                    'user_id' => $user->id,
                ],
                [
                    'role' => $index === 0 ? 'Leader' : 'Member',
                    'joined_at' => now()->subWeeks(2)->toDateString(),
                ]
            );
        }
    }
}
