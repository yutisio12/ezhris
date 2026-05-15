<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeaveApproval extends Model
{
    /** @use HasFactory<\Database\Factories\LeaveApprovalFactory> */
    use HasFactory;

    protected $fillable = [
        'leave_request_id',
        'approver_id',
        'approval_level',
        'status',
        'notes',
        'approved_at',
    ];

    public function leaveRequest(): BelongsTo
    {
        return $this->belongsTo(LeaveRequest::class, 'leave_request_id');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'approver_id');
    }
}
