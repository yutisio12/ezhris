<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payrolls', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('payroll_period_id')->unsigned();
            $table->bigInteger('employee_id')->unsigned();
            $table->decimal('basic_salary', 18, 2)->default(0);
            $table->decimal('attendance_deduction', 18, 2)->default(0);
            $table->decimal('leave_deduction', 18, 2)->default(0);
            $table->decimal('overtime_amount', 18, 2)->default(0);
            $table->decimal('allowance_amount', 18, 2)->default(0);
            $table->decimal('bonus_amount', 18, 2)->default(0);
            $table->decimal('tax_amount', 18, 2)->default(0);
            $table->decimal('bpjs_amount', 18, 2)->default(0);
            $table->decimal('gross_salary', 18, 2)->default(0);
            $table->decimal('net_salary', 18, 2)->default(0);
            $table->timestamp('generated_at')->useCurrent();
            $table->timestamps();
            $table->foreign('payroll_period_id')->references('id')->on('payroll_periods')->onDelete('cascade');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->unique(['payroll_period_id', 'employee_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};
