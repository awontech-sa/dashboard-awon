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
        Schema::create('project_phases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->string('phase_name')->nullable()->comment('اسم المرحلة'); // اسم المرحلة
            $table->decimal('phase_cost')->nullable()->comment('تكلفة المرحلة'); // تكلفة المرحلة
            $table->string('disbursement_proof')->nullable()->comment('إثبات الصرف'); // إثبات الصرف
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_phases');
    }
};
