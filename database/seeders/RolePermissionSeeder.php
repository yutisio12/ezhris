<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'super_admin', 'description' => 'Super Administrator with full access'],
            ['name' => 'hr_manager', 'description' => 'HR Manager'],
            ['name' => 'hr_staff', 'description' => 'HR Staff'],
            ['name' => 'manager', 'description' => 'Department Manager'],
            ['name' => 'employee', 'description' => 'Employee'],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role['name']], $role);
        }

        $permissions = [
            // Dashboard
            ['code' => 'dashboard.view', 'name' => 'View Dashboard'],
            // Employee Management
            ['code' => 'employee.view', 'name' => 'View Employees'],
            ['code' => 'employee.create', 'name' => 'Create Employee'],
            ['code' => 'employee.edit', 'name' => 'Edit Employee'],
            ['code' => 'employee.delete', 'name' => 'Delete Employee'],
            // Department Management
            ['code' => 'department.view', 'name' => 'View Departments'],
            ['code' => 'department.create', 'name' => 'Create Department'],
            ['code' => 'department.edit', 'name' => 'Edit Department'],
            ['code' => 'department.delete', 'name' => 'Delete Department'],
            // Position Management
            ['code' => 'position.view', 'name' => 'View Positions'],
            ['code' => 'position.create', 'name' => 'Create Position'],
            ['code' => 'position.edit', 'name' => 'Edit Position'],
            ['code' => 'position.delete', 'name' => 'Delete Position'],
            // Attendance
            ['code' => 'attendance.view', 'name' => 'View Attendance'],
            ['code' => 'attendance.create', 'name' => 'Create Attendance'],
            ['code' => 'attendance.edit', 'name' => 'Edit Attendance'],
            ['code' => 'attendance.delete', 'name' => 'Delete Attendance'],
            // Attendance Correction
            ['code' => 'attendance_correction.view', 'name' => 'View Attendance Corrections'],
            ['code' => 'attendance_correction.create', 'name' => 'Create Attendance Correction'],
            ['code' => 'attendance_correction.approve', 'name' => 'Approve Attendance Correction'],
            // Leave
            ['code' => 'leave.view', 'name' => 'View Leave Requests'],
            ['code' => 'leave.create', 'name' => 'Create Leave Request'],
            ['code' => 'leave.approve', 'name' => 'Approve Leave Request'],
            // Overtime
            ['code' => 'overtime.view', 'name' => 'View Overtime Requests'],
            ['code' => 'overtime.create', 'name' => 'Create Overtime Request'],
            ['code' => 'overtime.approve', 'name' => 'Approve Overtime Request'],
            // Payroll
            ['code' => 'payroll.view', 'name' => 'View Payroll'],
            ['code' => 'payroll.create', 'name' => 'Create Payroll'],
            ['code' => 'payroll.process', 'name' => 'Process Payroll'],
            ['code' => 'payroll.lock', 'name' => 'Lock Payroll'],
            // Reimbursement
            ['code' => 'reimbursement.view', 'name' => 'View Reimbursements'],
            ['code' => 'reimbursement.create', 'name' => 'Create Reimbursement'],
            ['code' => 'reimbursement.approve', 'name' => 'Approve Reimbursement'],
            // Report
            ['code' => 'report.view', 'name' => 'View Reports'],
            ['code' => 'report.export', 'name' => 'Export Reports'],
            // Audit Log
            ['code' => 'audit_log.view', 'name' => 'View Audit Logs'],
            // Role & Permission
            ['code' => 'role.view', 'name' => 'View Roles'],
            ['code' => 'role.create', 'name' => 'Create Role'],
            ['code' => 'role.edit', 'name' => 'Edit Role'],
            ['code' => 'role.delete', 'name' => 'Delete Role'],
            // Shift
            ['code' => 'shift.view', 'name' => 'View Shifts'],
            ['code' => 'shift.create', 'name' => 'Create Shift'],
            ['code' => 'shift.edit', 'name' => 'Edit Shift'],
            ['code' => 'shift.delete', 'name' => 'Delete Shift'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['code' => $permission['code']], $permission);
        }

        // Assign all permissions to super_admin
        $superAdmin = Role::where('name', 'super_admin')->first();
        if ($superAdmin) {
            $superAdmin->permissions()->sync(Permission::all()->pluck('id'));
        }

        // Assign HR permissions
        $hrManager = Role::where('name', 'hr_manager')->first();
        if ($hrManager) {
            $hrPermissions = Permission::whereIn('code', [
                'dashboard.view',
                'employee.view', 'employee.create', 'employee.edit',
                'department.view', 'department.create', 'department.edit',
                'position.view', 'position.create', 'position.edit',
                'attendance.view', 'attendance.create', 'attendance.edit',
                'attendance_correction.view', 'attendance_correction.create', 'attendance_correction.approve',
                'leave.view', 'leave.create', 'leave.approve',
                'overtime.view', 'overtime.create', 'overtime.approve',
                'payroll.view', 'payroll.create', 'payroll.process', 'payroll.lock',
                'reimbursement.view', 'reimbursement.create', 'reimbursement.approve',
                'report.view', 'report.export',
                'audit_log.view',
                'shift.view', 'shift.create', 'shift.edit',
            ])->pluck('id');
            $hrManager->permissions()->sync($hrPermissions);
        }

        // Assign Manager permissions
        $manager = Role::where('name', 'manager')->first();
        if ($manager) {
            $managerPermissions = Permission::whereIn('code', [
                'dashboard.view',
                'employee.view',
                'attendance.view',
                'attendance_correction.view', 'attendance_correction.approve',
                'leave.view', 'leave.approve',
                'overtime.view', 'overtime.approve',
                'reimbursement.view', 'reimbursement.approve',
                'report.view',
            ])->pluck('id');
            $manager->permissions()->sync($managerPermissions);
        }

        // Assign Employee permissions
        $employee = Role::where('name', 'employee')->first();
        if ($employee) {
            $employeePermissions = Permission::whereIn('code', [
                'dashboard.view',
                'attendance.view',
                'attendance_correction.view', 'attendance_correction.create',
                'leave.view', 'leave.create',
                'overtime.view', 'overtime.create',
                'reimbursement.view', 'reimbursement.create',
            ])->pluck('id');
            $employee->permissions()->sync($employeePermissions);
        }
    }
}
