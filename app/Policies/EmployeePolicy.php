<?php

namespace App\Policies;

use App\Models\Employee;
use App\Models\User;

class EmployeePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role?->permissions()->where('code', 'employee.view')->exists() ?? false;
    }

    public function view(User $user, Employee $employee): bool
    {
        return $user->role?->permissions()->where('code', 'employee.view')->exists() ?? false;
    }

    public function create(User $user): bool
    {
        return $user->role?->permissions()->where('code', 'employee.create')->exists() ?? false;
    }

    public function update(User $user, Employee $employee): bool
    {
        return $user->role?->permissions()->where('code', 'employee.edit')->exists() ?? false;
    }

    public function delete(User $user, Employee $employee): bool
    {
        return $user->role?->permissions()->where('code', 'employee.delete')->exists() ?? false;
    }
}
