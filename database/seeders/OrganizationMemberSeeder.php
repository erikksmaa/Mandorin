<?php

namespace Database\Seeders;

use App\Enums\MemberStatus;
use App\Enums\OrganizationPosition;
use App\Models\Organization;
use App\Models\OrganizationMember;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrganizationMemberSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::pluck('id', 'email');

        // Pemetaan: organization_code => daftar anggota [email, position, joined_at]
        $data = [
            'ORG-001' => [
                ['rizki.maulana@sipora.id',    OrganizationPosition::Ketua,       '2022-01-10', MemberStatus::Active],
                ['nabila.putri@sipora.id',     OrganizationPosition::Sekretaris,  '2022-01-10', MemberStatus::Active],
                ['fajar.nugroho@sipora.id',    OrganizationPosition::Bendahara,   '2022-01-10', MemberStatus::Active],
                ['dinda.ayu@sipora.id',        OrganizationPosition::Anggota,     '2022-02-01', MemberStatus::Active],
                ['hendra.wijaya@sipora.id',    OrganizationPosition::Anggota,     '2022-02-01', MemberStatus::Active],
            ],
            'ORG-002' => [
                ['dewi.kartika@sipora.id',     OrganizationPosition::Ketua,       '2021-06-15', MemberStatus::Active],
                ['intan.permata@sipora.id',    OrganizationPosition::Sekretaris,  '2021-06-15', MemberStatus::Active],
                ['yoga.pratama@sipora.id',     OrganizationPosition::Bendahara,   '2021-06-15', MemberStatus::Active],
                ['nabila.putri@sipora.id',     OrganizationPosition::Anggota,     '2021-07-01', MemberStatus::Active],
                ['reni.safitri@sipora.id',     OrganizationPosition::Anggota,     '2021-07-01', MemberStatus::Active],
            ],
            'ORG-003' => [
                ['bagas.saputra@sipora.id',    OrganizationPosition::Ketua,       '2020-02-01', MemberStatus::Active],
                ['aldi.firmansyah@sipora.id',  OrganizationPosition::Sekretaris,  '2020-02-01', MemberStatus::Active],
                ['dinda.ayu@sipora.id',        OrganizationPosition::Koordinator, '2020-02-01', MemberStatus::Active],
                ['fajar.nugroho@sipora.id',    OrganizationPosition::Anggota,     '2020-03-10', MemberStatus::Active],
                ['yoga.pratama@sipora.id',     OrganizationPosition::Anggota,     '2020-03-10', MemberStatus::Active],
            ],
            'ORG-004' => [
                ['aulia.rahma@sipora.id',      OrganizationPosition::Ketua,       '2019-09-01', MemberStatus::Active],
                ['reni.safitri@sipora.id',     OrganizationPosition::Sekretaris,  '2019-09-01', MemberStatus::Active],
                ['hendra.wijaya@sipora.id',    OrganizationPosition::Bendahara,   '2019-09-01', MemberStatus::Active],
                ['intan.permata@sipora.id',    OrganizationPosition::Anggota,     '2019-10-15', MemberStatus::Active],
                ['aldi.firmansyah@sipora.id',  OrganizationPosition::Anggota,     '2019-10-15', MemberStatus::Active],
            ],
            'ORG-005' => [
                ['rizki.maulana@sipora.id',    OrganizationPosition::Koordinator, '2023-01-05', MemberStatus::Active],
                ['nabila.putri@sipora.id',     OrganizationPosition::Anggota,     '2023-01-05', MemberStatus::Active],
                ['fajar.nugroho@sipora.id',    OrganizationPosition::Anggota,     '2023-01-05', MemberStatus::Active],
                ['dinda.ayu@sipora.id',        OrganizationPosition::Anggota,     '2023-02-01', MemberStatus::Active],
            ],
            'ORG-006' => [
                ['dewi.kartika@sipora.id',     OrganizationPosition::Koordinator, '2022-05-20', MemberStatus::Active],
                ['yoga.pratama@sipora.id',     OrganizationPosition::Anggota,     '2022-05-20', MemberStatus::Active],
                ['reni.safitri@sipora.id',     OrganizationPosition::Anggota,     '2022-06-01', MemberStatus::Active],
                ['aldi.firmansyah@sipora.id',  OrganizationPosition::Anggota,     '2022-06-01', MemberStatus::Active],
            ],
            'ORG-007' => [
                ['bagas.saputra@sipora.id',    OrganizationPosition::Ketua,       '2021-01-10', MemberStatus::Active],
                ['hendra.wijaya@sipora.id',    OrganizationPosition::Anggota,     '2021-01-10', MemberStatus::Active],
                ['fajar.nugroho@sipora.id',    OrganizationPosition::Anggota,     '2021-01-10', MemberStatus::Active],
                ['yoga.pratama@sipora.id',     OrganizationPosition::Anggota,     '2021-02-01', MemberStatus::Active],
                ['aldi.firmansyah@sipora.id',  OrganizationPosition::Anggota,     '2021-02-01', MemberStatus::Active],
            ],
            'ORG-008' => [
                ['aulia.rahma@sipora.id',      OrganizationPosition::Koordinator, '2021-04-01', MemberStatus::Active],
                ['dinda.ayu@sipora.id',        OrganizationPosition::Sekretaris,  '2021-04-01', MemberStatus::Active],
                ['nabila.putri@sipora.id',     OrganizationPosition::Anggota,     '2021-04-15', MemberStatus::Active],
                ['intan.permata@sipora.id',    OrganizationPosition::Anggota,     '2021-04-15', MemberStatus::Active],
                ['reni.safitri@sipora.id',     OrganizationPosition::Anggota,     '2021-05-01', MemberStatus::Active],
            ],
            'ORG-009' => [
                ['rizki.maulana@sipora.id',    OrganizationPosition::Ketua,       '2022-08-01', MemberStatus::Active],
                ['aulia.rahma@sipora.id',      OrganizationPosition::Sekretaris,  '2022-08-01', MemberStatus::Active],
                ['aldi.firmansyah@sipora.id',  OrganizationPosition::Bendahara,   '2022-08-01', MemberStatus::Active],
                ['nabila.putri@sipora.id',     OrganizationPosition::Anggota,     '2022-09-01', MemberStatus::Active],
                ['fajar.nugroho@sipora.id',    OrganizationPosition::Anggota,     '2022-09-01', MemberStatus::Active],
            ],
            'ORG-010' => [
                ['dewi.kartika@sipora.id',     OrganizationPosition::Ketua,       '2023-03-15', MemberStatus::Active],
                ['bagas.saputra@sipora.id',    OrganizationPosition::Sekretaris,  '2023-03-15', MemberStatus::Active],
                ['yoga.pratama@sipora.id',     OrganizationPosition::Bendahara,   '2023-03-15', MemberStatus::Active],
                ['hendra.wijaya@sipora.id',    OrganizationPosition::Anggota,     '2023-04-01', MemberStatus::Active],
                ['intan.permata@sipora.id',    OrganizationPosition::Anggota,     '2023-04-01', MemberStatus::Active],
            ],
        ];

        foreach ($data as $orgCode => $members) {
            $org = Organization::where('organization_code', $orgCode)->first();
            if (! $org) {
                continue;
            }

            foreach ($members as [$email, $position, $joinedAt, $status]) {
                $userId = $users[$email] ?? null;
                if (! $userId) {
                    continue;
                }

                OrganizationMember::updateOrCreate(
                    [
                        'organization_id' => $org->id,
                        'user_id'         => $userId,
                    ],
                    [
                        'position'  => $position,
                        'joined_at' => $joinedAt,
                        'status'    => $status,
                    ]
                );
            }
        }
    }
}