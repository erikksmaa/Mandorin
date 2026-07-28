<?php

namespace Database\Seeders;

use App\Enums\AttendanceStatus;
use App\Models\Attendance;
use App\Models\Program;
use App\Models\User;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::pluck('id', 'email');

        // program_code => [ date => [ [email, status, check_in, check_out, notes] ] ]
        $data = [
            // PRG-007: Turnamen Futsal (Running) — 3 hari
            'PRG-007' => [
                '2024-01-15' => [
                    ['bagas.saputra@sipora.id',   AttendanceStatus::Present,    '07:30:00', '17:00:00', ''],
                    ['hendra.wijaya@sipora.id',   AttendanceStatus::Present,    '07:45:00', '17:00:00', ''],
                    ['fajar.nugroho@sipora.id',   AttendanceStatus::Present,    '08:00:00', '17:00:00', ''],
                    ['yoga.pratama@sipora.id',    AttendanceStatus::Present,    '07:30:00', '17:00:00', ''],
                    ['aldi.firmansyah@sipora.id', AttendanceStatus::Permission, null,       null,       'Izin ada keperluan keluarga.'],
                    ['intan.permata@sipora.id',   AttendanceStatus::Present,    '08:00:00', '17:00:00', ''],
                ],
                '2024-01-22' => [
                    ['bagas.saputra@sipora.id',   AttendanceStatus::Present,    '07:30:00', '17:00:00', ''],
                    ['hendra.wijaya@sipora.id',   AttendanceStatus::Present,    '07:40:00', '17:00:00', ''],
                    ['fajar.nugroho@sipora.id',   AttendanceStatus::Absent,     null,       null,       'Tidak hadir tanpa keterangan.'],
                    ['yoga.pratama@sipora.id',    AttendanceStatus::Present,    '07:30:00', '17:00:00', ''],
                    ['aldi.firmansyah@sipora.id', AttendanceStatus::Present,    '08:00:00', '17:00:00', ''],
                    ['intan.permata@sipora.id',   AttendanceStatus::Present,    '07:50:00', '17:00:00', ''],
                ],
                '2024-02-05' => [
                    ['bagas.saputra@sipora.id',   AttendanceStatus::Present,    '07:30:00', '17:00:00', ''],
                    ['hendra.wijaya@sipora.id',   AttendanceStatus::Present,    '07:35:00', '17:00:00', ''],
                    ['fajar.nugroho@sipora.id',   AttendanceStatus::Present,    '07:55:00', '17:00:00', ''],
                    ['yoga.pratama@sipora.id',    AttendanceStatus::Permission, null,       null,       'Izin sakit, ada surat dokter.'],
                    ['aldi.firmansyah@sipora.id', AttendanceStatus::Present,    '08:00:00', '17:00:00', ''],
                    ['intan.permata@sipora.id',   AttendanceStatus::Present,    '07:45:00', '17:00:00', ''],
                ],
            ],

            // PRG-008: Beasiswa (Running) — 4 sesi
            'PRG-008' => [
                '2024-01-06' => [
                    ['aulia.rahma@sipora.id',   AttendanceStatus::Present,    '08:00:00', '14:00:00', ''],
                    ['dinda.ayu@sipora.id',     AttendanceStatus::Present,    '08:10:00', '14:00:00', ''],
                    ['nabila.putri@sipora.id',  AttendanceStatus::Present,    '08:00:00', '14:00:00', ''],
                    ['intan.permata@sipora.id', AttendanceStatus::Absent,     null,       null,       'Tidak hadir.'],
                    ['reni.safitri@sipora.id',  AttendanceStatus::Present,    '08:05:00', '14:00:00', ''],
                    ['yoga.pratama@sipora.id',  AttendanceStatus::Present,    '08:00:00', '14:00:00', ''],
                ],
                '2024-01-13' => [
                    ['aulia.rahma@sipora.id',   AttendanceStatus::Present,    '08:00:00', '14:00:00', ''],
                    ['dinda.ayu@sipora.id',     AttendanceStatus::Permission, null,       null,       'Izin urusan kampus.'],
                    ['nabila.putri@sipora.id',  AttendanceStatus::Present,    '08:00:00', '14:00:00', ''],
                    ['intan.permata@sipora.id', AttendanceStatus::Present,    '08:15:00', '14:00:00', ''],
                    ['reni.safitri@sipora.id',  AttendanceStatus::Present,    '08:00:00', '14:00:00', ''],
                    ['yoga.pratama@sipora.id',  AttendanceStatus::Present,    '08:05:00', '14:00:00', ''],
                ],
                '2024-01-20' => [
                    ['aulia.rahma@sipora.id',   AttendanceStatus::Present,    '08:00:00', '14:00:00', ''],
                    ['dinda.ayu@sipora.id',     AttendanceStatus::Present,    '08:00:00', '14:00:00', ''],
                    ['nabila.putri@sipora.id',  AttendanceStatus::Absent,     null,       null,       'Tidak hadir.'],
                    ['intan.permata@sipora.id', AttendanceStatus::Present,    '08:00:00', '14:00:00', ''],
                    ['reni.safitri@sipora.id',  AttendanceStatus::Present,    '08:10:00', '14:00:00', ''],
                    ['yoga.pratama@sipora.id',  AttendanceStatus::Permission, null,       null,       'Izin sakit.'],
                ],
                '2024-01-27' => [
                    ['aulia.rahma@sipora.id',   AttendanceStatus::Present,    '08:00:00', '14:00:00', ''],
                    ['dinda.ayu@sipora.id',     AttendanceStatus::Present,    '08:05:00', '14:00:00', ''],
                    ['nabila.putri@sipora.id',  AttendanceStatus::Present,    '08:00:00', '14:00:00', ''],
                    ['intan.permata@sipora.id', AttendanceStatus::Present,    '08:00:00', '14:00:00', ''],
                    ['reni.safitri@sipora.id',  AttendanceStatus::Present,    '08:00:00', '14:00:00', ''],
                    ['yoga.pratama@sipora.id',  AttendanceStatus::Present,    '08:00:00', '14:00:00', ''],
                ],
            ],

            // PRG-009: Pelatihan Kepemimpinan (Completed) — 3 hari
            'PRG-009' => [
                '2023-10-20' => [
                    ['rizki.maulana@sipora.id',   AttendanceStatus::Present,    '07:00:00', '21:00:00', ''],
                    ['aldi.firmansyah@sipora.id', AttendanceStatus::Present,    '07:10:00', '21:00:00', ''],
                    ['fajar.nugroho@sipora.id',   AttendanceStatus::Present,    '07:00:00', '21:00:00', ''],
                    ['hendra.wijaya@sipora.id',   AttendanceStatus::Present,    '07:05:00', '21:00:00', ''],
                    ['bagas.saputra@sipora.id',   AttendanceStatus::Present,    '07:00:00', '21:00:00', ''],
                    ['dinda.ayu@sipora.id',       AttendanceStatus::Permission, null,       null,       'Izin tidak bisa hadir hari pertama.'],
                ],
                '2023-10-21' => [
                    ['rizki.maulana@sipora.id',   AttendanceStatus::Present,    '06:00:00', '22:00:00', ''],
                    ['aldi.firmansyah@sipora.id', AttendanceStatus::Present,    '06:00:00', '22:00:00', ''],
                    ['fajar.nugroho@sipora.id',   AttendanceStatus::Present,    '06:00:00', '22:00:00', ''],
                    ['hendra.wijaya@sipora.id',   AttendanceStatus::Absent,     null,       null,       'Tidak hadir tanpa keterangan.'],
                    ['bagas.saputra@sipora.id',   AttendanceStatus::Present,    '06:00:00', '22:00:00', ''],
                    ['dinda.ayu@sipora.id',       AttendanceStatus::Present,    '06:00:00', '22:00:00', ''],
                ],
                '2023-10-22' => [
                    ['rizki.maulana@sipora.id',   AttendanceStatus::Present,    '06:00:00', '17:00:00', ''],
                    ['aldi.firmansyah@sipora.id', AttendanceStatus::Present,    '06:00:00', '17:00:00', ''],
                    ['fajar.nugroho@sipora.id',   AttendanceStatus::Present,    '06:00:00', '17:00:00', ''],
                    ['hendra.wijaya@sipora.id',   AttendanceStatus::Present,    '06:00:00', '17:00:00', ''],
                    ['bagas.saputra@sipora.id',   AttendanceStatus::Present,    '06:00:00', '17:00:00', ''],
                    ['dinda.ayu@sipora.id',       AttendanceStatus::Present,    '06:00:00', '17:00:00', ''],
                ],
            ],

            // PRG-010: Kompetisi Inovasi (Completed) — 3 hari
            'PRG-010' => [
                '2023-11-15' => [
                    ['dewi.kartika@sipora.id',  AttendanceStatus::Present,    '08:00:00', '20:00:00', ''],
                    ['aulia.rahma@sipora.id',   AttendanceStatus::Present,    '08:00:00', '20:00:00', ''],
                    ['intan.permata@sipora.id', AttendanceStatus::Present,    '08:05:00', '20:00:00', ''],
                    ['nabila.putri@sipora.id',  AttendanceStatus::Present,    '08:00:00', '20:00:00', ''],
                    ['reni.safitri@sipora.id',  AttendanceStatus::Permission, null,       null,       'Izin keperluan akademik.'],
                    ['yoga.pratama@sipora.id',  AttendanceStatus::Present,    '08:00:00', '20:00:00', ''],
                ],
                '2023-11-16' => [
                    ['dewi.kartika@sipora.id',  AttendanceStatus::Present,    '07:30:00', '20:00:00', ''],
                    ['aulia.rahma@sipora.id',   AttendanceStatus::Present,    '07:30:00', '20:00:00', ''],
                    ['intan.permata@sipora.id', AttendanceStatus::Present,    '07:35:00', '20:00:00', ''],
                    ['nabila.putri@sipora.id',  AttendanceStatus::Absent,     null,       null,       'Tidak hadir.'],
                    ['reni.safitri@sipora.id',  AttendanceStatus::Present,    '07:30:00', '20:00:00', ''],
                    ['yoga.pratama@sipora.id',  AttendanceStatus::Present,    '07:30:00', '20:00:00', ''],
                ],
                '2023-11-17' => [
                    ['dewi.kartika@sipora.id',  AttendanceStatus::Present,    '07:30:00', '21:00:00', ''],
                    ['aulia.rahma@sipora.id',   AttendanceStatus::Present,    '07:30:00', '21:00:00', ''],
                    ['intan.permata@sipora.id', AttendanceStatus::Present,    '07:30:00', '21:00:00', ''],
                    ['nabila.putri@sipora.id',  AttendanceStatus::Present,    '07:40:00', '21:00:00', ''],
                    ['reni.safitri@sipora.id',  AttendanceStatus::Present,    '07:30:00', '21:00:00', ''],
                    ['yoga.pratama@sipora.id',  AttendanceStatus::Present,    '07:30:00', '21:00:00', ''],
                ],
            ],
        ];

        foreach ($data as $programCode => $sessionsByDate) {
            $program = Program::where('program_code', $programCode)->first();
            if (! $program) {
                continue;
            }

            foreach ($sessionsByDate as $date => $attendees) {
                foreach ($attendees as [$email, $status, $checkIn, $checkOut, $notes]) {
                    $userId = $users[$email] ?? null;
                    if (! $userId) {
                        continue;
                    }

                    $existing = Attendance::where('program_id', $program->id)
                        ->where('user_id', $userId)
                        ->whereDate('attendance_date', $date)
                        ->first();

                    $payload = [
                        'check_in'  => $checkIn,
                        'check_out' => $checkOut,
                        'status'    => $status,
                        'notes'     => $notes ?: null,
                    ];

                    if ($existing) {
                        $existing->fill($payload)->save();
                    } else {
                        Attendance::create(array_merge($payload, [
                            'program_id'      => $program->id,
                            'user_id'         => $userId,
                            'attendance_date' => $date,
                        ]));
                    }
                }
            }
        }
    }
}