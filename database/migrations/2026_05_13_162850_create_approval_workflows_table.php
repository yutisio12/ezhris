<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('approval_workflows', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('module_name', 100);
            $table->integer('approval_level')->default(1);
            $table->bigInteger('approver_role_id')->unsigned();
            $table->timestamps();
            $table->foreign('approver_role_id')->references('id')->on('roles')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('approval_workflows');
    }
};
