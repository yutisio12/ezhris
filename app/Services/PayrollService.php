<?php

namespace App\Services;

use App\Models\Payroll;
use App\Models\PayrollPeriod;
use App\Models\Employee;
use App\Repositories\Contracts\PayrollRepositoryInterface;
use App\Repositories\Contracts\EmployeeRepositoryInterface;
use App\Repositories\Contracts\AttendanceRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class PayrollService
{
    public function __construct(
        protected PayrollRepositoryInterface $payrollRepository,
        protected EmployeeRepositoryInterface $employeeRepository,
        protected AttendanceRepositoryInterface $attendanceRepository
    ) {}

    public function getPayrollPeriods(): Collection
    {
        return $this->payrollRepository->getPayrollPeriods();
    }

    public function createPeriod(array $data): PayrollPeriod
    {
        $data['status'] = 'OPEN';
        return $this->payrollRepository->createPeriod($data);
    }

    public function generatePayroll(int $periodId): Collection
    {
        $period = $this->payrollRepository->findPeriodById($periodId);
        if (!$period) {
            throw new \Exception("Payroll period not found");
        }
        if ($period->status === 'CLOSED') {
            throw new \Exception("Payroll period is closed");
        }

        $employees = $this->employeeRepository->getActiveEmployees();
        $payrolls = [];

        foreach ($employees as $employee) {
            $payrolls[] = $this->calculateEmployeePayroll($employee, $period);
        }

        return collect($payrolls);
    }

    private function calculateEmployeePayroll(Employee $employee, PayrollPeriod $period): Payroll
    {
        $existing = $this->payrollRepository->findPayroll($period->id, $employee->id);

        $attendances = $this->attendanceRepository->getAttendanceByEmployee(
            $employee->id,
            $period->start_date->format('Y-m-d'),
            $period->end_date->format('Y-m-d')
        );

        $absentDays = $attendances->where('attendance_status', 'ABSENT')->count();
        $overtimeMinutes = $attendances->sum('overtime_minutes');
        $workingDays = $period->start_date->diffInDays($period->end_date) + 1;
        $dailySalary = $employee->basic_salary / max($workingDays, 1);

        $attendanceDeduction = $absentDays * $dailySalary;
        $overtimeAmount = ($overtimeMinutes / 60) * ($dailySalary / 8) * 1.5;
        $grossSalary = $employee->basic_salary - $attendanceDeduction + $overtimeAmount;
        $taxAmount = $grossSalary * 0.05;
        $bpjsAmount = $grossSalary * 0.03;
        $netSalary = $grossSalary - $taxAmount - $bpjsAmount;

        $payrollData = [
            'payroll_period_id' => $period->id,
            'employee_id' => $employee->id,
            'basic_salary' => $employee->basic_salary,
            'attendance_deduction' => $attendanceDeduction,
            'leave_deduction' => 0,
            'overtime_amount' => $overtimeAmount,
            'allowance_amount' => 0,
            'bonus_amount' => 0,
            'tax_amount' => $taxAmount,
            'bpjs_amount' => $bpjsAmount,
            'gross_salary' => $grossSalary,
            'net_salary' => $netSalary,
            'generated_at' => now(),
        ];

        if ($existing) {
            return $this->payrollRepository->updatePayroll($existing->id, $payrollData);
        }
        return $this->payrollRepository->createPayroll($payrollData);
    }

    public function closePeriod(int $periodId): PayrollPeriod
    {
        return $this->payrollRepository->closePeriod($periodId);
    }

    public function getPayrollsByPeriod(int $periodId): Collection
    {
        return $this->payrollRepository->getPayrollsByPeriod($periodId);
    }
}
