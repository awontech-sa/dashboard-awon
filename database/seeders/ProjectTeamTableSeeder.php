<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TeamProject;

class ProjectTeamTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TeamProject::query()->create([
            'project_id' => 1,
            'member_id' => 1,
            'role_id' => 1
        ]);
        TeamProject::query()->create([
            'project_id' => 1,
            'member_id' => 1,
            'role_id' => 2
        ]);
        TeamProject::query()->create([
            'project_id' => 1,
            'member_id' => 1,
            'role_id' => 4
        ]);
        TeamProject::query()->create([
            'project_id' => 1,
            'member_id' => 2,
            'role_id' => 1
        ]);
        TeamProject::query()->create([
            'project_id' => 1,
            'member_id' => 2,
            'role_id' => 2
        ]);
        TeamProject::query()->create([
            'project_id' => 1,
            'member_id' => 2,
            'role_id' => 4
        ]);
        TeamProject::query()->create([
            'project_id' => 1,
            'member_id' => 3,
            'role_id' => 3
        ]);
        // لوحة تحكم عون
        TeamProject::query()->create([
            'project_id' => 2,
            'member_id' => 1,
            'role_id' => 2
        ]);
        TeamProject::query()->create([
            'project_id' => 2,
            'member_id' => 2,
            'role_id' => 1
        ]);
        TeamProject::query()->create([
            'project_id' => 2,
            'member_id' => 3,
            'role_id' => 3
        ]);
        // تطبيق سخي
        TeamProject::query()->create([
            'project_id' => 3,
            'member_id' => 4,
            'role_id' => 6
        ]);
        // نظام فرصة
        TeamProject::query()->create([
            'project_id' => 4,
            'member_id' => 1,
            'role_id' => 5
        ]);
        TeamProject::query()->create([
            'project_id' => 4,
            'member_id' => 2,
            'role_id' => 4
        ]);
        // تطبيق وعي
        TeamProject::query()->create([
            'project_id' => 5,
            'member_id' => 1,
            'role_id' => 6
        ]);
        TeamProject::query()->create([
            'project_id' => 5,
            'member_id' => 1,
            'role_id' => 5
        ]);
        // إدارة منصات مركز الهدى
        TeamProject::query()->create([
            'project_id' => 6,
            'member_id' => 1,
            'role_id' => 4
        ]);
        TeamProject::query()->create([
            'project_id' => 6,
            'member_id' => 2,
            'role_id' => 4
        ]);
        // الدليل الرقمي
        TeamProject::query()->create([
            'project_id' => 7,
            'member_id' => 1,
            'role_id' => 5
        ]);
        TeamProject::query()->create([
            'project_id' => 7,
            'member_id' => 3,
            'role_id' => 3
        ]);
        // تطبيق مكة السياحي
        TeamProject::query()->create([
            'project_id' => 8,
            'member_id' => 2,
            'role_id' => 1
        ]);
    }
}
