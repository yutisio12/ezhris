<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('overtime_approvals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('overtime_request_id')->unsigned();
            $table->bigInteger('approver_id')->unsigned();
            $table->integer('approval_level')->default(1);
            $table->string('status', 20)->default('PENDING');
            $table->text('notes')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
            $table->foreign('overtime_request_id')->references('id')->on('overtime_requests')->onDelete('cascade');
            $table->foreign('approver_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('overtime_approvals');
    }
};
