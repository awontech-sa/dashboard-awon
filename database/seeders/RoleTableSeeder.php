<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Roles;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Roles::query()->create([
            'r_role' => 'مصمم الواجهات'
        ]);

        Roles::query()->create([
            'r_role' => 'محلل النظم'
        ]);

        Roles::query()->create([
            'r_role' => 'مبرمج'
        ]);

        Roles::query()->create([
            'r_role' => 'دعم فني'
        ]);

        Roles::query()->create([
            'r_role' => 'مسؤول التواصل'
        ]);

        Roles::query()->create([
            'r_role' => 'مدير المشروع'
        ]);
    }
}
