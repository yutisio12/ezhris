<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    public function run(): void
    {
        $positions = [
            ['code' => 'CEO', 'name' => 'Chief Executive Officer', 'level' => 1],
            ['code' => 'CTO', 'name' => 'Chief Technology Officer', 'level' => 1],
            ['code' => 'CFO', 'name' => 'Chief Financial Officer', 'level' => 1],
            ['code' => 'HRD', 'name' => 'HR Director', 'level' => 2],
            ['code' => 'MGR', 'name' => 'Manager', 'level' => 3],
            ['code' => 'SPV', 'name' => 'Supervisor', 'level' => 4],
            ['code' => 'STAFF', 'name' => 'Staff', 'level' => 5],
            ['code' => 'JR', 'name' => 'Junior Staff', 'level' => 6],
        ];

        foreach ($positions as $pos) {
            Position::firstOrCreate(['code' => $pos['code']], $pos);
        }
    }
}
