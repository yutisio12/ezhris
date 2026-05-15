<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OvertimeApproval extends Model
{
    /** @use HasFactory<\Database\Factories\OvertimeApprovalFactory> */
    use HasFactory;

    protected $fillable = [
        'overtime_request_id',
        'approver_id',
        'approval_level',
        'status',
        'notes',
        'approved_at',
    ];

    public function overtimeRequest(): BelongsTo
    {
        return $this->belongsTo(OvertimeRequest::class, 'overtime_request_id');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'approver_id');
    }
}
