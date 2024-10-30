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
            $table->integer('p_stages')->comment('مراحل المشروع')->nullable();
            $table->integer('p_implemented_stages')->comment('مراحل المشروع المنفذة')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('p_stages');
            $table->dropColumn('p_implemented_stages');
        });
    }
};
