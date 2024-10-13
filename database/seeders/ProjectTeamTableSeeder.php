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
            'projects_id' => 1,
            'members_id' => 1,
            'roles_id' => 1
        ]);
        TeamProject::query()->create([
            'projects_id' => 1,
            'members_id' => 1,
            'roles_id' => 2
        ]);
        TeamProject::query()->create([
            'projects_id' => 1,
            'members_id' => 1,
            'roles_id' => 4
        ]);
        TeamProject::query()->create([
            'projects_id' => 1,
            'members_id' => 2,
            'roles_id' => 1
        ]);
        TeamProject::query()->create([
            'projects_id' => 1,
            'members_id' => 2,
            'roles_id' => 2
        ]);
        TeamProject::query()->create([
            'projects_id' => 1,
            'members_id' => 2,
            'roles_id' => 4
        ]);
        TeamProject::query()->create([
            'projects_id' => 1,
            'members_id' => 3,
            'roles_id' => 3
        ]);
        // لوحة تحكم عون
        TeamProject::query()->create([
            'projects_id' => 2,
            'members_id' => 1,
            'roles_id' => 2
        ]);
        TeamProject::query()->create([
            'projects_id' => 2,
            'members_id' => 2,
            'roles_id' => 1
        ]);
        TeamProject::query()->create([
            'projects_id' => 2,
            'members_id' => 3,
            'roles_id' => 3
        ]);
        // تطبيق سخي
        TeamProject::query()->create([
            'projects_id' => 3,
            'members_id' => 4,
            'roles_id' => 6
        ]);
        // نظام فرصة
        TeamProject::query()->create([
            'projects_id' => 4,
            'members_id' => 1,
            'roles_id' => 5
        ]);
        TeamProject::query()->create([
            'projects_id' => 4,
            'members_id' => 2,
            'roles_id' => 4
        ]);
        // تطبيق وعي
        TeamProject::query()->create([
            'projects_id' => 5,
            'members_id' => 1,
            'roles_id' => 6
        ]);
        TeamProject::query()->create([
            'projects_id' => 5,
            'members_id' => 1,
            'roles_id' => 5
        ]);
        // إدارة منصات مركز الهدى
        TeamProject::query()->create([
            'projects_id' => 6,
            'members_id' => 1,
            'roles_id' => 4
        ]);
        TeamProject::query()->create([
            'projects_id' => 6,
            'members_id' => 2,
            'roles_id' => 4
        ]);
        // الدليل الرقمي
        TeamProject::query()->create([
            'projects_id' => 7,
            'members_id' => 1,
            'roles_id' => 5
        ]);
        TeamProject::query()->create([
            'projects_id' => 7,
            'members_id' => 3,
            'roles_id' => 3
        ]);
        // تطبيق مكة السياحي
        TeamProject::query()->create([
            'projects_id' => 8,
            'members_id' => 2,
            'roles_id' => 1
        ]);
    }
}
