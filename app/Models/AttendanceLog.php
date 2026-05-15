<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttendanceLog extends Model
{
    /** @use HasFactory<\Database\Factories\AttendanceLogFactory> */
    use HasFactory;

    /**
     * This table is immutable - records should never be updated or deleted.
     */
    protected $fillable = [
        'employee_id',
        'log_time',
        'log_type',
        'source',
        'latitude',
        'longitude',
        'device_info',
        'selfie_url',
        'is_processed',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
