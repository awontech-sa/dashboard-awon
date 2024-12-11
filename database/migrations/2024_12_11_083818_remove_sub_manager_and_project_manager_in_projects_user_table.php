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
        Schema::dropColumns('projects_user', ['sub_project_manager', 'project_manager']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};
