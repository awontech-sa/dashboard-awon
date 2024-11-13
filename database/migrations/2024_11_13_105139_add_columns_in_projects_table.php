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
        Schema::table('projects', function (Blueprint $table) {
            $table->decimal('total_cost')->nullable()->comment('التكلفة الإجمالية'); // التكلفة الإجمالية
            $table->decimal('expected_cost')->nullable()->comment('التكلفة المتوقعة'); // التكلفة المتوقعة في حالة دعم جزئي أو ملكية جمعية
            $table->decimal('actual_cost')->nullable()->comment('التكلفة الفعلية'); // التكلفة الفعلية في حالة دعم جزئي أو ملكية جمعية
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            //
        });
    }
};
