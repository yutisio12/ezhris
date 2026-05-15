<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payroll_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('payroll_id')->unsigned();
            $table->string('item_type', 20);
            $table->string('item_name', 100);
            $table->decimal('amount', 18, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->foreign('payroll_id')->references('id')->on('payrolls')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payroll_items');
    }
};
