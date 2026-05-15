<?php

namespace App\Repositories\Contracts;

use App\Models\Attendance;
use App\Models\AttendanceLog;
use Illuminate\Database\Eloquent\Collection;

interface AttendanceRepositoryInterface
{
    public function getLogsByEmployeeAndDate(int $employeeId, string $date): Collection;
    public function getLogsByDateRange(string $startDate, string $endDate): Collection;
    public function createLog(array $data): AttendanceLog;
    public function findAttendance(int $employeeId, string $date): ?Attendance;
    public function getAttendanceByEmployee(int $employeeId, string $startDate, string $endDate): Collection;
    public function createAttendance(array $data): Attendance;
    public function updateAttendance(int $id, array $data): Attendance;
    public function getUnprocessedLogs(): Collection;
    public function markLogAsProcessed(int $logId): bool;
    public function getIncompleteAttendances(string $date): Collection;
}
