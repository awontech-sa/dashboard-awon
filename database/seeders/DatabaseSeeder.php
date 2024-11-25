<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolesSeeder::class,
            AdminUserSeeder::class,
            DepartmentsSeeder::class,
            PositionsSeeder::class,
            PositionUserSeeder::class,
            PowersSectionsSeeder::class
        ]);
    }
}
