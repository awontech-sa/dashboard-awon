<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EmployeeRoles;

class EmployeeRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EmployeeRoles::query()->create([
            'r_role' => 'مصمم الواجهات'
        ]);

        EmployeeRoles::query()->create([
            'r_role' => 'محلل النظم'
        ]);

        EmployeeRoles::query()->create([
            'r_role' => 'مبرمج'
        ]);

        EmployeeRoles::query()->create([
            'r_role' => 'دعم فني'
        ]);

        EmployeeRoles::query()->create([
            'r_role' => 'مسؤول التواصل'
        ]);

        EmployeeRoles::query()->create([
            'r_role' => 'مدير المشروع'
        ]);
    }
}
