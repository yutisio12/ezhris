<?php

namespace App\Repositories\Eloquent;

use App\Models\Attendance;
use App\Models\AttendanceLog;
use App\Repositories\Contracts\AttendanceRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class AttendanceRepository implements AttendanceRepositoryInterface
{
    public function __construct(
        protected Attendance $attendanceModel,
        protected AttendanceLog $logModel
    ) {}

    public function getLogsByEmployeeAndDate(int $employeeId, string $date): Collection
    {
        return $this->logModel
            ->where('employee_id', $employeeId)
            ->whereDate('log_time', $date)
            ->orderBy('log_time')
            ->get();
    }

    public function getLogsByDateRange(string $startDate, string $endDate): Collection
    {
        return $this->logModel
            ->whereBetween('log_time', [$startDate, $endDate])
            ->orderBy('log_time')
            ->get();
    }

    public function createLog(array $data): AttendanceLog
    {
        return $this->logModel->create($data);
    }

    public function findAttendance(int $employeeId, string $date): ?Attendance
    {
        return $this->attendanceModel
            ->where('employee_id', $employeeId)
            ->where('attendance_date', $date)
            ->first();
    }

    public function getAttendanceByEmployee(int $employeeId, string $startDate, string $endDate): Collection
    {
        return $this->attendanceModel
            ->where('employee_id', $employeeId)
            ->whereBetween('attendance_date', [$startDate, $endDate])
            ->orderBy('attendance_date')
            ->get();
    }

    public function createAttendance(array $data): Attendance
    {
        return $this->attendanceModel->create($data);
    }

    public function updateAttendance(int $id, array $data): Attendance
    {
        $attendance = $this->attendanceModel->findOrFail($id);
        $attendance->update($data);
        return $attendance->fresh();
    }

    public function getUnprocessedLogs(): Collection
    {
        return $this->logModel->where('is_processed', false)->get();
    }

    public function markLogAsProcessed(int $logId): bool
    {
        return $this->logModel->where('id', $logId)->update(['is_processed' => true]);
    }

    public function getIncompleteAttendances(string $date): Collection
    {
        return $this->attendanceModel
            ->where('attendance_date', $date)
            ->where('attendance_status', 'INCOMPLETE')
            ->get();
    }
}
