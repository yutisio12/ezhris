<?php

namespace Database\Seeders;

use App\Models\ShiftTemplate;
use Illuminate\Database\Seeder;

class ShiftTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $shifts = [
            [
                'name' => 'Regular Morning',
                'check_in_time' => '08:00:00',
                'check_out_time' => '17:00:00',
                'break_start' => '12:00:00',
                'break_end' => '13:00:00',
                'late_tolerance_minutes' => 15,
                'is_flexible' => false,
            ],
            [
                'name' => 'Regular Afternoon',
                'check_in_time' => '13:00:00',
                'check_out_time' => '22:00:00',
                'break_start' => '17:00:00',
                'break_end' => '18:00:00',
                'late_tolerance_minutes' => 15,
                'is_flexible' => false,
            ],
            [
                'name' => 'Night Shift',
                'check_in_time' => '22:00:00',
                'check_out_time' => '07:00:00',
                'break_start' => '02:00:00',
                'break_end' => '03:00:00',
                'late_tolerance_minutes' => 15,
                'is_flexible' => false,
            ],
            [
                'name' => 'Flexible',
                'check_in_time' => '09:00:00',
                'check_out_time' => '18:00:00',
                'break_start' => null,
                'break_end' => null,
                'late_tolerance_minutes' => 30,
                'is_flexible' => true,
            ],
        ];

        foreach ($shifts as $shift) {
            ShiftTemplate::firstOrCreate(['name' => $shift['name']], $shift);
        }
    }
}
