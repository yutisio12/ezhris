<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PayrollPeriod extends Model
{
    /** @use HasFactory<\Database\Factories\PayrollPeriodFactory> */
    use HasFactory;

    protected $fillable = [
        'period_name',
        'start_date',
        'end_date',
        'status',
        'processed_at',
    ];

    public function payrolls(): HasMany
    {
        return $this->hasMany(Payroll::class);
    }
}
