<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leave_balances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('employee_id')->unsigned();
            $table->bigInteger('leave_type_id')->unsigned();
            $table->integer('year');
            $table->decimal('total_quota', 5, 2)->default(0);
            $table->decimal('used_quota', 5, 2)->default(0);
            $table->decimal('remaining_quota', 5, 2)->default(0);
            $table->timestamps();
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('leave_type_id')->references('id')->on('leave_types')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leave_balances');
    }
};
