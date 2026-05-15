<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttendanceAudit extends Model
{
    /** @use HasFactory<\Database\Factories\AttendanceAuditFactory> */
    use HasFactory;

    protected $fillable = [
        'attendance_id',
        'old_check_in',
        'new_check_in',
        'old_check_out',
        'new_check_out',
        'changed_by',
        'reason',
    ];

    public function attendance(): BelongsTo
    {
        return $this->belongsTo(Attendance::class);
    }

    public function changedBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'changed_by');
    }
}
