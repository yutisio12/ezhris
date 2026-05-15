<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shift_templates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 100);
            $table->time('check_in_time');
            $table->time('check_out_time');
            $table->time('break_start')->nullable();
            $table->time('break_end')->nullable();
            $table->integer('late_tolerance_minutes')->default(0);
            $table->boolean('is_flexible')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shift_templates');
    }
};
