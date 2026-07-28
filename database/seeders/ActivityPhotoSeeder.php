<?php

namespace Database\Seeders;

use App\Enums\PhotoType;
use App\Models\ActivityLog;
use App\Models\ActivityPhoto;
use App\Models\Program;
use Illuminate\Database\Seeder;

class ActivityPhotoSeeder extends Seeder
{
    public function run(): void
    {
        // program_code => [ log_title => [ [filename, caption, photo_type], ... ] ]
        $data = [
            'PRG-005' => [
                'Rapat Persiapan Pelatihan Public Speaking' => [
                    ['activities/prg005-log1-1.jpg', 'Suasana rapat koordinasi panitia pelatihan public speaking.',        PhotoType::Before],
                    ['activities/prg005-log1-2.jpg', 'Diskusi pembagian tugas dan jadwal persiapan panitia.',             PhotoType::Documentation],
                ],
                'Persiapan Teknis dan Gladi Bersih' => [
                    ['activities/prg005-log2-1.jpg', 'Pengecekan sound system dan proyektor di ruang pelatihan.',          PhotoType::Before],
                    ['activities/prg005-log2-2.jpg', 'Gladi bersih rundown acara bersama MC dan narasumber.',              PhotoType::Progress],
                    ['activities/prg005-log2-3.jpg', 'Pengaturan layout kursi dan meja peserta pelatihan.',                PhotoType::Documentation],
                ],
                'Pelaksanaan Hari Pertama Pelatihan' => [
                    ['activities/prg005-log3-1.jpg', 'Sambutan pembukaan oleh Kepala Bidang Kepemudaan Dindikpora.',       PhotoType::Before],
                    ['activities/prg005-log3-2.jpg', 'Narasumber menyampaikan materi dasar public speaking.',              PhotoType::Progress],
                    ['activities/prg005-log3-3.jpg', 'Peserta antusias mengikuti sesi materi public speaking.',            PhotoType::Progress],
                    ['activities/prg005-log3-4.jpg', 'Foto bersama peserta dan narasumber di akhir sesi pertama.',         PhotoType::Documentation],
                ],
                'Pelaksanaan Hari Kedua — Simulasi dan Praktik' => [
                    ['activities/prg005-log4-1.jpg', 'Peserta tampil mempraktikkan public speaking di depan rekan.',       PhotoType::Progress],
                    ['activities/prg005-log4-2.jpg', 'Sesi umpan balik narasumber kepada peserta yang tampil.',            PhotoType::Progress],
                    ['activities/prg005-log4-3.jpg', 'Kelompok peserta berdiskusi mempersiapkan impromptu speech.',        PhotoType::Documentation],
                ],
                'Evaluasi dan Penutupan Pelatihan' => [
                    ['activities/prg005-log5-1.jpg', 'Peserta mengisi kuesioner evaluasi akhir pelatihan.',                PhotoType::Progress],
                    ['activities/prg005-log5-2.jpg', 'Penyerahan sertifikat kepada peserta oleh Ketua Pelaksana.',         PhotoType::After],
                    ['activities/prg005-log5-3.jpg', 'Foto bersama seluruh peserta dan panitia pelatihan public speaking.', PhotoType::After],
                ],
            ],
            'PRG-006' => [
                'Koordinasi Panitia dan Sosialisasi Warga' => [
                    ['activities/prg006-log1-1.jpg', 'Rapat koordinasi panitia gerakan bersih sungai Comal.',              PhotoType::Before],
                    ['activities/prg006-log1-2.jpg', 'Sosialisasi kepada warga desa di balai desa setempat.',              PhotoType::Documentation],
                ],
                'Persiapan Alat dan Bahan Kebersihan' => [
                    ['activities/prg006-log2-1.jpg', 'Pengambilan alat kebersihan dari gudang penyimpanan.',               PhotoType::Before],
                    ['activities/prg006-log2-2.jpg', 'Distribusi karung sampah, sarung tangan, dan sepatu boot.',          PhotoType::Progress],
                ],
                'Pelaksanaan Gerakan Bersih Sungai' => [
                    ['activities/prg006-log3-1.jpg', 'Kondisi sungai Comal sebelum kegiatan bersih-bersih dimulai.',       PhotoType::Before],
                    ['activities/prg006-log3-2.jpg', 'Pemuda dan warga bergotong royong membersihkan tepi sungai.',        PhotoType::Progress],
                    ['activities/prg006-log3-3.jpg', 'Pengangkatan sampah dari dalam sungai menggunakan alat bantu.',      PhotoType::Progress],
                    ['activities/prg006-log3-4.jpg', 'Kondisi sungai setelah kegiatan bersih-bersih selesai.',             PhotoType::After],
                ],
                'Penanaman Pohon dan Edukasi Lingkungan' => [
                    ['activities/prg006-log4-1.jpg', 'Proses penanaman bibit pohon bambu di tepian sungai Comal.',         PhotoType::Progress],
                    ['activities/prg006-log4-2.jpg', 'Sesi edukasi lingkungan kepada warga dan pemuda peserta.',           PhotoType::Documentation],
                    ['activities/prg006-log4-3.jpg', 'Foto bersama seluruh peserta dengan latar sungai yang bersih.',      PhotoType::After],
                ],
            ],
            'PRG-007' => [
                'Pembukaan dan Technical Meeting Turnamen' => [
                    ['activities/prg007-log1-1.jpg', 'Persiapan GOR Futsal Pemalang sebelum pembukaan turnamen.',          PhotoType::Before],
                    ['activities/prg007-log1-2.jpg', 'Upacara pembukaan Turnamen Futsal Pemalang Cup 2024.',               PhotoType::Progress],
                    ['activities/prg007-log1-3.jpg', 'Sesi technical meeting seluruh perwakilan tim peserta.',             PhotoType::Documentation],
                ],
                'Babak Penyisihan Grup A dan B' => [
                    ['activities/prg007-log2-1.jpg', 'Pertandingan babak penyisihan grup A berlangsung sengit.',           PhotoType::Progress],
                    ['activities/prg007-log2-2.jpg', 'Suporter dari berbagai kecamatan memenuhi tribun GOR.',              PhotoType::Documentation],
                    ['activities/prg007-log2-3.jpg', 'Petugas medis menangani pemain yang mengalami cedera ringan.',       PhotoType::Documentation],
                ],
                'Babak Penyisihan Grup C dan D' => [
                    ['activities/prg007-log3-1.jpg', 'Tim Kecamatan Pemalang Kota beraksi di babak penyisihan.',           PhotoType::Progress],
                    ['activities/prg007-log3-2.jpg', 'Suasana pertandingan grup D yang berjalan kompetitif.',              PhotoType::Progress],
                ],
                'Babak Semifinal Turnamen' => [
                    ['activities/prg007-log4-1.jpg', 'Pertandingan semifinal pertama yang berlangsung sangat sengit.',     PhotoType::Progress],
                    ['activities/prg007-log4-2.jpg', 'Ekspresi kegembiraan tim pemenang semifinal.',                       PhotoType::Progress],
                    ['activities/prg007-log4-3.jpg', 'Penonton memadati seluruh tribun GOR Futsal Pemalang.',              PhotoType::Documentation],
                ],
                'Grand Final dan Penutupan Turnamen' => [
                    ['activities/prg007-log5-1.jpg', 'Momen grand final yang dinantikan seluruh penonton.',                PhotoType::Progress],
                    ['activities/prg007-log5-2.jpg', 'Penyerahan piala juara oleh Kepala Dinas Dindikpora.',              PhotoType::After],
                    ['activities/prg007-log5-3.jpg', 'Foto bersama seluruh panitia, juri, dan tim finalis.',              PhotoType::After],
                    ['activities/prg007-log5-4.jpg', 'Selebrasi tim juara Kecamatan Pemalang Kota.',                      PhotoType::After],
                ],
            ],
            'PRG-008' => [
                'Pendataan dan Seleksi Penerima Beasiswa' => [
                    ['activities/prg008-log1-1.jpg', 'Tim relawan melakukan pendataan ke rumah calon penerima.',           PhotoType::Before],
                    ['activities/prg008-log1-2.jpg', 'Proses wawancara dengan orang tua calon penerima beasiswa.',         PhotoType::Progress],
                    ['activities/prg008-log1-3.jpg', 'Verifikasi kelengkapan dokumen administrasi penerima.',              PhotoType::Documentation],
                ],
                'Pengumuman dan Serah Terima Beasiswa' => [
                    ['activities/prg008-log2-1.jpg', 'Persiapan perlengkapan sekolah yang akan diserahkan.',               PhotoType::Before],
                    ['activities/prg008-log2-2.jpg', 'Serah terima bantuan beasiswa kepada penerima terpilih.',            PhotoType::Progress],
                    ['activities/prg008-log2-3.jpg', 'Ekspresi bahagia anak-anak penerima beasiswa saat pengumuman.',      PhotoType::After],
                ],
                'Sesi Bimbingan Belajar Perdana' => [
                    ['activities/prg008-log3-1.jpg', 'Persiapan ruangan bimbingan belajar oleh tim relawan.',              PhotoType::Before],
                    ['activities/prg008-log3-2.jpg', 'Sesi bimbingan belajar Matematika kelompok pertama.',                PhotoType::Progress],
                    ['activities/prg008-log3-3.jpg', 'Anak-anak antusias mengerjakan soal bersama tutor.',                 PhotoType::Progress],
                    ['activities/prg008-log3-4.jpg', 'Foto bersama anak-anak penerima beasiswa di sesi bimbel perdana.',  PhotoType::Documentation],
                ],
                'Monitoring Perkembangan Penerima Beasiswa' => [
                    ['activities/prg008-log4-1.jpg', 'Tim relawan mengunjungi sekolah penerima beasiswa.',                 PhotoType::Progress],
                    ['activities/prg008-log4-2.jpg', 'Koordinasi dengan wali kelas tentang perkembangan belajar.',         PhotoType::Documentation],
                ],
            ],
            'PRG-009' => [
                'Briefing Peserta dan Perjalanan ke Lokasi' => [
                    ['activities/prg009-log1-1.jpg', 'Peserta berkumpul di titik keberangkatan sebelum berangkat.',        PhotoType::Before],
                    ['activities/prg009-log1-2.jpg', 'Briefing umum peserta pelatihan kepemimpinan oleh panitia.',         PhotoType::Progress],
                ],
                'Materi Kepemimpinan dan Dinamika Kelompok' => [
                    ['activities/prg009-log2-1.jpg', 'Fasilitator menyampaikan materi kepemimpinan kepada peserta.',       PhotoType::Progress],
                    ['activities/prg009-log2-2.jpg', 'Peserta aktif berdiskusi dalam sesi dinamika kelompok.',             PhotoType::Progress],
                    ['activities/prg009-log2-3.jpg', 'Simulasi game kepemimpinan di ruangan pelatihan.',                   PhotoType::Documentation],
                ],
                'Outbound dan Simulasi Kepemimpinan' => [
                    ['activities/prg009-log3-1.jpg', 'Peserta melakukan outbound di area Bumi Perkemahan Guci.',           PhotoType::Progress],
                    ['activities/prg009-log3-2.jpg', 'Tantangan jembatan tali yang menguji keberanian dan teamwork.',      PhotoType::Progress],
                    ['activities/prg009-log3-3.jpg', 'Tim peserta bekerja sama dalam simulasi kepemimpinan krisis.',       PhotoType::Progress],
                    ['activities/prg009-log3-4.jpg', 'Evaluasi hasil outbound bersama fasilitator.',                       PhotoType::Documentation],
                ],
                'Refleksi Malam dan Pembentukan Karakter' => [
                    ['activities/prg009-log4-1.jpg', 'Suasana khidmat sesi refleksi malam di api unggun.',                 PhotoType::Progress],
                    ['activities/prg009-log4-2.jpg', 'Peserta berbagi pengalaman kepemimpinan di sekitar api unggun.',     PhotoType::Documentation],
                ],
                'Sidang Pleno dan Penutupan Pelatihan' => [
                    ['activities/prg009-log5-1.jpg', 'Presentasi rencana aksi oleh masing-masing tim peserta.',            PhotoType::Progress],
                    ['activities/prg009-log5-2.jpg', 'Penyerahan sertifikat kepemimpinan kepada peserta.',                 PhotoType::After],
                    ['activities/prg009-log5-3.jpg', 'Foto bersama seluruh peserta dan panitia pelatihan kepemimpinan.',   PhotoType::After],
                ],
            ],
            'PRG-010' => [
                'Sosialisasi dan Pendaftaran Peserta Kompetisi' => [
                    ['activities/prg010-log1-1.jpg', 'Penyebaran poster kompetisi inovasi di media sosial dan fisik.',     PhotoType::Before],
                    ['activities/prg010-log1-2.jpg', 'Tim panitia mempersiapkan booth pendaftaran peserta.',               PhotoType::Documentation],
                ],
                'Seleksi Berkas dan Presentasi Proposal' => [
                    ['activities/prg010-log2-1.jpg', 'Dewan juri mengevaluasi berkas proposal inovasi peserta.',           PhotoType::Progress],
                    ['activities/prg010-log2-2.jpg', 'Tim peserta mempresentasikan proposal di hadapan juri.',             PhotoType::Progress],
                    ['activities/prg010-log2-3.jpg', 'Sesi tanya jawab antara juri dan tim peserta inovasi.',              PhotoType::Documentation],
                ],
                'Pameran Inovasi Hari Pertama' => [
                    ['activities/prg010-log3-1.jpg', 'Persiapan stand pameran inovasi sebelum pembukaan.',                 PhotoType::Before],
                    ['activities/prg010-log3-2.jpg', 'Pembukaan pameran oleh Bupati Pemalang dan Kepala Dinas.',           PhotoType::Progress],
                    ['activities/prg010-log3-3.jpg', 'Pengunjung antusias melihat karya inovasi peserta.',                 PhotoType::Progress],
                    ['activities/prg010-log3-4.jpg', 'Demo produk inovasi teknologi oleh tim peserta.',                    PhotoType::Documentation],
                ],
                'Pameran Hari Kedua dan Penilaian Juri' => [
                    ['activities/prg010-log4-1.jpg', 'Juri melakukan penilaian akhir terhadap setiap stand inovasi.',      PhotoType::Progress],
                    ['activities/prg010-log4-2.jpg', 'Peserta menjelaskan konsep inovasi kepada dewan juri.',              PhotoType::Progress],
                    ['activities/prg010-log4-3.jpg', 'Proses demonstrasi ulang produk setelah perbaikan teknis.',          PhotoType::Documentation],
                ],
                'Malam Penganugerahan dan Penutupan' => [
                    ['activities/prg010-log5-1.jpg', 'Persiapan malam penganugerahan Kompetisi Inovasi Pemuda 2023.',      PhotoType::Before],
                    ['activities/prg010-log5-2.jpg', 'Pengumuman pemenang kompetisi inovasi oleh Ketua Dewan Juri.',       PhotoType::Progress],
                    ['activities/prg010-log5-3.jpg', 'Penyerahan piala dan hadiah kepada juara pertama.',                  PhotoType::After],
                    ['activities/prg010-log5-4.jpg', 'Foto bersama seluruh peserta, juri, dan panitia kompetisi.',         PhotoType::After],
                ],
            ],
        ];

        foreach ($data as $programCode => $logsWithPhotos) {
            $program = Program::where('program_code', $programCode)->first();
            if (! $program) {
                continue;
            }

            foreach ($logsWithPhotos as $logTitle => $photos) {
                $log = ActivityLog::where('program_id', $program->id)
                    ->where('title', $logTitle)
                    ->first();

                if (! $log) {
                    continue;
                }

                foreach ($photos as [$filename, $caption, $photoType]) {
                    ActivityPhoto::updateOrCreate(
                        ['activity_log_id' => $log->id, 'photo' => $filename],
                        ['caption' => $caption, 'photo_type' => $photoType]
                    );
                }
            }
        }
    }
}