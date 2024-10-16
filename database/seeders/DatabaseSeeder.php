<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ProjectsTableSeeder::class,
            MemberTableSeeder::class,
            EmployeeRolesSeeder::class,
            ProjectTeamTableSeeder::class,
            RolesSeeder::class,
            AdminUserSeeder::class
        ]);
    }
}
