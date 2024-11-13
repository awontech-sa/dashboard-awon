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
            $table->dropColumn('p_status');
            $table->dropColumn('p_files');
            $table->dropColumn('p_comment');
            $table->dropColumn('p_level');
            $table->dropColumn('p_web');
            $table->dropColumn('p_ios');
            $table->dropColumn('p_android');
            $table->dropColumn('p_support_entity');
            $table->dropColumn('p_stages');
            $table->dropColumn('p_implemented_stages');
            $table->dropColumn('p_support_type');
            $table->dropColumn('p_support_status');

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
