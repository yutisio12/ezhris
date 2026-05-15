<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('overtime_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('employee_id')->unsigned();
            $table->date('overtime_date');
            $table->timestamp('start_time');
            $table->timestamp('end_time');
            $table->integer('total_minutes')->default(0);
            $table->text('reason')->nullable();
            $table->text('attachment_url')->nullable();
            $table->string('status', 20)->default('PENDING');
            $table->timestamp('requested_at')->useCurrent();
            $table->bigInteger('approved_by')->unsigned()->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->timestamps();
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('approved_by')->references('id')->on('employees')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('overtime_requests');
    }
};
