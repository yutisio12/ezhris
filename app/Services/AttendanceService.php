<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\AttendanceLog;
use App\Models\Employee;
use App\Models\Holiday;
use App\Repositories\Contracts\AttendanceRepositoryInterface;
use App\Repositories\Contracts\EmployeeRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class AttendanceService
{
    public function __construct(
        protected AttendanceRepositoryInterface $attendanceRepository,
        protected EmployeeRepositoryInterface $employeeRepository
    ) {}

    public function logAttendance(array $data): AttendanceLog
    {
        return $this->attendanceRepository->createLog($data);
    }

    public function processDailyAttendance(string $date): void
    {
        $employees = $this->employeeRepository->getActiveEmployees();
        foreach ($employees as $employee) {
            $this->processEmployeeAttendance($employee, $date);
        }
    }

    public function processEmployeeAttendance(Employee $employee, string $date): Attendance
    {
        $logs = $this->attendanceRepository->getLogsByEmployeeAndDate($employee->id, $date);
        $existing = $this->attendanceRepository->findAttendance($employee->id, $date);

        $shift = $employee->shiftTemplates()
            ->where('shift_date', $date)
            ->with('shiftTemplate')
            ->first();
        $shiftTemplate = $shift?->shiftTemplate;

        $checkIn = $logs->where('log_type', 'IN')->first();
        $checkOut = $logs->where('log_type', 'OUT')->sortByDesc('log_time')->first();

        $status = $this->determineStatus($employee, $date, $checkIn, $checkOut);
        $lateMinutes = 0;
        $workMinutes = 0;

        if ($checkIn && $shiftTemplate) {
            $scheduledStart = Carbon::parse($date . ' ' . $shiftTemplate->check_in_time);
            $actualStart = Carbon::parse($checkIn->log_time);
            if ($actualStart->gt($scheduledStart)) {
                $lateMinutes = $actualStart->diffInMinutes($scheduledStart);
                if ($lateMinutes <= $shiftTemplate->late_tolerance_minutes) {
                    $lateMinutes = 0;
                }
            }
        }

        if ($checkIn && $checkOut) {
            $workMinutes = Carbon::parse($checkIn->log_time)->diffInMinutes(Carbon::parse($checkOut->log_time));
        }

        $attendanceData = [
            'employee_id' => $employee->id,
            'attendance_date' => $date,
            'shift_id' => $shiftTemplate?->id,
            'check_in' => $checkIn?->log_time,
            'check_out' => $checkOut?->log_time,
            'late_minutes' => $lateMinutes,
            'early_leave_minutes' => 0,
            'work_minutes' => $workMinutes,
            'overtime_minutes' => 0,
            'attendance_status' => $status,
        ];

        if ($existing) {
            $attendance = $this->attendanceRepository->updateAttendance($existing->id, $attendanceData);
        } else {
            $attendance = $this->attendanceRepository->createAttendance($attendanceData);
        }

        foreach ($logs as $log) {
            $this->attendanceRepository->markLogAsProcessed($log->id);
        }

        return $attendance;
    }

    private function determineStatus(Employee $employee, string $date, $checkIn, $checkOut): string
    {
        if (Holiday::where('holiday_date', $date)->exists()) {
            return 'HOLIDAY';
        }
        $dayOfWeek = Carbon::parse($date)->dayOfWeek;
        if ($dayOfWeek === 0 || $dayOfWeek === 6) {
            return 'WEEKEND';
        }
        if (!$checkIn && !$checkOut) {
            return 'ABSENT';
        }
        if (!$checkIn || !$checkOut) {
            return 'INCOMPLETE';
        }
        return 'PRESENT';
    }

    public function getAttendanceReport(int $employeeId, string $startDate, string $endDate): Collection
    {
        return $this->attendanceRepository->getAttendanceByEmployee($employeeId, $startDate, $endDate);
    }

    public function getIncompleteAttendances(string $date): Collection
    {
        return $this->attendanceRepository->getIncompleteAttendances($date);
    }

    public function correctAttendance(int $attendanceId, array $data): Attendance
    {
        $data['is_corrected'] = true;
        return $this->attendanceRepository->updateAttendance($attendanceId, $data);
    }
}
