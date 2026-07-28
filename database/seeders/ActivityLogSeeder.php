<?php

namespace Database\Seeders;

use App\Enums\ActivityStatus;
use App\Models\ActivityLog;
use App\Models\Program;
use App\Models\User;
use Illuminate\Database\Seeder;

class ActivityLogSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::pluck('id', 'email');

        // program_code => [ [title, description, activity_date, progress, issues, solutions, status, creator_email] ]
        $data = [
            'PRG-005' => [
                [
                    'title'       => 'Rapat Persiapan Pelatihan Public Speaking',
                    'description' => 'Rapat koordinasi awal seluruh panitia untuk mempersiapkan teknis pelaksanaan pelatihan, mulai dari pembagian tugas, persiapan materi, dan koordinasi dengan narasumber.',
                    'date'        => '2024-02-10',
                    'progress'    => 20,
                    'issues'      => 'Narasumber utama terlambat konfirmasi kehadiran.',
                    'solutions'   => 'Menghubungi narasumber cadangan dan berhasil mendapatkan konfirmasi.',
                    'status'      => ActivityStatus::Approved,
                    'creator'     => 'aulia.rahma@sipora.id',
                ],
                [
                    'title'       => 'Persiapan Teknis dan Gladi Bersih',
                    'description' => 'Pengecekan teknis sound system, proyektor, ruangan, dan gladi bersih rundown acara bersama seluruh panitia dan narasumber.',
                    'date'        => '2024-02-24',
                    'progress'    => 40,
                    'issues'      => 'Proyektor mengalami gangguan teknis saat uji coba.',
                    'solutions'   => 'Meminjam proyektor cadangan dari Dinas.',
                    'status'      => ActivityStatus::Approved,
                    'creator'     => 'aulia.rahma@sipora.id',
                ],
                [
                    'title'       => 'Pelaksanaan Hari Pertama Pelatihan',
                    'description' => 'Pembukaan resmi pelatihan oleh Kepala Bidang Kepemudaan Dindikpora, dilanjutkan materi Dasar-Dasar Public Speaking dan sesi praktik berbicara di depan umum.',
                    'date'        => '2024-02-25',
                    'progress'    => 60,
                    'issues'      => 'Beberapa peserta terlambat hadir karena kendala transportasi.',
                    'solutions'   => 'Peserta yang terlambat diarahkan untuk bergabung di sesi kedua.',
                    'status'      => ActivityStatus::Approved,
                    'creator'     => 'aulia.rahma@sipora.id',
                ],
                [
                    'title'       => 'Pelaksanaan Hari Kedua — Simulasi dan Praktik',
                    'description' => 'Sesi simulasi presentasi oleh seluruh peserta dengan feedback langsung dari narasumber. Peserta berlatih impromptu speech dan structured presentation.',
                    'date'        => '2024-02-26',
                    'progress'    => 80,
                    'issues'      => 'Waktu sesi simulasi kurang karena antusias peserta tinggi.',
                    'solutions'   => 'Waktu istirahat dikurangi 15 menit untuk mengakomodasi semua peserta.',
                    'status'      => ActivityStatus::Approved,
                    'creator'     => 'reni.safitri@sipora.id',
                ],
                [
                    'title'       => 'Evaluasi dan Penutupan Pelatihan',
                    'description' => 'Sesi evaluasi akhir, pengisian kuesioner kepuasan peserta, dan acara penutupan beserta penyerahan sertifikat kepada seluruh peserta yang telah menyelesaikan pelatihan.',
                    'date'        => '2024-02-27',
                    'progress'    => 100,
                    'issues'      => 'Tidak ada kendala berarti.',
                    'solutions'   => '-',
                    'status'      => ActivityStatus::Approved,
                    'creator'     => 'aulia.rahma@sipora.id',
                ],
            ],

            'PRG-006' => [
                [
                    'title'       => 'Koordinasi Panitia dan Sosialisasi Warga',
                    'description' => 'Rapat koordinasi panitia Gerakan Bersih Sungai dan sosialisasi kepada warga sekitar sungai Comal terkait rencana kegiatan dan pentingnya menjaga kebersihan sungai.',
                    'date'        => '2024-02-20',
                    'progress'    => 20,
                    'issues'      => 'Beberapa warga masih kurang antusias mengikuti kegiatan.',
                    'solutions'   => 'Melakukan pendekatan personal dan melibatkan tokoh masyarakat setempat.',
                    'status'      => ActivityStatus::Approved,
                    'creator'     => 'rizki.maulana@sipora.id',
                ],
                [
                    'title'       => 'Persiapan Alat dan Bahan Kebersihan',
                    'description' => 'Pengadaan alat kebersihan seperti karung sampah, sapu, cangkul, dan perlengkapan keselamatan seperti sarung tangan dan sepatu boot untuk seluruh peserta.',
                    'date'        => '2024-03-05',
                    'progress'    => 40,
                    'issues'      => 'Stok karung sampah kurang dari yang direncanakan.',
                    'solutions'   => 'Membeli tambahan karung sampah dari supplier alternatif.',
                    'status'      => ActivityStatus::Approved,
                    'creator'     => 'nabila.putri@sipora.id',
                ],
                [
                    'title'       => 'Pelaksanaan Gerakan Bersih Sungai',
                    'description' => 'Kegiatan bersih sungai Comal sepanjang 2 km melibatkan 60 pemuda dan warga desa. Berhasil mengumpulkan 25 karung sampah dan membersihkan tanaman liar di tepi sungai.',
                    'date'        => '2024-03-10',
                    'progress'    => 90,
                    'issues'      => 'Cuaca panas menyebabkan beberapa peserta kelelahan.',
                    'solutions'   => 'Disediakan pos istirahat dan air minum di beberapa titik sepanjang sungai.',
                    'status'      => ActivityStatus::Approved,
                    'creator'     => 'rizki.maulana@sipora.id',
                ],
                [
                    'title'       => 'Penanaman Pohon dan Edukasi Lingkungan',
                    'description' => 'Penanaman 100 bibit pohon bambu di tepian sungai Comal dan sesi edukasi lingkungan hidup kepada warga dan pemuda tentang pentingnya menjaga ekosistem sungai.',
                    'date'        => '2024-03-10',
                    'progress'    => 100,
                    'issues'      => 'Tidak ada kendala berarti pada sesi penanaman pohon.',
                    'solutions'   => '-',
                    'status'      => ActivityStatus::Approved,
                    'creator'     => 'fajar.nugroho@sipora.id',
                ],
            ],

            'PRG-007' => [
                [
                    'title'       => 'Pembukaan dan Technical Meeting Turnamen',
                    'description' => 'Upacara pembukaan Turnamen Futsal Pemalang Cup 2024 yang dihadiri perwakilan dari seluruh kecamatan, dilanjutkan technical meeting untuk membahas peraturan dan jadwal pertandingan.',
                    'date'        => '2024-01-15',
                    'progress'    => 15,
                    'issues'      => 'Dua tim dari kecamatan terpencil terlambat hadir di technical meeting.',
                    'solutions'   => 'Perwakilan tim yang hadir diberikan ringkasan peraturan secara tertulis.',
                    'status'      => ActivityStatus::Approved,
                    'creator'     => 'bagas.saputra@sipora.id',
                ],
                [
                    'title'       => 'Babak Penyisihan Grup A dan B',
                    'description' => 'Pertandingan babak penyisihan grup A dan B berlangsung dengan total 8 pertandingan. Semua berjalan lancar dengan antusias penonton yang tinggi.',
                    'date'        => '2024-01-22',
                    'progress'    => 35,
                    'issues'      => 'Satu pemain mengalami cedera ringan pada sesi pertandingan sore.',
                    'solutions'   => 'Ditangani langsung oleh petugas medis yang standby di lapangan.',
                    'status'      => ActivityStatus::Approved,
                    'creator'     => 'hendra.wijaya@sipora.id',
                ],
                [
                    'title'       => 'Babak Penyisihan Grup C dan D',
                    'description' => 'Kelanjutan babak penyisihan grup C dan D dengan persaingan yang sengit antar tim. Tim Kecamatan Pemalang Kota menjadi favorit dengan rekor sempurna.',
                    'date'        => '2024-01-29',
                    'progress'    => 50,
                    'issues'      => 'Cuaca hujan sempat mengganggu kondisi lapangan.',
                    'solutions'   => 'Pertandingan ditunda 30 menit dan lapangan dikeringkan.',
                    'status'      => ActivityStatus::Approved,
                    'creator'     => 'bagas.saputra@sipora.id',
                ],
                [
                    'title'       => 'Babak Semifinal Turnamen',
                    'description' => 'Pertandingan semifinal yang sangat sengit mempertemukan empat tim terbaik dari masing-masing grup. Penonton memenuhi GOR Futsal Pemalang.',
                    'date'        => '2024-02-05',
                    'progress'    => 75,
                    'issues'      => 'Kapasitas tribun melebihi estimasi penonton.',
                    'solutions'   => 'Penonton yang tidak mendapat tempat duduk diarahkan ke area berdiri yang aman.',
                    'status'      => ActivityStatus::Approved,
                    'creator'     => 'bagas.saputra@sipora.id',
                ],
                [
                    'title'       => 'Grand Final dan Penutupan Turnamen',
                    'description' => 'Partai grand final yang berlangsung meriah dihadiri Kepala Dinas Dindikpora. Tim Kecamatan Pemalang Kota berhasil menjadi juara diikuti penyerahan piala dan uang pembinaan.',
                    'date'        => '2024-02-15',
                    'progress'    => 100,
                    'issues'      => 'Tidak ada kendala berarti.',
                    'solutions'   => '-',
                    'status'      => ActivityStatus::Approved,
                    'creator'     => 'bagas.saputra@sipora.id',
                ],
            ],

            'PRG-008' => [
                [
                    'title'       => 'Pendataan dan Seleksi Penerima Beasiswa',
                    'description' => 'Proses pendataan calon penerima beasiswa melalui kunjungan ke 5 desa, wawancara dengan orang tua, dan verifikasi kondisi ekonomi keluarga.',
                    'date'        => '2024-01-06',
                    'progress'    => 20,
                    'issues'      => 'Beberapa data administrasi calon penerima tidak lengkap.',
                    'solutions'   => 'Tim relawan membantu melengkapi dokumen administrasi yang diperlukan.',
                    'status'      => ActivityStatus::Approved,
                    'creator'     => 'aulia.rahma@sipora.id',
                ],
                [
                    'title'       => 'Pengumuman dan Serah Terima Beasiswa',
                    'description' => 'Pengumuman resmi penerima beasiswa kepada 50 anak dari keluarga kurang mampu dan serah terima bantuan berupa dana pendidikan, perlengkapan sekolah, dan buku.',
                    'date'        => '2024-01-13',
                    'progress'    => 40,
                    'issues'      => 'Dua orang tua tidak bisa hadir karena bekerja.',
                    'solutions'   => 'Penyerahan dilakukan secara terpisah dengan koordinasi RT setempat.',
                    'status'      => ActivityStatus::Approved,
                    'creator'     => 'dinda.ayu@sipora.id',
                ],
                [
                    'title'       => 'Sesi Bimbingan Belajar Perdana',
                    'description' => 'Pelaksanaan sesi bimbingan belajar pertama yang diikuti oleh 50 anak penerima beasiswa. Materi difokuskan pada mata pelajaran Matematika dan Bahasa Indonesia.',
                    'date'        => '2024-01-20',
                    'progress'    => 55,
                    'issues'      => 'Ruangan bimbingan belajar terlalu kecil untuk 50 anak.',
                    'solutions'   => 'Dibagi menjadi 3 kelompok kecil dengan tutor yang berbeda.',
                    'status'      => ActivityStatus::Approved,
                    'creator'     => 'nabila.putri@sipora.id',
                ],
                [
                    'title'       => 'Monitoring Perkembangan Penerima Beasiswa',
                    'description' => 'Monitoring bulanan terhadap perkembangan belajar 50 anak penerima beasiswa melalui koordinasi dengan wali kelas masing-masing dan laporan nilai semester.',
                    'date'        => '2024-01-27',
                    'progress'    => 70,
                    'issues'      => 'Beberapa anak menunjukkan penurunan semangat belajar.',
                    'solutions'   => 'Dilakukan sesi motivasi dan konseling oleh relawan yang berpengalaman.',
                    'status'      => ActivityStatus::Approved,
                    'creator'     => 'aulia.rahma@sipora.id',
                ],
            ],

            'PRG-009' => [
                [
                    'title'       => 'Briefing Peserta dan Perjalanan ke Lokasi',
                    'description' => 'Briefing umum kepada 40 peserta pelatihan kepemimpinan tentang tata tertib, agenda kegiatan, dan tujuan pelatihan, dilanjutkan perjalanan menuju Bumi Perkemahan Guci, Tegal.',
                    'date'        => '2023-10-20',
                    'progress'    => 20,
                    'issues'      => 'Satu bus mengalami keterlambatan keberangkatan 30 menit.',
                    'solutions'   => 'Jadwal keberangkatan disesuaikan dan peserta diberitahu melalui grup komunikasi.',
                    'status'      => ActivityStatus::Approved,
                    'creator'     => 'rizki.maulana@sipora.id',
                ],
                [
                    'title'       => 'Materi Kepemimpinan dan Dinamika Kelompok',
                    'description' => 'Penyampaian materi kepemimpinan oleh fasilitator berpengalaman, dilanjutkan sesi dinamika kelompok outdoor berupa outbound games yang membangun teamwork dan komunikasi.',
                    'date'        => '2023-10-20',
                    'progress'    => 40,
                    'issues'      => 'Beberapa peserta kurang familiar dengan dinamika kelompok.',
                    'solutions'   => 'Fasilitator memberikan penjelasan lebih detail sebelum setiap sesi.',
                    'status'      => ActivityStatus::Approved,
                    'creator'     => 'aldi.firmansyah@sipora.id',
                ],
                [
                    'title'       => 'Outbound dan Simulasi Kepemimpinan',
                    'description' => 'Kegiatan outbound intensif di alam terbuka dengan simulasi kepemimpinan dalam situasi krisis. Peserta dibagi menjadi tim dan menyelesaikan tantangan kepemimpinan bersama.',
                    'date'        => '2023-10-21',
                    'progress'    => 65,
                    'issues'      => 'Hujan ringan mengganggu sebagian aktivitas outdoor.',
                    'solutions'   => 'Beberapa aktivitas dipindahkan ke dalam tenda serbaguna.',
                    'status'      => ActivityStatus::Approved,
                    'creator'     => 'rizki.maulana@sipora.id',
                ],
                [
                    'title'       => 'Refleksi Malam dan Pembentukan Karakter',
                    'description' => 'Sesi refleksi malam hari berupa api unggun, sharing pengalaman kepemimpinan, dan pembentukan komitmen pemuda untuk berkontribusi nyata bagi masyarakat.',
                    'date'        => '2023-10-21',
                    'progress'    => 80,
                    'issues'      => 'Suhu malam cukup dingin.',
                    'solutions'   => 'Panitia menyediakan perlengkapan hangat tambahan.',
                    'status'      => ActivityStatus::Approved,
                    'creator'     => 'fajar.nugroho@sipora.id',
                ],
                [
                    'title'       => 'Sidang Pleno dan Penutupan Pelatihan',
                    'description' => 'Sidang pleno hasil pelatihan, presentasi rencana aksi masing-masing tim, penyerahan sertifikat kepemimpinan, dan acara penutupan resmi oleh Dinas Dindikpora Pemalang.',
                    'date'        => '2023-10-22',
                    'progress'    => 100,
                    'issues'      => 'Tidak ada kendala pada hari terakhir.',
                    'solutions'   => '-',
                    'status'      => ActivityStatus::Approved,
                    'creator'     => 'rizki.maulana@sipora.id',
                ],
            ],

            'PRG-010' => [
                [
                    'title'       => 'Sosialisasi dan Pendaftaran Peserta Kompetisi',
                    'description' => 'Sosialisasi Kompetisi Inovasi Pemuda Pemalang 2023 melalui media sosial, poster, dan kunjungan ke organisasi kepemudaan. Pendaftaran dilakukan secara online dan offline.',
                    'date'        => '2023-11-01',
                    'progress'    => 15,
                    'issues'      => 'Target pendaftar awal 30 tim, realisasi 20 tim.',
                    'solutions'   => 'Memperpanjang masa pendaftaran dan intensif promosi di media sosial.',
                    'status'      => ActivityStatus::Approved,
                    'creator'     => 'dewi.kartika@sipora.id',
                ],
                [
                    'title'       => 'Seleksi Berkas dan Presentasi Proposal',
                    'description' => 'Proses seleksi berkas 20 tim yang mendaftar oleh dewan juri, dilanjutkan sesi presentasi proposal inovasi kepada juri yang terdiri dari akademisi dan praktisi.',
                    'date'        => '2023-11-10',
                    'progress'    => 35,
                    'issues'      => 'Satu juri tidak bisa hadir karena urusan mendadak.',
                    'solutions'   => 'Digantikan oleh juri cadangan yang sudah disiapkan.',
                    'status'      => ActivityStatus::Approved,
                    'creator'     => 'aulia.rahma@sipora.id',
                ],
                [
                    'title'       => 'Pameran Inovasi Hari Pertama',
                    'description' => 'Pembukaan pameran inovasi pemuda yang menampilkan 20 karya inovatif dari bidang teknologi, sosial, lingkungan, dan ekonomi kreatif. Dibuka oleh Bupati Pemalang.',
                    'date'        => '2023-11-15',
                    'progress'    => 55,
                    'issues'      => 'Stand beberapa peserta belum siap saat pembukaan.',
                    'solutions'   => 'Jadwal pembukaan mundur 20 menit untuk memberi waktu persiapan.',
                    'status'      => ActivityStatus::Approved,
                    'creator'     => 'dewi.kartika@sipora.id',
                ],
                [
                    'title'       => 'Pameran Hari Kedua dan Penilaian Juri',
                    'description' => 'Penilaian akhir oleh dewan juri terhadap seluruh karya inovasi berdasarkan kriteria orisinalitas, dampak sosial, kelayakan implementasi, dan presentasi.',
                    'date'        => '2023-11-16',
                    'progress'    => 80,
                    'issues'      => 'Satu peserta mengalami gangguan teknis pada demonstrasi produk.',
                    'solutions'   => 'Diberikan waktu tambahan 10 menit untuk memperbaiki dan mendemonstrasikan ulang.',
                    'status'      => ActivityStatus::Approved,
                    'creator'     => 'intan.permata@sipora.id',
                ],
                [
                    'title'       => 'Malam Penganugerahan dan Penutupan',
                    'description' => 'Malam penganugerahan Kompetisi Inovasi Pemuda Pemalang 2023 yang meriah, pengumuman pemenang, penyerahan piala dan hadiah uang tunai, serta liputan media lokal.',
                    'date'        => '2023-11-17',
                    'progress'    => 100,
                    'issues'      => 'Tidak ada kendala berarti.',
                    'solutions'   => '-',
                    'status'      => ActivityStatus::Approved,
                    'creator'     => 'dewi.kartika@sipora.id',
                ],
            ],
        ];

        foreach ($data as $programCode => $logs) {
            $program = Program::where('program_code', $programCode)->first();
            if (! $program) {
                continue;
            }

            foreach ($logs as $log) {
                $creatorId = $users[$log['creator']] ?? null;

                ActivityLog::updateOrCreate(
                    ['program_id' => $program->id, 'title' => $log['title']],
                    [
                        'created_by'          => $creatorId,
                        'description'         => $log['description'],
                        'activity_date'       => $log['date'],
                        'progress_percentage' => $log['progress'],
                        'issues'              => $log['issues'],
                        'solutions'           => $log['solutions'],
                        'status'              => $log['status'],
                    ]
                );
            }
        }
    }
}