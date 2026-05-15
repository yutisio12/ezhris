<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            ['code' => 'HR', 'name' => 'Human Resources', 'description' => 'Human Resources Department'],
            ['code' => 'IT', 'name' => 'Information Technology', 'description' => 'IT Department'],
            ['code' => 'FIN', 'name' => 'Finance', 'description' => 'Finance Department'],
            ['code' => 'MKT', 'name' => 'Marketing', 'description' => 'Marketing Department'],
            ['code' => 'OPS', 'name' => 'Operations', 'description' => 'Operations Department'],
            ['code' => 'LEG', 'name' => 'Legal', 'description' => 'Legal Department'],
            ['code' => 'RND', 'name' => 'Research & Development', 'description' => 'R&D Department'],
        ];

        foreach ($departments as $dept) {
            Department::firstOrCreate(['code' => $dept['code']], $dept);
        }
    }
}
