<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttendanceCorrection extends Model
{
    /** @use HasFactory<\Database\Factories\AttendanceCorrectionFactory> */
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'attendance_id',
        'correction_date',
        'requested_check_in',
        'requested_check_out',
        'correction_type',
        'reason',
        'attachment_url',
        'status',
        'requested_at',
        'approved_by',
        'approved_at',
        'rejection_reason',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function attendance(): BelongsTo
    {
        return $this->belongsTo(Attendance::class);
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'approved_by');
    }
}
