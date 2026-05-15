<?php

namespace App\Repositories\Eloquent;

use App\Models\Employee;
use App\Repositories\Contracts\EmployeeRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class EmployeeRepository implements EmployeeRepositoryInterface
{
    public function __construct(protected Employee $model) {}

    public function all(): Collection
    {
        return $this->model->with(['department', 'position', 'manager'])->get();
    }

    public function findById(int $id): ?Employee
    {
        return $this->model->with(['department', 'position', 'manager', 'user'])->find($id);
    }

    public function findByCode(string $code): ?Employee
    {
        return $this->model->where('employee_code', $code)->first();
    }

    public function findByDepartment(int $departmentId): Collection
    {
        return $this->model->where('department_id', $departmentId)->get();
    }

    public function findByManager(int $managerId): Collection
    {
        return $this->model->where('manager_id', $managerId)->get();
    }

    public function create(array $data): Employee
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): Employee
    {
        $employee = $this->model->findOrFail($id);
        $employee->update($data);
        return $employee->fresh();
    }

    public function delete(int $id): bool
    {
        return $this->model->destroy($id) > 0;
    }

    public function getActiveEmployees(): Collection
    {
        return $this->model->where('employment_status', 'ACTIVE')->get();
    }
}
