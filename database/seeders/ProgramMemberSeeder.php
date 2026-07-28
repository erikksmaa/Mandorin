<?php

namespace Database\Seeders;

use App\Enums\ProgramMemberRole;
use App\Models\Program;
use App\Models\ProgramMember;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProgramMemberSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::pluck('id', 'email');

        // program_code => [ [email, role, joined_at], ... ]
        $data = [
            'PRG-001' => [
                ['bagas.saputra@sipora.id',   ProgramMemberRole::Leader,    '2024-01-05'],
                ['aldi.firmansyah@sipora.id', ProgramMemberRole::Secretary, '2024-01-05'],
                ['dinda.ayu@sipora.id',       ProgramMemberRole::Treasurer, '2024-01-05'],
                ['fajar.nugroho@sipora.id',   ProgramMemberRole::Member,    '2024-01-10'],
                ['yoga.pratama@sipora.id',    ProgramMemberRole::Member,    '2024-01-10'],
                ['nabila.putri@sipora.id',    ProgramMemberRole::Volunteer, '2024-01-15'],
            ],
            'PRG-002' => [
                ['dewi.kartika@sipora.id',    ProgramMemberRole::Leader,    '2024-01-10'],
                ['bagas.saputra@sipora.id',   ProgramMemberRole::Secretary, '2024-01-10'],
                ['yoga.pratama@sipora.id',    ProgramMemberRole::Treasurer, '2024-01-10'],
                ['hendra.wijaya@sipora.id',   ProgramMemberRole::Member,    '2024-01-15'],
                ['intan.permata@sipora.id',   ProgramMemberRole::Member,    '2024-01-15'],
                ['reni.safitri@sipora.id',    ProgramMemberRole::Volunteer, '2024-01-20'],
            ],
            'PRG-003' => [
                ['dewi.kartika@sipora.id',    ProgramMemberRole::Leader,    '2024-01-15'],
                ['intan.permata@sipora.id',   ProgramMemberRole::Secretary, '2024-01-15'],
                ['yoga.pratama@sipora.id',    ProgramMemberRole::Treasurer, '2024-01-15'],
                ['nabila.putri@sipora.id',    ProgramMemberRole::Member,    '2024-01-20'],
                ['reni.safitri@sipora.id',    ProgramMemberRole::Member,    '2024-01-20'],
            ],
            'PRG-004' => [
                ['rizki.maulana@sipora.id',   ProgramMemberRole::Leader,    '2024-01-20'],
                ['aulia.rahma@sipora.id',     ProgramMemberRole::Secretary, '2024-01-20'],
                ['aldi.firmansyah@sipora.id', ProgramMemberRole::Treasurer, '2024-01-20'],
                ['fajar.nugroho@sipora.id',   ProgramMemberRole::Member,    '2024-01-25'],
                ['dinda.ayu@sipora.id',       ProgramMemberRole::Member,    '2024-01-25'],
                ['hendra.wijaya@sipora.id',   ProgramMemberRole::Volunteer, '2024-01-25'],
            ],
            'PRG-005' => [
                ['aulia.rahma@sipora.id',     ProgramMemberRole::Leader,    '2024-01-10'],
                ['reni.safitri@sipora.id',    ProgramMemberRole::Secretary, '2024-01-10'],
                ['dinda.ayu@sipora.id',       ProgramMemberRole::Treasurer, '2024-01-10'],
                ['nabila.putri@sipora.id',    ProgramMemberRole::Member,    '2024-01-15'],
                ['intan.permata@sipora.id',   ProgramMemberRole::Member,    '2024-01-15'],
                ['yoga.pratama@sipora.id',    ProgramMemberRole::Volunteer, '2024-01-20'],
            ],
            'PRG-006' => [
                ['rizki.maulana@sipora.id',   ProgramMemberRole::Leader,    '2024-01-15'],
                ['nabila.putri@sipora.id',    ProgramMemberRole::Secretary, '2024-01-15'],
                ['fajar.nugroho@sipora.id',   ProgramMemberRole::Treasurer, '2024-01-15'],
                ['hendra.wijaya@sipora.id',   ProgramMemberRole::Member,    '2024-01-20'],
                ['dinda.ayu@sipora.id',       ProgramMemberRole::Member,    '2024-01-20'],
                ['aldi.firmansyah@sipora.id', ProgramMemberRole::Volunteer, '2024-01-20'],
            ],
            'PRG-007' => [
                ['bagas.saputra@sipora.id',   ProgramMemberRole::Leader,    '2023-12-20'],
                ['hendra.wijaya@sipora.id',   ProgramMemberRole::Secretary, '2023-12-20'],
                ['fajar.nugroho@sipora.id',   ProgramMemberRole::Treasurer, '2023-12-20'],
                ['yoga.pratama@sipora.id',    ProgramMemberRole::Member,    '2023-12-25'],
                ['aldi.firmansyah@sipora.id', ProgramMemberRole::Member,    '2023-12-25'],
                ['intan.permata@sipora.id',   ProgramMemberRole::Volunteer, '2024-01-01'],
            ],
            'PRG-008' => [
                ['aulia.rahma@sipora.id',     ProgramMemberRole::Leader,    '2023-12-10'],
                ['dinda.ayu@sipora.id',       ProgramMemberRole::Secretary, '2023-12-10'],
                ['nabila.putri@sipora.id',    ProgramMemberRole::Treasurer, '2023-12-10'],
                ['intan.permata@sipora.id',   ProgramMemberRole::Member,    '2023-12-15'],
                ['reni.safitri@sipora.id',    ProgramMemberRole::Member,    '2023-12-15'],
                ['yoga.pratama@sipora.id',    ProgramMemberRole::Volunteer, '2023-12-20'],
            ],
            'PRG-009' => [
                ['rizki.maulana@sipora.id',   ProgramMemberRole::Leader,    '2023-10-01'],
                ['aldi.firmansyah@sipora.id', ProgramMemberRole::Secretary, '2023-10-01'],
                ['fajar.nugroho@sipora.id',   ProgramMemberRole::Treasurer, '2023-10-01'],
                ['hendra.wijaya@sipora.id',   ProgramMemberRole::Member,    '2023-10-05'],
                ['bagas.saputra@sipora.id',   ProgramMemberRole::Member,    '2023-10-05'],
                ['dinda.ayu@sipora.id',       ProgramMemberRole::Volunteer, '2023-10-10'],
            ],
            'PRG-010' => [
                ['dewi.kartika@sipora.id',    ProgramMemberRole::Leader,    '2023-11-01'],
                ['aulia.rahma@sipora.id',     ProgramMemberRole::Secretary, '2023-11-01'],
                ['intan.permata@sipora.id',   ProgramMemberRole::Treasurer, '2023-11-01'],
                ['nabila.putri@sipora.id',    ProgramMemberRole::Member,    '2023-11-05'],
                ['reni.safitri@sipora.id',    ProgramMemberRole::Member,    '2023-11-05'],
                ['yoga.pratama@sipora.id',    ProgramMemberRole::Volunteer, '2023-11-10'],
            ],
        ];

        foreach ($data as $programCode => $members) {
            $program = Program::where('program_code', $programCode)->first();
            if (! $program) {
                continue;
            }

            foreach ($members as [$email, $role, $joinedAt]) {
                $userId = $users[$email] ?? null;
                if (! $userId) {
                    continue;
                }

                ProgramMember::updateOrCreate(
                    ['program_id' => $program->id, 'user_id' => $userId],
                    ['role' => $role, 'joined_at' => $joinedAt]
                );
            }
        }
    }
}