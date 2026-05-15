<?php

namespace App\Repositories\Eloquent;

use App\Models\Payroll;
use App\Models\PayrollPeriod;
use App\Repositories\Contracts\PayrollRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class PayrollRepository implements PayrollRepositoryInterface
{
    public function __construct(
        protected Payroll $payrollModel,
        protected PayrollPeriod $periodModel
    ) {}

    public function getPayrollPeriods(): Collection
    {
        return $this->periodModel->orderByDesc('start_date')->get();
    }

    public function findPeriodById(int $id): ?PayrollPeriod
    {
        return $this->periodModel->find($id);
    }

    public function createPeriod(array $data): PayrollPeriod
    {
        return $this->periodModel->create($data);
    }

    public function closePeriod(int $id): PayrollPeriod
    {
        $period = $this->periodModel->findOrFail($id);
        $period->update(['status' => 'CLOSED', 'processed_at' => now()]);
        return $period->fresh();
    }

    public function getPayrollsByPeriod(int $periodId): Collection
    {
        return $this->payrollModel
            ->with(['employee', 'payrollItems'])
            ->where('payroll_period_id', $periodId)
            ->get();
    }

    public function findPayroll(int $periodId, int $employeeId): ?Payroll
    {
        return $this->payrollModel
            ->where('payroll_period_id', $periodId)
            ->where('employee_id', $employeeId)
            ->first();
    }

    public function createPayroll(array $data): Payroll
    {
        return $this->payrollModel->create($data);
    }

    public function updatePayroll(int $id, array $data): Payroll
    {
        $payroll = $this->payrollModel->findOrFail($id);
        $payroll->update($data);
        return $payroll->fresh();
    }

    public function deletePayrollsByPeriod(int $periodId): bool
    {
        return $this->payrollModel->where('payroll_period_id', $periodId)->delete() > 0;
    }
}
