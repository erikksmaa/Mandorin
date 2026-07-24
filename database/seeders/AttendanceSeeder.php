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
        $programs = Program::query()->get();
        $users = User::query()->whereIn('email', ['leader@sipora.id', 'member@sipora.id'])->get();

        foreach ($programs as $index => $program) {
            $user = $users->get($index) ?? $users->first();

            if (! $user) {
                continue;
            }

            $attendance = Attendance::where('program_id', $program->id)
                ->where('user_id', $user->id)
                ->whereDate('attendance_date', now()->toDateString())
                ->first();

            if ($attendance) {
                $attendance->fill([
                    'check_in' => '08:00:00',
                    'check_out' => '16:00:00',
                    'status' => AttendanceStatus::Present->value,
                    'notes' => 'Kehadiran berhasil tercatat.',
                ])->save();
            } else {
                Attendance::create([
                    'program_id' => $program->id,
                    'user_id' => $user->id,
                    'attendance_date' => now()->toDateString(),
                    'check_in' => '08:00:00',
                    'check_out' => '16:00:00',
                    'status' => AttendanceStatus::Present->value,
                    'notes' => 'Kehadiran berhasil tercatat.',
                ]);
            }
        }
    }
}
