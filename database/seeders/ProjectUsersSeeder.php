<?php

namespace Database\Seeders;

use App\Models\ProjectUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProjectUser::create(['user_id' => 3, 'projects_id' => 1]);
        ProjectUser::create(['user_id' => 3, 'projects_id' => 2]);
    }
}
