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
        Schema::create('installments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_supporter_id')->nullable()->constrained('project_supporters')->onDelete('cascade'); // في حالة الدعم
            $table->foreignId('project_id')->nullable()->constrained('projects')->onDelete('cascade'); // في حالة الملكية الخارجية
            $table->integer('installment_number')->nullable()->comment('رقم الدفعة'); // رقم الدفعة
            $table->decimal('installment_amount')->nullable()->comment('قيمة الدفعة'); // قيمة الدفعة
            $table->json('receipt_proof')->nullable(); // إثبات استلام الدفعة
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('installments');
    }
};
