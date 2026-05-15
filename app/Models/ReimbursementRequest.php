<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReimbursementRequest extends Model
{
    /** @use HasFactory<\Database\Factories\ReimbursementRequestFactory> */
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'reimbursement_date',
        'amount',
        'description',
        'attachment_url',
        'status',
        'approved_by',
        'approved_at',
        'rejection_reason',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'approved_by');
    }
}
