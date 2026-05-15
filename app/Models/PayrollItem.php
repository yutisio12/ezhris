<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PayrollItem extends Model
{
    /** @use HasFactory<\Database\Factories\PayrollItemFactory> */
    use HasFactory;

    protected $fillable = [
        'payroll_id',
        'item_type',
        'item_name',
        'amount',
        'notes',
    ];

    public function payroll(): BelongsTo
    {
        return $this->belongsTo(Payroll::class, 'payroll_id');
    }
}
