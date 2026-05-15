<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendance_audits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('attendance_id')->unsigned();
            $table->timestamp('old_check_in')->nullable();
            $table->timestamp('new_check_in')->nullable();
            $table->timestamp('old_check_out')->nullable();
            $table->timestamp('new_check_out')->nullable();
            $table->bigInteger('changed_by')->unsigned();
            $table->text('reason')->nullable();
            $table->timestamps();
            $table->foreign('attendance_id')->references('id')->on('attendances')->onDelete('cascade');
            $table->foreign('changed_by')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendance_audits');
    }
};
