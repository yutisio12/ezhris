<?php

namespace App\Jobs;

use App\Models\Employee;
use App\Models\HRNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        protected int $employeeId,
        protected string $title,
        protected string $message
    ) {}

    public function handle(): void
    {
        HRNotification::create([
            'employee_id' => $this->employeeId,
            'title' => $this->title,
            'message' => $this->message,
        ]);
    }
}
