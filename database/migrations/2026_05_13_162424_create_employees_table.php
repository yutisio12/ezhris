<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('employee_code', 30)->unique()->nullable(false);
            $table->string('full_name', 150)->nullable(false);
            $table->string('email', 150)->unique()->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('gender', 10)->nullable();
            $table->string('birth_place', 100)->nullable();
            $table->date('birth_date')->nullable();
            $table->string('marital_status', 20)->nullable();
            $table->string('religion', 30)->nullable();
            $table->text('address')->nullable();
            $table->date('hire_date')->nullable(false);
            $table->date('resign_date')->nullable();
            $table->string('employment_status', 20)->default('ACTIVE');
            $table->bigInteger('department_id')->unsigned()->nullable();
            $table->bigInteger('position_id')->unsigned()->nullable();
            $table->bigInteger('manager_id')->unsigned()->nullable();
            $table->decimal('basic_salary', 18, 2)->default(0);
            $table->string('bank_name', 100)->nullable();
            $table->string('bank_account_number', 100)->nullable();
            $table->string('bank_account_name', 150)->nullable();
            $table->string('npwp', 50)->nullable();
            $table->string('bpjs_number', 50)->nullable();
            $table->text('photo_url')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('set null');
            $table->foreign('position_id')->references('id')->on('positions')->onDelete('set null');
            $table->foreign('manager_id')->references('id')->on('employees')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
