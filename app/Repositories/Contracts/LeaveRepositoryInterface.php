<?php

namespace App\Repositories\Contracts;

use App\Models\LeaveRequest;
use App\Models\LeaveBalance;
use Illuminate\Database\Eloquent\Collection;

interface LeaveRepositoryInterface
{
    public function getLeaveRequestsByEmployee(int $employeeId): Collection;
    public function getPendingLeaveRequests(): Collection;
    public function getLeaveBalance(int $employeeId, int $leaveTypeId, int $year): ?LeaveBalance;
    public function getAllLeaveBalances(int $employeeId, int $year): Collection;
    public function createLeaveRequest(array $data): LeaveRequest;
    public function updateLeaveRequest(int $id, array $data): LeaveRequest;
    public function approveLeaveRequest(int $id, int $approverId): LeaveRequest;
    public function rejectLeaveRequest(int $id, int $approverId, string $reason): LeaveRequest;
    public function updateLeaveBalance(int $employeeId, int $leaveTypeId, int $year, float $usedDays): LeaveBalance;
    public function initializeLeaveBalance(int $employeeId, int $leaveTypeId, int $year, float $quota): LeaveBalance;
}
