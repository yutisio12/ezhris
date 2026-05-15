<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('approval_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('module_name', 100);
            $table->bigInteger('reference_id');
            $table->bigInteger('approver_id')->unsigned();
            $table->integer('approval_level')->default(1);
            $table->string('status', 20)->default('PENDING');
            $table->text('notes')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
            $table->foreign('approver_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('approval_histories');
    }
};
