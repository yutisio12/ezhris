<?php

namespace App\Services;

use App\Models\LeaveRequest;
use App\Models\LeaveType;
use App\Repositories\Contracts\LeaveRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class LeaveService
{
    public function __construct(
        protected LeaveRepositoryInterface $leaveRepository
    ) {}

    public function getLeaveRequestsByEmployee(int $employeeId): Collection
    {
        return $this->leaveRepository->getLeaveRequestsByEmployee($employeeId);
    }

    public function getPendingLeaveRequests(): Collection
    {
        return $this->leaveRepository->getPendingLeaveRequests();
    }

    public function getLeaveBalances(int $employeeId, int $year): Collection
    {
        return $this->leaveRepository->getAllLeaveBalances($employeeId, $year);
    }

    public function createLeaveRequest(array $data): LeaveRequest
    {
        $startDate = Carbon::parse($data['start_date']);
        $endDate = Carbon::parse($data['end_date']);
        $data['total_days'] = $startDate->diffInDays($endDate) + 1;
        $data['status'] = 'PENDING';
        $data['requested_at'] = now();

        $this->validateLeaveBalance($data['employee_id'], $data['leave_type_id'], $data['total_days']);

        return $this->leaveRepository->createLeaveRequest($data);
    }

    public function approveLeaveRequest(int $id, int $approverId): LeaveRequest
    {
        $request = $this->leaveRepository->approveLeaveRequest($id, $approverId);
        $this->leaveRepository->updateLeaveBalance(
            $request->employee_id,
            $request->leave_type_id,
            Carbon::parse($request->start_date)->year,
            $request->total_days
        );
        return $request;
    }

    public function rejectLeaveRequest(int $id, int $approverId, string $reason): LeaveRequest
    {
        return $this->leaveRepository->rejectLeaveRequest($id, $approverId, $reason);
    }

    public function initializeLeaveBalances(int $employeeId, int $year): void
    {
        $leaveTypes = LeaveType::all();
        foreach ($leaveTypes as $type) {
            $existing = $this->leaveRepository->getLeaveBalance($employeeId, $type->id, $year);
            if (!$existing && $type->max_days) {
                $this->leaveRepository->initializeLeaveBalance($employeeId, $type->id, $year, $type->max_days);
            }
        }
    }

    private function validateLeaveBalance(int $employeeId, int $leaveTypeId, float $requestedDays): void
    {
        $year = now()->year;
        $balance = $this->leaveRepository->getLeaveBalance($employeeId, $leaveTypeId, $year);
        if ($balance && $balance->remaining_quota < $requestedDays) {
            throw new \Exception("Insufficient leave balance. Remaining: {$balance->remaining_quota} days, Requested: {$requestedDays} days");
        }
    }
}
