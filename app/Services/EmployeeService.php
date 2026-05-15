<?php

namespace App\Services;

use App\Models\Employee;
use App\Repositories\Contracts\EmployeeRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class EmployeeService
{
    public function __construct(
        protected EmployeeRepositoryInterface $employeeRepository
    ) {}

    public function getAllEmployees(): Collection
    {
        return $this->employeeRepository->all();
    }

    public function getEmployeeById(int $id): ?Employee
    {
        return $this->employeeRepository->findById($id);
    }

    public function getEmployeeByCode(string $code): ?Employee
    {
        return $this->employeeRepository->findByCode($code);
    }

    public function getEmployeesByDepartment(int $departmentId): Collection
    {
        return $this->employeeRepository->findByDepartment($departmentId);
    }

    public function getSubordinates(int $managerId): Collection
    {
        return $this->employeeRepository->findByManager($managerId);
    }

    public function createEmployee(array $data): Employee
    {
        if (!isset($data['employee_code'])) {
            $data['employee_code'] = $this->generateEmployeeCode();
        }
        if (!isset($data['employment_status'])) {
            $data['employment_status'] = 'ACTIVE';
        }
        return $this->employeeRepository->create($data);
    }

    public function updateEmployee(int $id, array $data): Employee
    {
        return $this->employeeRepository->update($id, $data);
    }

    public function deleteEmployee(int $id): bool
    {
        return $this->employeeRepository->delete($id);
    }

    public function getActiveEmployees(): Collection
    {
        return $this->employeeRepository->getActiveEmployees();
    }

    private function generateEmployeeCode(): string
    {
        $lastEmployee = Employee::orderByDesc('id')->first();
        $nextId = $lastEmployee ? $lastEmployee->id + 1 : 1;
        return 'EMP-' . str_pad($nextId, 3, '0', STR_PAD_LEFT);
    }
}
