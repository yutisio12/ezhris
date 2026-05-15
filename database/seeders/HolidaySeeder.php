<?php

namespace Database\Seeders;

use App\Models\Holiday;
use Illuminate\Database\Seeder;

class HolidaySeeder extends Seeder
{
    public function run(): void
    {
        $holidays = [
            ['holiday_date' => '2026-01-01', 'name' => 'New Year\'s Day', 'is_national' => true],
            ['holiday_date' => '2026-02-17', 'name' => 'Chinese New Year', 'is_national' => true],
            ['holiday_date' => '2026-03-19', 'name' => 'Nyepi (Day of Silence)', 'is_national' => true],
            ['holiday_date' => '2026-04-18', 'name' => 'Good Friday', 'is_national' => true],
            ['holiday_date' => '2026-05-01', 'name' => 'Labor Day', 'is_national' => true],
            ['holiday_date' => '2026-06-01', 'name' => 'Pancasila Day', 'is_national' => true],
            ['holiday_date' => '2026-08-17', 'name' => 'Independence Day', 'is_national' => true],
            ['holiday_date' => '2026-12-25', 'name' => 'Christmas Day', 'is_national' => true],
        ];

        foreach ($holidays as $holiday) {
            Holiday::firstOrCreate(['holiday_date' => $holiday['holiday_date']], $holiday);
        }
    }
}
