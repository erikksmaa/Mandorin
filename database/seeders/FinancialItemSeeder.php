<?php

namespace Database\Seeders;

use App\Enums\FinancialType;
use App\Models\FinancialItem;
use App\Models\FinancialReport;
use App\Models\Program;
use Illuminate\Database\Seeder;

class FinancialItemSeeder extends Seeder
{
    public function run(): void
    {
        // program_code => [ [type, description, qty, unit_price, subtotal, date, receipt] ]
        $data = [
            // PRG-003: Workshop Digital Marketing — Submitted
            'PRG-003' => [
                [FinancialType::Income,  'Dana Hibah Dindikpora',              1, 15000000, 15000000, '2024-02-01', 'receipts/prg003-inc1.pdf'],
                [FinancialType::Expense, 'Sewa Coworking Space 2 hari',        1,  4500000,  4500000, '2024-02-15', 'receipts/prg003-exp1.pdf'],
                [FinancialType::Expense, 'Honor Narasumber Digital Marketing',  2,  1500000,  3000000, '2024-02-16', 'receipts/prg003-exp2.pdf'],
                [FinancialType::Expense, 'Snack dan Konsumsi Peserta 2 hari',  40,    50000,  2000000, '2024-02-15', 'receipts/prg003-exp3.pdf'],
                [FinancialType::Expense, 'Spanduk dan Backdrop Kegiatan',       2,   300000,   600000, '2024-02-10', 'receipts/prg003-exp4.pdf'],
                [FinancialType::Expense, 'Modul dan ATK Peserta',              40,    25000,  1000000, '2024-02-12', 'receipts/prg003-exp5.pdf'],
                [FinancialType::Expense, 'Sertifikat Peserta',                 40,    15000,   600000, '2024-02-14', 'receipts/prg003-exp6.pdf'],
                [FinancialType::Expense, 'Dokumentasi Foto dan Video',          1,   750000,   750000, '2024-02-16', 'receipts/prg003-exp7.pdf'],
                [FinancialType::Expense, 'Transportasi Narasumber',             2,   200000,   400000, '2024-02-16', 'receipts/prg003-exp8.pdf'],
                [FinancialType::Expense, 'Biaya Tak Terduga',                   1,   500000,   500000, '2024-02-16', 'receipts/prg003-exp9.pdf'],
            ],

            // PRG-004: Seminar Kepemimpinan — Revision
            'PRG-004' => [
                [FinancialType::Income,  'Dana Hibah Dindikpora',               1, 28000000, 28000000, '2024-02-01', 'receipts/prg004-inc1.pdf'],
                [FinancialType::Expense, 'Sewa Aula Kampus STIE',               1,  5000000,  5000000, '2024-03-20', 'receipts/prg004-exp1.pdf'],
                [FinancialType::Expense, 'Honor Pembicara Utama',               1,  5000000,  5000000, '2024-03-20', 'receipts/prg004-exp2.pdf'],
                [FinancialType::Expense, 'Honor Moderator dan MC',              2,   750000,  1500000, '2024-03-20', 'receipts/prg004-exp3.pdf'],
                [FinancialType::Expense, 'Sound System dan Multimedia',          1,  3000000,  3000000, '2024-03-20', 'receipts/prg004-exp4.pdf'],
                [FinancialType::Expense, 'Konsumsi Peserta 150 orang',         150,   35000,  5250000, '2024-03-20', 'receipts/prg004-exp5.pdf'],
                [FinancialType::Expense, 'Spanduk dan Dekorasi',                 3,   300000,   900000, '2024-03-18', 'receipts/prg004-exp6.pdf'],
                [FinancialType::Expense, 'Seminar Kit (Tas, Buku, Pulpen)',    150,   25000,  3750000, '2024-03-15', 'receipts/prg004-exp7.pdf'],
                [FinancialType::Expense, 'Sertifikat Peserta',                 150,    8000,  1200000, '2024-03-19', 'receipts/prg004-exp8.pdf'],
                [FinancialType::Expense, 'Dokumentasi dan Publikasi',            1,   750000,   750000, '2024-03-20', 'receipts/prg004-exp9.pdf'],
                [FinancialType::Expense, 'Transportasi Pembicara',               1,   350000,   350000, '2024-03-20', 'receipts/prg004-exp10.pdf'],
            ],

            // PRG-005: Pelatihan Public Speaking — Approved
            'PRG-005' => [
                [FinancialType::Income,  'Dana Hibah Dindikpora',               1, 12500000, 12500000, '2024-01-20', 'receipts/prg005-inc1.pdf'],
                [FinancialType::Expense, 'Sewa Aula Gedung Pemuda 3 hari',      3,   600000,  1800000, '2024-02-25', 'receipts/prg005-exp1.pdf'],
                [FinancialType::Expense, 'Honor Narasumber Public Speaking',    1,  3500000,  3500000, '2024-02-27', 'receipts/prg005-exp2.pdf'],
                [FinancialType::Expense, 'Konsumsi Peserta 35 orang 3 hari',   35,   40000,  4200000, '2024-02-25', 'receipts/prg005-exp3.pdf'],
                [FinancialType::Expense, 'Spanduk Kegiatan',                    1,   250000,   250000, '2024-02-22', 'receipts/prg005-exp4.pdf'],
                [FinancialType::Expense, 'Modul Pelatihan',                    35,   15000,   525000, '2024-02-20', 'receipts/prg005-exp5.pdf'],
                [FinancialType::Expense, 'Sertifikat',                         35,   10000,   350000, '2024-02-24', 'receipts/prg005-exp6.pdf'],
                [FinancialType::Expense, 'ATK Peserta',                        35,   10000,   350000, '2024-02-20', 'receipts/prg005-exp7.pdf'],
                [FinancialType::Expense, 'Dokumentasi',                         1,   500000,   500000, '2024-02-27', 'receipts/prg005-exp8.pdf'],
                [FinancialType::Expense, 'Transportasi Narasumber',             1,   275000,   275000, '2024-02-27', 'receipts/prg005-exp9.pdf'],
            ],

            // PRG-006: Gerakan Bersih Sungai — Approved
            'PRG-006' => [
                [FinancialType::Income,  'Dana Hibah Dindikpora',               1,  8500000,  8500000, '2024-02-05', 'receipts/prg006-inc1.pdf'],
                [FinancialType::Expense, 'Alat Kebersihan (Sapu, Cangkul, dll)', 1, 1500000, 1500000, '2024-03-05', 'receipts/prg006-exp1.pdf'],
                [FinancialType::Expense, 'Karung Sampah 200 buah',            200,    3000,   600000, '2024-03-05', 'receipts/prg006-exp2.pdf'],
                [FinancialType::Expense, 'Sarung Tangan dan Sepatu Boot',      60,   20000,  1200000, '2024-03-05', 'receipts/prg006-exp3.pdf'],
                [FinancialType::Expense, 'Bibit Pohon Bambu 100 batang',      100,   12000,  1200000, '2024-03-08', 'receipts/prg006-exp4.pdf'],
                [FinancialType::Expense, 'Konsumsi Relawan dan Warga',         60,   30000,  1800000, '2024-03-10', 'receipts/prg006-exp5.pdf'],
                [FinancialType::Expense, 'Spanduk Kegiatan',                    2,   200000,   400000, '2024-03-07', 'receipts/prg006-exp6.pdf'],
                [FinancialType::Expense, 'Transportasi Angkut Sampah',          1,   700000,   700000, '2024-03-10', 'receipts/prg006-exp7.pdf'],
                [FinancialType::Expense, 'Dokumentasi',                         1,   500000,   500000, '2024-03-10', 'receipts/prg006-exp8.pdf'],
            ],

            // PRG-007: Turnamen Futsal — Submitted
            'PRG-007' => [
                [FinancialType::Income,  'Dana Hibah Dindikpora',               1, 30000000, 30000000, '2023-12-20', 'receipts/prg007-inc1.pdf'],
                [FinancialType::Income,  'Uang Pendaftaran Tim (16 tim)',       16,   300000,  4800000, '2024-01-10', 'receipts/prg007-inc2.pdf'],
                [FinancialType::Income,  'Sponsor Lokal',                        1,   200000,   200000, '2024-01-12', 'receipts/prg007-inc3.pdf'],
                [FinancialType::Expense, 'Sewa GOR Futsal 1 bulan',             1,  8000000,  8000000, '2024-01-15', 'receipts/prg007-exp1.pdf'],
                [FinancialType::Expense, 'Piala Juara 1, 2, 3',                 3,   500000,  1500000, '2024-02-10', 'receipts/prg007-exp2.pdf'],
                [FinancialType::Expense, 'Uang Pembinaan Juara 1',              1,  5000000,  5000000, '2024-02-15', 'receipts/prg007-exp3.pdf'],
                [FinancialType::Expense, 'Uang Pembinaan Juara 2',              1,  3000000,  3000000, '2024-02-15', 'receipts/prg007-exp4.pdf'],
                [FinancialType::Expense, 'Uang Pembinaan Juara 3',              1,  2000000,  2000000, '2024-02-15', 'receipts/prg007-exp5.pdf'],
                [FinancialType::Expense, 'Bola Futsal Resmi',                   4,   350000,  1400000, '2024-01-12', 'receipts/prg007-exp6.pdf'],
                [FinancialType::Expense, 'Wasit 32 pertandingan',              32,   150000,  4800000, '2024-02-15', 'receipts/prg007-exp7.pdf'],
                [FinancialType::Expense, 'Konsumsi Panitia 30 hari',           20,   30000,  1800000, '2024-02-15', 'receipts/prg007-exp8.pdf'],
                [FinancialType::Expense, 'Spanduk dan Backdrop',                4,   350000,  1400000, '2024-01-12', 'receipts/prg007-exp9.pdf'],
                [FinancialType::Expense, 'Dokumentasi dan Streaming',           1,  2000000,  2000000, '2024-02-15', 'receipts/prg007-exp10.pdf'],
                [FinancialType::Expense, 'Petugas Medis',                       1,  1500000,  1500000, '2024-02-15', 'receipts/prg007-exp11.pdf'],
                [FinancialType::Expense, 'ATK dan Administrasi',                1,   600000,   600000, '2024-01-15', 'receipts/prg007-exp12.pdf'],
            ],

            // PRG-009: Pelatihan Kepemimpinan (Completed) — Approved
            'PRG-009' => [
                [FinancialType::Income,  'Dana Hibah Dindikpora',               1, 32000000, 32000000, '2023-10-01', 'receipts/prg009-inc1.pdf'],
                [FinancialType::Expense, 'Sewa Bumi Perkemahan Guci 3 hari',    1,  8000000,  8000000, '2023-10-22', 'receipts/prg009-exp1.pdf'],
                [FinancialType::Expense, 'Transportasi Bus Peserta PP',          2,  3000000,  6000000, '2023-10-22', 'receipts/prg009-exp2.pdf'],
                [FinancialType::Expense, 'Honor Fasilitator',                   2,  2500000,  5000000, '2023-10-22', 'receipts/prg009-exp3.pdf'],
                [FinancialType::Expense, 'Konsumsi Peserta 40 orang 3 hari',   40,   75000,  9000000, '2023-10-22', 'receipts/prg009-exp4.pdf'],
                [FinancialType::Expense, 'Peralatan Outbound',                   1,  1500000,  1500000, '2023-10-18', 'receipts/prg009-exp5.pdf'],
                [FinancialType::Expense, 'Kaos Peserta',                       40,   60000,  2400000, '2023-10-15', 'receipts/prg009-exp6.pdf'],
                [FinancialType::Expense, 'Sertifikat dan Piagam',              40,   15000,   600000, '2023-10-20', 'receipts/prg009-exp7.pdf'],
                [FinancialType::Expense, 'Dokumentasi',                         1,   750000,   750000, '2023-10-22', 'receipts/prg009-exp8.pdf'],
                [FinancialType::Expense, 'ATK dan Modul Pelatihan',            40,   25000,  1000000, '2023-10-18', 'receipts/prg009-exp9.pdf'],
                [FinancialType::Expense, 'Biaya Tak Terduga',                   1,  1500000,  1500000, '2023-10-22', 'receipts/prg009-exp10.pdf'],
            ],

            // PRG-010: Kompetisi Inovasi (Completed) — Approved
            'PRG-010' => [
                [FinancialType::Income,  'Dana Hibah Dindikpora',               1, 40000000, 40000000, '2023-11-01', 'receipts/prg010-inc1.pdf'],
                [FinancialType::Income,  'Sponsor Perusahaan Lokal',            2,  2500000,  5000000, '2023-11-05', 'receipts/prg010-inc2.pdf'],
                [FinancialType::Expense, 'Sewa Gedung Kesenian 3 hari',         3,  3000000,  9000000, '2023-11-17', 'receipts/prg010-exp1.pdf'],
                [FinancialType::Expense, 'Honor Dewan Juri',                    5,  1000000,  5000000, '2023-11-17', 'receipts/prg010-exp2.pdf'],
                [FinancialType::Expense, 'Piala Kejuaraan',                     3,   750000,  2250000, '2023-11-10', 'receipts/prg010-exp3.pdf'],
                [FinancialType::Expense, 'Uang Hadiah Juara 1',                 1,  8000000,  8000000, '2023-11-17', 'receipts/prg010-exp4.pdf'],
                [FinancialType::Expense, 'Uang Hadiah Juara 2',                 1,  5000000,  5000000, '2023-11-17', 'receipts/prg010-exp5.pdf'],
                [FinancialType::Expense, 'Uang Hadiah Juara 3',                 1,  3000000,  3000000, '2023-11-17', 'receipts/prg010-exp6.pdf'],
                [FinancialType::Expense, 'Dekorasi dan Penataan Venue',         1,  2500000,  2500000, '2023-11-13', 'receipts/prg010-exp7.pdf'],
                [FinancialType::Expense, 'Sound System dan Pencahayaan',        1,  3000000,  3000000, '2023-11-15', 'receipts/prg010-exp8.pdf'],
                [FinancialType::Expense, 'Konsumsi Peserta dan Tamu',         200,   25000,  5000000, '2023-11-17', 'receipts/prg010-exp9.pdf'],
                [FinancialType::Expense, 'Dokumentasi dan Liputan Media',       1,  1500000,  1500000, '2023-11-17', 'receipts/prg010-exp10.pdf'],
                [FinancialType::Expense, 'Spanduk, Banner, dan Materi Promosi', 1,  1950000,  1950000, '2023-11-10', 'receipts/prg010-exp11.pdf'],
                [FinancialType::Expense, 'ATK dan Administrasi',                1,  1000000,  1000000, '2023-11-15', 'receipts/prg010-exp12.pdf'],
            ],
        ];

        foreach ($data as $programCode => $items) {
            $program = Program::where('program_code', $programCode)->first();
            if (! $program) {
                continue;
            }

            $report = $program->financialReport;
            if (! $report) {
                continue;
            }

            foreach ($items as [$type, $description, $qty, $unitPrice, $subtotal, $date, $receipt]) {
                FinancialItem::updateOrCreate(
                    [
                        'financial_report_id' => $report->id,
                        'description'         => $description,
                    ],
                    [
                        'type'             => $type,
                        'quantity'         => $qty,
                        'unit_price'       => $unitPrice,
                        'subtotal'         => $subtotal,
                        'transaction_date' => $date,
                        'receipt'          => $receipt,
                    ]
                );
            }
        }
    }
}