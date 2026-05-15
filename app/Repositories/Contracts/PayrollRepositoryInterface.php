<?php

namespace App\Repositories\Contracts;

use App\Models\Payroll;
use App\Models\PayrollPeriod;
use Illuminate\Database\Eloquent\Collection;

interface PayrollRepositoryInterface
{
    public function getPayrollPeriods(): Collection;
    public function findPeriodById(int $id): ?PayrollPeriod;
    public function createPeriod(array $data): PayrollPeriod;
    public function closePeriod(int $id): PayrollPeriod;
    public function getPayrollsByPeriod(int $periodId): Collection;
    public function findPayroll(int $periodId, int $employeeId): ?Payroll;
    public function createPayroll(array $data): Payroll;
    public function updatePayroll(int $id, array $data): Payroll;
    public function deletePayrollsByPeriod(int $periodId): bool;
}
