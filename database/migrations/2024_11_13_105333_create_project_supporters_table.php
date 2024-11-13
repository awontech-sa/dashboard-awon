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
        Schema::create('project_supporters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->string('supporter_name')->nullable()->comment('اسم الجهة الداعمة'); // اسم الجهة الداعمة
            $table->decimal('support_amount')->nullable()->comment('إجمالي مبلغ الدعم'); // إجمالي مبلغ الدعم
            $table->integer('installments_count')->nullable()->comment('عدد الدفعات'); // عدد الدفعات
            $table->json('report_files')->nullable()->comment('ملفات التقارير'); // ملفات التقارير
            $table->json('payment_order_files')->nullable()->comment('ملفات أوامر الصرف'); // ملفات أوامر الصرف
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_supporters');
    }
};
