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
        Schema::table('project_supporters', function (Blueprint $table) {
            $table->integer('supporter_number')->comment('عدد الجهات الداعمة')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('project_supporters', function (Blueprint $table) {
            //
        });
    }
};
