<?php

namespace App\Repositories\Contracts;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Collection;

interface EmployeeRepositoryInterface
{
    public function all(): Collection;
    public function findById(int $id): ?Employee;
    public function findByCode(string $code): ?Employee;
    public function findByDepartment(int $departmentId): Collection;
    public function findByManager(int $managerId): Collection;
    public function create(array $data): Employee;
    public function update(int $id, array $data): Employee;
    public function delete(int $id): bool;
    public function getActiveEmployees(): Collection;
}
