<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApprovalHistory extends Model
{
    /** @use HasFactory<\Database\Factories\ApprovalHistoryFactory> */
    use HasFactory;

    protected $fillable = [
        'module_name',
        'reference_id',
        'approver_id',
        'approval_level',
        'status',
        'notes',
        'approved_at',
    ];

    public function approver(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'approver_id');
    }
}
