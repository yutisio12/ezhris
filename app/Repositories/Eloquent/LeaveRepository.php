<?php

namespace App\Repositories\Eloquent;

use App\Models\LeaveRequest;
use App\Models\LeaveBalance;
use App\Repositories\Contracts\LeaveRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class LeaveRepository implements LeaveRepositoryInterface
{
    public function __construct(
        protected LeaveRequest $leaveRequestModel,
        protected LeaveBalance $leaveBalanceModel
    ) {}

    public function getLeaveRequestsByEmployee(int $employeeId): Collection
    {
        return $this->leaveRequestModel
            ->with(['leaveType', 'employee', 'approver'])
            ->where('employee_id', $employeeId)
            ->orderByDesc('requested_at')
            ->get();
    }

    public function getPendingLeaveRequests(): Collection
    {
        return $this->leaveRequestModel
            ->with(['leaveType', 'employee'])
            ->where('status', 'PENDING')
            ->orderBy('requested_at')
            ->get();
    }

    public function getLeaveBalance(int $employeeId, int $leaveTypeId, int $year): ?LeaveBalance
    {
        return $this->leaveBalanceModel
            ->where('employee_id', $employeeId)
            ->where('leave_type_id', $leaveTypeId)
            ->where('year', $year)
            ->first();
    }

    public function getAllLeaveBalances(int $employeeId, int $year): Collection
    {
        return $this->leaveBalanceModel
            ->with('leaveType')
            ->where('employee_id', $employeeId)
            ->where('year', $year)
            ->get();
    }

    public function createLeaveRequest(array $data): LeaveRequest
    {
        return $this->leaveRequestModel->create($data);
    }

    public function updateLeaveRequest(int $id, array $data): LeaveRequest
    {
        $request = $this->leaveRequestModel->findOrFail($id);
        $request->update($data);
        return $request->fresh();
    }

    public function approveLeaveRequest(int $id, int $approverId): LeaveRequest
    {
        $request = $this->leaveRequestModel->findOrFail($id);
        $request->update([
            'status' => 'APPROVED',
            'approved_by' => $approverId,
            'approved_at' => now(),
        ]);
        return $request->fresh();
    }

    public function rejectLeaveRequest(int $id, int $approverId, string $reason): LeaveRequest
    {
        $request = $this->leaveRequestModel->findOrFail($id);
        $request->update([
            'status' => 'REJECTED',
            'approved_by' => $approverId,
            'approved_at' => now(),
            'rejection_reason' => $reason,
        ]);
        return $request->fresh();
    }

    public function updateLeaveBalance(int $employeeId, int $leaveTypeId, int $year, float $usedDays): LeaveBalance
    {
        $balance = $this->getLeaveBalance($employeeId, $leaveTypeId, $year);
        if ($balance) {
            $balance->used_quota += $usedDays;
            $balance->remaining_quota = $balance->total_quota - $balance->used_quota;
            $balance->save();
        }
        return $balance;
    }

    public function initializeLeaveBalance(int $employeeId, int $leaveTypeId, int $year, float $quota): LeaveBalance
    {
        return $this->leaveBalanceModel->create([
            'employee_id' => $employeeId,
            'leave_type_id' => $leaveTypeId,
            'year' => $year,
            'total_quota' => $quota,
            'used_quota' => 0,
            'remaining_quota' => $quota,
        ]);
    }
}
