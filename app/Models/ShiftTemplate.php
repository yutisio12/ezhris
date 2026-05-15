<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShiftTemplate extends Model
{
    /** @use HasFactory<\Database\Factories\ShiftTemplateFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'check_in_time',
        'check_out_time',
        'break_start',
        'break_end',
        'late_tolerance_minutes',
        'is_flexible',
    ];

    public function employeeShifts(): HasMany
    {
        return $this->hasMany(EmployeeShift::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }
}
