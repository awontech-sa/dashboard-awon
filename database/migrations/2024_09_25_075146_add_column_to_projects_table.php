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
            $table->string('p_type_beneficiaries')->nullable();
            $table->integer('p_num_beneficiaries')->nullable();
            $table->date('p_date_start')->nullable();
            $table->date('p_date_end')->nullable();
            $table->string('p_remaining')->nullable();
            $table->longText('p_description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('p_type_beneficiaries');
            $table->dropColumn('p_num_beneficiaries');
            $table->dropColumn('p_date_start');
            $table->dropColumn('p_date_end');
            $table->dropColumn('p_remaining');
            $table->dropColumn('p_description');
        });
    }
};
