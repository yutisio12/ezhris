<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApprovalWorkflow extends Model
{
    /** @use HasFactory<\Database\Factories\ApprovalWorkflowFactory> */
    use HasFactory;

    protected $fillable = [
        'module_name',
        'approval_level',
        'approver_role_id',
    ];

    public function approverRole(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'approver_role_id');
    }
}
