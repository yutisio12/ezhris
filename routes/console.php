<?php

use App\Jobs\ProcessAttendanceJob;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Daily attendance processing at 1:00 AM
Schedule::job(new ProcessAttendanceJob(now()->subDay()->format('Y-m-d')))
    ->dailyAt('01:00')
    ->name('process-daily-attendance')
    ->withoutOverlapping();

// Check for incomplete attendances at 10:00 PM
Schedule::command('attendance:check-incomplete')
    ->dailyAt('22:00')
    ->name('check-incomplete-attendance')
    ->withoutOverlapping();

// Monthly leave balance reset on 1st of each month
Schedule::command('leave:reset-balances')
    ->monthlyOn(1, '00:00')
    ->name('reset-leave-balances')
    ->withoutOverlapping();

// Cleanup old processed logs monthly
Schedule::command('attendance:cleanup-logs')
    ->monthly()
    ->name('cleanup-attendance-logs')
    ->withoutOverlapping();
