<?php

namespace Database\Seeders;

use App\Enums\ProposalStatus;
use App\Enums\ProgramStatus;
use App\Models\Organization;
use App\Models\Program;
use App\Models\ProgramCategory;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProgramSeeder extends Seeder
{
    public function run(): void
    {
        $users   = User::pluck('id', 'email');
        $catMap  = ProgramCategory::pluck('id', 'name');
        $orgMap  = Organization::pluck('id', 'organization_code');

        $verifier1 = $users['siti.rahayu@sipora.id'];
        $verifier2 = $users['budi.santoso@sipora.id'];
        $admin     = $users['ahmad.fauzi@sipora.id'];

        $programs = [
            // ── 2 Draft ──────────────────────────────────────────────
            [
                'program_code'    => 'PRG-001',
                'org_code'        => 'ORG-003',
                'leader_email'    => 'bagas.saputra@sipora.id',
                'created_by'      => $admin,
                'verified_by'     => null,
                'category'        => 'Pelatihan',
                'title'           => 'Pelatihan Content Creator Pemuda Pemalang',
                'slug'            => 'pelatihan-content-creator-pemuda-pemalang',
                'description'     => 'Pelatihan pembuatan konten digital bagi pemuda Pemalang untuk meningkatkan kompetensi di era digital. Peserta akan belajar membuat konten video, foto, dan tulisan yang menarik untuk media sosial.',
                'objective'       => 'Meningkatkan kemampuan pemuda dalam membuat konten digital yang berkualitas dan bernilai ekonomi.',
                'target'          => '30 pemuda usia 18-30 tahun dari wilayah Kabupaten Pemalang.',
                'location'        => 'Aula Dinas Kominfo Pemalang, Jl. Pemuda No. 3, Pemalang',
                'budget'          => 18500000,
                'proposal_status' => ProposalStatus::Pending,
                'status'          => ProgramStatus::Draft,
                'start_date'      => '2024-03-01',
                'end_date'        => '2024-03-03',
                'verified_by_user'=> null,
            ],
            [
                'program_code'    => 'PRG-002',
                'org_code'        => 'ORG-010',
                'leader_email'    => 'dewi.kartika@sipora.id',
                'created_by'      => $admin,
                'verified_by'     => null,
                'category'        => 'Kewirausahaan',
                'title'           => 'Program Wirausaha Muda HIPMI Pemalang',
                'slug'            => 'program-wirausaha-muda-hipmi-pemalang',
                'description'     => 'Program pengembangan wirausaha muda yang mencakup pelatihan bisnis, mentoring, dan pendampingan usaha bagi pemuda Pemalang.',
                'objective'       => 'Melahirkan wirausahawan muda tangguh yang mampu menciptakan lapangan kerja di Kabupaten Pemalang.',
                'target'          => '25 pemuda usia 19-30 tahun yang memiliki minat berwirausaha.',
                'location'        => 'Gedung HIPMI Pemalang, Jl. Pemuda No. 55, Pemalang',
                'budget'          => 22000000,
                'proposal_status' => ProposalStatus::Pending,
                'status'          => ProgramStatus::Draft,
                'start_date'      => '2024-04-10',
                'end_date'        => '2024-04-12',
                'verified_by_user'=> null,
            ],

            // ── 2 Submitted ──────────────────────────────────────────
            [
                'program_code'    => 'PRG-003',
                'org_code'        => 'ORG-002',
                'leader_email'    => 'dewi.kartika@sipora.id',
                'created_by'      => $admin,
                'verified_by'     => null,
                'category'        => 'Workshop',
                'title'           => 'Workshop Digital Marketing untuk UMKM Muda',
                'slug'            => 'workshop-digital-marketing-umkm-muda',
                'description'     => 'Workshop intensif digital marketing yang dirancang khusus untuk pelaku UMKM muda di Pemalang, mencakup SEO, media sosial, dan iklan digital.',
                'objective'       => 'Meningkatkan kapasitas pemasaran digital pelaku UMKM muda agar mampu bersaing di pasar online.',
                'target'          => '40 pelaku UMKM muda usia 20-35 tahun.',
                'location'        => 'Coworking Space Pemalang, Jl. Ahmad Yani No. 20, Pemalang',
                'budget'          => 15000000,
                'proposal_status' => ProposalStatus::Pending,
                'status'          => ProgramStatus::Submitted,
                'start_date'      => '2024-02-15',
                'end_date'        => '2024-02-16',
                'verified_by_user'=> null,
            ],
            [
                'program_code'    => 'PRG-004',
                'org_code'        => 'ORG-009',
                'leader_email'    => 'rizki.maulana@sipora.id',
                'created_by'      => $admin,
                'verified_by'     => null,
                'category'        => 'Seminar',
                'title'           => 'Seminar Kepemimpinan Pemuda Masa Depan',
                'slug'            => 'seminar-kepemimpinan-pemuda-masa-depan',
                'description'     => 'Seminar nasional bertema kepemimpinan pemuda yang menghadirkan pembicara berpengalaman dari berbagai bidang untuk menginspirasi generasi muda Pemalang.',
                'objective'       => 'Menumbuhkan jiwa kepemimpinan dan nasionalisme pada pemuda Pemalang.',
                'target'          => '150 mahasiswa dan pemuda dari seluruh Kabupaten Pemalang.',
                'location'        => 'Aula Kampus STIE Pemalang, Jl. Dr. Cipto No. 5, Pemalang',
                'budget'          => 28000000,
                'proposal_status' => ProposalStatus::Pending,
                'status'          => ProgramStatus::Submitted,
                'start_date'      => '2024-03-20',
                'end_date'        => '2024-03-20',
                'verified_by_user'=> null,
            ],

            // ── 2 Approved ───────────────────────────────────────────
            [
                'program_code'    => 'PRG-005',
                'org_code'        => 'ORG-004',
                'leader_email'    => 'aulia.rahma@sipora.id',
                'created_by'      => $admin,
                'verified_by'     => $verifier1,
                'category'        => 'Pelatihan',
                'title'           => 'Pelatihan Public Speaking dan Komunikasi Publik',
                'slug'            => 'pelatihan-public-speaking-komunikasi-publik',
                'description'     => 'Pelatihan public speaking dan komunikasi publik bagi pemuda Pemalang untuk meningkatkan kepercayaan diri dan kemampuan berbicara di depan umum.',
                'objective'       => 'Melatih pemuda agar mampu berbicara secara efektif dan percaya diri di depan publik.',
                'target'          => '35 pemuda usia 17-30 tahun dari berbagai kecamatan.',
                'location'        => 'Aula Gedung Pemuda, Jl. Sudirman No. 12, Pemalang',
                'budget'          => 12500000,
                'proposal_status' => ProposalStatus::Verified,
                'status'          => ProgramStatus::Approved,
                'start_date'      => '2024-02-25',
                'end_date'        => '2024-02-27',
                'verified_by_user'=> $verifier1,
                'verified_at'     => '2024-01-30 10:00:00',
            ],
            [
                'program_code'    => 'PRG-006',
                'org_code'        => 'ORG-001',
                'leader_email'    => 'rizki.maulana@sipora.id',
                'created_by'      => $admin,
                'verified_by'     => $verifier2,
                'category'        => 'Kegiatan Sosial',
                'title'           => 'Gerakan Bersih Sungai dan Lingkungan Desa',
                'slug'            => 'gerakan-bersih-sungai-lingkungan-desa',
                'description'     => 'Gerakan pemuda peduli lingkungan dengan kegiatan bersih sungai, penanaman pohon, dan edukasi lingkungan hidup bagi masyarakat sekitar.',
                'objective'       => 'Meningkatkan kesadaran lingkungan dan kebersihan sungai di wilayah Desa Maju.',
                'target'          => '60 pemuda dan warga desa berpartisipasi aktif dalam kegiatan lingkungan.',
                'location'        => 'Sungai Comal, Desa Maju Bersama, Kec. Pemalang',
                'budget'          => 8500000,
                'proposal_status' => ProposalStatus::Verified,
                'status'          => ProgramStatus::Approved,
                'start_date'      => '2024-03-10',
                'end_date'        => '2024-03-10',
                'verified_by_user'=> $verifier2,
                'verified_at'     => '2024-02-10 09:00:00',
            ],

            // ── 2 Running ────────────────────────────────────────────
            [
                'program_code'    => 'PRG-007',
                'org_code'        => 'ORG-007',
                'leader_email'    => 'bagas.saputra@sipora.id',
                'created_by'      => $admin,
                'verified_by'     => $verifier1,
                'category'        => 'Olahraga',
                'title'           => 'Turnamen Futsal Antar Kecamatan Pemalang Cup 2024',
                'slug'            => 'turnamen-futsal-antar-kecamatan-pemalang-cup-2024',
                'description'     => 'Turnamen futsal tahunan yang mempertemukan tim-tim futsal perwakilan kecamatan se-Kabupaten Pemalang untuk menjaring bibit atlet berbakat.',
                'objective'       => 'Menjaring bibit atlet futsal berbakat dan meningkatkan prestasi olahraga pemuda Pemalang.',
                'target'          => '16 tim dari 14 kecamatan di Kabupaten Pemalang.',
                'location'        => 'GOR Futsal Pemalang, Jl. Olahraga No. 1, Pemalang',
                'budget'          => 35000000,
                'proposal_status' => ProposalStatus::Verified,
                'status'          => ProgramStatus::Running,
                'start_date'      => '2024-01-15',
                'end_date'        => '2024-02-15',
                'verified_by_user'=> $verifier1,
                'verified_at'     => '2024-01-05 08:00:00',
            ],
            [
                'program_code'    => 'PRG-008',
                'org_code'        => 'ORG-008',
                'leader_email'    => 'aulia.rahma@sipora.id',
                'created_by'      => $admin,
                'verified_by'     => $verifier2,
                'category'        => 'Pengabdian Masyarakat',
                'title'           => 'Program Beasiswa dan Bantuan Belajar Anak Kurang Mampu',
                'slug'            => 'program-beasiswa-bantuan-belajar-anak-kurang-mampu',
                'description'     => 'Program pemberian bantuan beasiswa dan bimbingan belajar gratis bagi anak-anak kurang mampu di sekitar wilayah Kabupaten Pemalang.',
                'objective'       => 'Membantu anak-anak dari keluarga kurang mampu untuk tetap mengakses pendidikan yang berkualitas.',
                'target'          => '50 anak usia sekolah dari keluarga tidak mampu di 5 desa.',
                'location'        => 'Balai Desa Maju, Kec. Pemalang dan sekitarnya',
                'budget'          => 25000000,
                'proposal_status' => ProposalStatus::Verified,
                'status'          => ProgramStatus::Running,
                'start_date'      => '2024-01-01',
                'end_date'        => '2024-06-30',
                'verified_by_user'=> $verifier2,
                'verified_at'     => '2023-12-20 10:00:00',
            ],

            // ── 2 Completed ──────────────────────────────────────────
            [
                'program_code'    => 'PRG-009',
                'org_code'        => 'ORG-005',
                'leader_email'    => 'rizki.maulana@sipora.id',
                'created_by'      => $admin,
                'verified_by'     => $verifier1,
                'category'        => 'Pelatihan',
                'title'           => 'Pelatihan Kepemimpinan dan Organisasi Pemuda',
                'slug'            => 'pelatihan-kepemimpinan-organisasi-pemuda',
                'description'     => 'Pelatihan kepemimpinan intensif selama tiga hari untuk mencetak kader pemimpin muda yang berkarakter dan berwawasan kebangsaan.',
                'objective'       => 'Mencetak kader pemuda yang memiliki jiwa kepemimpinan, integritas, dan mampu mengelola organisasi secara profesional.',
                'target'          => '40 pemuda kader organisasi se-Kabupaten Pemalang.',
                'location'        => 'Bumi Perkemahan Guci, Tegal (Kegiatan Outdoor)',
                'budget'          => 32000000,
                'proposal_status' => ProposalStatus::Verified,
                'status'          => ProgramStatus::Completed,
                'start_date'      => '2023-10-20',
                'end_date'        => '2023-10-22',
                'verified_by_user'=> $verifier1,
                'verified_at'     => '2023-10-01 09:00:00',
                'completed_at'    => '2023-10-22 17:00:00',
            ],
            [
                'program_code'    => 'PRG-010',
                'org_code'        => 'ORG-006',
                'leader_email'    => 'dewi.kartika@sipora.id',
                'created_by'      => $admin,
                'verified_by'     => $verifier2,
                'category'        => 'Kompetisi',
                'title'           => 'Kompetisi Inovasi Pemuda Pemalang 2023',
                'slug'            => 'kompetisi-inovasi-pemuda-pemalang-2023',
                'description'     => 'Kompetisi inovasi dan kreativitas pemuda yang menampilkan karya-karya inovatif di bidang teknologi, sosial, lingkungan, dan ekonomi kreatif.',
                'objective'       => 'Mendorong pemuda untuk berinovasi dan menciptakan solusi atas permasalahan nyata di masyarakat.',
                'target'          => '20 tim inovasi pemuda dari seluruh Kabupaten Pemalang.',
                'location'        => 'Gedung Kesenian Pemalang, Jl. Pemuda No. 10, Pemalang',
                'budget'          => 45000000,
                'proposal_status' => ProposalStatus::Verified,
                'status'          => ProgramStatus::Completed,
                'start_date'      => '2023-11-15',
                'end_date'        => '2023-11-17',
                'verified_by_user'=> $verifier2,
                'verified_at'     => '2023-11-01 08:00:00',
                'completed_at'    => '2023-11-17 20:00:00',
            ],
        ];

        foreach ($programs as $p) {
            Program::updateOrCreate(
                ['program_code' => $p['program_code']],
                [
                    'organization_id' => $orgMap[$p['org_code']],
                    'leader_id'       => $users[$p['leader_email']],
                    'category_id'     => $catMap[$p['category']],
                    'created_by'      => $p['created_by'],
                    'verified_by'     => $p['verified_by_user'] ?? null,
                    'program_code'    => $p['program_code'],
                    'title'           => $p['title'],
                    'slug'            => $p['slug'],
                    'description'     => $p['description'],
                    'objective'       => $p['objective'],
                    'target'          => $p['target'],
                    'location'        => $p['location'],
                    'budget'          => $p['budget'],
                    'proposal_file'   => 'proposals/' . strtolower($p['program_code']) . '-proposal.pdf',
                    'proposal_status' => $p['proposal_status'],
                    'status'          => $p['status'],
                    'start_date'      => $p['start_date'],
                    'end_date'        => $p['end_date'],
                    'verified_at'     => $p['verified_at'] ?? null,
                    'completed_at'    => $p['completed_at'] ?? null,
                ]
            );
        }
    }
}