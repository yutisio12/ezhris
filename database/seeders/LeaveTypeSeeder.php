<?php

namespace Database\Seeders;

use App\Models\LeaveType;
use Illuminate\Database\Seeder;

class LeaveTypeSeeder extends Seeder
{
    public function run(): void
    {
        $leaveTypes = [
            ['code' => 'ANNUAL', 'name' => 'Annual Leave', 'max_days' => 12, 'is_paid' => true],
            ['code' => 'SICK', 'name' => 'Sick Leave', 'max_days' => 30, 'is_paid' => true],
            ['code' => 'MATERNITY', 'name' => 'Maternity Leave', 'max_days' => 90, 'is_paid' => true],
            ['code' => 'PATERNITY', 'name' => 'Paternity Leave', 'max_days' => 3, 'is_paid' => true],
            ['code' => 'MARRIAGE', 'name' => 'Marriage Leave', 'max_days' => 3, 'is_paid' => true],
            ['code' => 'BEREAVEMENT', 'name' => 'Bereavement Leave', 'max_days' => 3, 'is_paid' => true],
            ['code' => 'UNPAID', 'name' => 'Unpaid Leave', 'max_days' => null, 'is_paid' => false],
        ];

        foreach ($leaveTypes as $type) {
            LeaveType::firstOrCreate(['code' => $type['code']], $type);
        }
    }
}
