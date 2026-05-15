<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HRNotification extends Model
{
    /** @use HasFactory<\Database\Factories\HRNotificationFactory> */
    use HasFactory;

    protected $table = 'notifications';

    protected $fillable = [
        'employee_id',
        'title',
        'message',
        'is_read',
        'read_at',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
