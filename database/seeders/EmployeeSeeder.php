<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Position;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        $hrDept = Department::where('code', 'HR')->first();
        $itDept = Department::where('code', 'IT')->first();
        $finDept = Department::where('code', 'FIN')->first();

        $ceoPos = Position::where('code', 'CEO')->first();
        $hrDirPos = Position::where('code', 'HRD')->first();
        $mgrPos = Position::where('code', 'MGR')->first();
        $staffPos = Position::where('code', 'STAFF')->first();

        $superAdminRole = Role::where('name', 'super_admin')->first();
        $hrManagerRole = Role::where('name', 'hr_manager')->first();
        $managerRole = Role::where('name', 'manager')->first();
        $employeeRole = Role::where('name', 'employee')->first();

        // CEO
        $ceo = Employee::firstOrCreate(
            ['employee_code' => 'EMP-001'],
            [
                'full_name' => 'John Doe',
                'email' => 'john.doe@company.com',
                'phone' => '081234567890',
                'gender' => 'Male',
                'birth_place' => 'Jakarta',
                'birth_date' => '1980-01-15',
                'marital_status' => 'Married',
                'religion' => 'Christian',
                'address' => 'Jl. Sudirman No. 1, Jakarta',
                'hire_date' => '2020-01-01',
                'employment_status' => 'ACTIVE',
                'department_id' => $finDept?->id,
                'position_id' => $ceoPos?->id,
                'basic_salary' => 50000000,
                'bank_name' => 'BCA',
                'bank_account_number' => '1234567890',
                'bank_account_name' => 'John Doe',
            ]
        );

        // HR Manager
        $hrManager = Employee::firstOrCreate(
            ['employee_code' => 'EMP-002'],
            [
                'full_name' => 'Jane Smith',
                'email' => 'jane.smith@company.com',
                'phone' => '081234567891',
                'gender' => 'Female',
                'birth_place' => 'Bandung',
                'birth_date' => '1985-05-20',
                'marital_status' => 'Married',
                'religion' => 'Islam',
                'address' => 'Jl. Asia Afrika No. 10, Bandung',
                'hire_date' => '2020-02-01',
                'employment_status' => 'ACTIVE',
                'department_id' => $hrDept?->id,
                'position_id' => $hrDirPos?->id,
                'manager_id' => $ceo->id,
                'basic_salary' => 25000000,
                'bank_name' => 'Mandiri',
                'bank_account_number' => '0987654321',
                'bank_account_name' => 'Jane Smith',
            ]
        );

        // IT Manager
        $itManager = Employee::firstOrCreate(
            ['employee_code' => 'EMP-003'],
            [
                'full_name' => 'Bob Wilson',
                'email' => 'bob.wilson@company.com',
                'phone' => '081234567892',
                'gender' => 'Male',
                'birth_place' => 'Surabaya',
                'birth_date' => '1988-08-10',
                'marital_status' => 'Single',
                'religion' => 'Hindu',
                'address' => 'Jl. Pemuda No. 5, Surabaya',
                'hire_date' => '2020-03-01',
                'employment_status' => 'ACTIVE',
                'department_id' => $itDept?->id,
                'position_id' => $mgrPos?->id,
                'manager_id' => $ceo->id,
                'basic_salary' => 20000000,
                'bank_name' => 'BNI',
                'bank_account_number' => '1122334455',
                'bank_account_name' => 'Bob Wilson',
            ]
        );

        // HR Staff
        $hrStaff = Employee::firstOrCreate(
            ['employee_code' => 'EMP-004'],
            [
                'full_name' => 'Alice Brown',
                'email' => 'alice.brown@company.com',
                'phone' => '081234567893',
                'gender' => 'Female',
                'birth_place' => 'Yogyakarta',
                'birth_date' => '1992-12-25',
                'marital_status' => 'Single',
                'religion' => 'Catholic',
                'address' => 'Jl. Malioboro No. 20, Yogyakarta',
                'hire_date' => '2021-01-15',
                'employment_status' => 'ACTIVE',
                'department_id' => $hrDept?->id,
                'position_id' => $staffPos?->id,
                'manager_id' => $hrManager->id,
                'basic_salary' => 10000000,
                'bank_name' => 'BCA',
                'bank_account_number' => '5566778899',
                'bank_account_name' => 'Alice Brown',
            ]
        );

        // Create users for these employees
        if ($superAdminRole) {
            User::firstOrCreate(
                ['username' => 'admin'],
                [
                    'employee_id' => $ceo->id,
                    'email' => $ceo->email,
                    'password' => Hash::make('password'),
                    'role_id' => $superAdminRole->id,
                    'is_active' => true,
                ]
            );
        }

        if ($hrManagerRole) {
            User::firstOrCreate(
                ['username' => 'hrmanager'],
                [
                    'employee_id' => $hrManager->id,
                    'email' => $hrManager->email,
                    'password' => Hash::make('password'),
                    'role_id' => $hrManagerRole->id,
                    'is_active' => true,
                ]
            );
        }

        if ($managerRole) {
            User::firstOrCreate(
                ['username' => 'itmanager'],
                [
                    'employee_id' => $itManager->id,
                    'email' => $itManager->email,
                    'password' => Hash::make('password'),
                    'role_id' => $managerRole->id,
                    'is_active' => true,
                ]
            );
        }

        if ($employeeRole) {
            User::firstOrCreate(
                ['username' => 'employee'],
                [
                    'employee_id' => $hrStaff->id,
                    'email' => $hrStaff->email,
                    'password' => Hash::make('password'),
                    'role_id' => $employeeRole->id,
                    'is_active' => true,
                ]
            );
        }
    }
}
